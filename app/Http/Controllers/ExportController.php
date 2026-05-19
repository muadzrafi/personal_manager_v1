<?php

namespace App\Http\Controllers;
 
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
 
class ExportController extends Controller
{
    /**
     * Export laporan keuangan ke PDF
     * GET /app/financial/export/pdf?month=2025-01&category=all
     */
    public function exportPdf(Request $request)
    {
        $data = $this->getExportData($request);
 
        // Render view ke PDF menggunakan DomPDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('exports.financial_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
 
        $filename = 'laporan-keuangan-' . $data['filterMonth'] . '.pdf';
 
        return $pdf->download($filename);
    }
 
    /**
     * Export laporan keuangan ke Excel
     * GET /app/financial/export/excel?month=2025-01&category=all
     */
    public function exportExcel(Request $request)
    {
        $data    = $this->getExportData($request);
        $records = $data['records'];
        $month   = $data['filterMonth'];
 
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Keuangan');
 
        // ─── Header Laporan ───────────────────────────────────
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN — ' . strtoupper(\Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y')));
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
 
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Pemilik: ' . auth()->user()->name . ' | Diekspor: ' . now()->format('d M Y H:i'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
 
        // ─── Summary ──────────────────────────────────────────
        $sheet->setCellValue('A4', 'Total Pemasukan');
        $sheet->setCellValue('B4', $data['totalIncome']);
        $sheet->getStyle('B4')->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle('B4')->getFont()->getColor()->setRGB('1E7E34');
 
        $sheet->setCellValue('A5', 'Total Pengeluaran');
        $sheet->setCellValue('B5', $data['totalExpense']);
        $sheet->getStyle('B5')->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle('B5')->getFont()->getColor()->setRGB('C82333');
 
        $sheet->setCellValue('A6', 'Saldo');
        $sheet->setCellValue('B6', $data['balance']);
        $sheet->getStyle('B6')->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle('A4:B6')->getFont()->setBold(true);
 
        // ─── Header Tabel ─────────────────────────────────────
        $headers = ['No', 'Tanggal', 'Tipe', 'Kategori', 'Keterangan', 'Jumlah (Rp)'];
        $col     = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '8', $header);
            $col++;
        }
        $sheet->getStyle('A8:F8')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '343A40']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
 
        // ─── Data Rows ────────────────────────────────────────
        $row = 9;
        foreach ($records as $i => $rec) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $rec->recorded_at->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $rec->type === 'income' ? 'Pemasukan' : 'Pengeluaran');
            $sheet->setCellValue('D' . $row, ucfirst($rec->category));
            $sheet->setCellValue('E' . $row, $rec->description);
            $sheet->setCellValue('F' . $row, (float) $rec->amount);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0');
 
            // Warna row berdasarkan tipe
            $color = $rec->type === 'income' ? 'D4EDDA' : 'F8D7DA';
            $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                  ->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setRGB($color);
 
            $row++;
        }
 
        // ─── Border semua sel ─────────────────────────────────
        $sheet->getStyle('A8:F' . ($row - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'DEE2E6'],
                ],
            ],
        ]);
 
        // ─── Auto width kolom ─────────────────────────────────
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }
 
        // ─── Output ───────────────────────────────────────────
        $filename = 'laporan-keuangan-' . $month . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
 
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
 
    /**
     * Helper: ambil data yang sama untuk PDF & Excel
     */
    private function getExportData(Request $request): array
    {
        $month    = $request->input('month', now()->format('Y-m'));
        $category = $request->input('category', 'all');
        $type     = $request->input('type', 'all');
 
        [$year, $mon] = explode('-', $month);
 
        $query = FinancialRecord::query()
            ->whereYear('recorded_at', $year)
            ->whereMonth('recorded_at', $mon)
            ->orderBy('recorded_at');
 
        if ($category !== 'all') $query->where('category', $category);
        if ($type !== 'all')     $query->where('type', $type);
 
        $records = $query->get();
 
        $totalIncome  = $records->where('type', 'income')->sum('amount');
        $totalExpense = $records->where('type', 'expense')->sum('amount');
 
        return [
            'records'      => $records,
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance'      => $totalIncome - $totalExpense,
            'filterMonth'  => $month,
            'filterCat'    => $category,
            'user'         => auth()->user(),
        ];
    }
}