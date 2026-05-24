@extends('layouts.master')

@section('title', 'Kalender Tugas')
@section('page-title', 'Kalender Tugas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.tasks.index') }}">Tugas</a></li>
    <li class="breadcrumb-item active">Kalender</li>
@endsection

@push('styles')
{{-- FullCalendar CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
<style>
    /* =========================================================
       FullCalendar Modern Minimalist Theme Overrides
       ========================================================= */
    :root {
        --fc-border-color: #E2E8F0; /* Garis grid lebih soft */
        --fc-today-bg-color: #ECFDF5; /* Background hari ini hijau sangat muda */
        
        /* Tema Tombol Kustom (Warna Hijau Utama) */
        --fc-button-bg-color: #1D9E75;
        --fc-button-border-color: #1D9E75;
        --fc-button-hover-bg-color: #0F6E56;
        --fc-button-hover-border-color: #0F6E56;
        --fc-button-active-bg-color: #0F6E56;
        --fc-button-active-border-color: #0F6E56;
    }

    /* Memaksa font kalender mengikuti font aplikasi */
    #calendar {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Header Toolbar Kalender (Bulan & Tombol) */
    .fc-toolbar-title {
        font-weight: 700 !important;
        font-size: 1.35rem !important;
        color: #1E293B;
    }
    
    .fc .fc-button {
        border-radius: 8px; /* Tombol agak membulat */
        font-weight: 600;
        text-transform: capitalize;
        padding: 0.4rem 1rem;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }
    
    .fc .fc-button-primary:not(:disabled):active, 
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #0F6E56;
        border-color: #0F6E56;
    }

    /* Header Hari (Senin, Selasa, dsb) */
    .fc-col-header-cell {
        background-color: #F8FAFC;
        padding: 10px 0;
    }
    .fc-col-header-cell-cushion {
        color: #64748B;
        font-weight: 600;
        font-size: 13.5px;
        text-decoration: none !important;
    }

    /* Angka Tanggal */
    .fc-daygrid-day-number {
        font-weight: 500;
        font-size: 13.5px;
        color: #475569;
        text-decoration: none !important;
        padding: 8px !important;
    }

    /* Styling Tampilan Event / Tugas */
    .fc-event {
        border: none !important;
        border-radius: 6px !important;
        padding: 3px 6px;
        margin-bottom: 3px;
        cursor: pointer;
        transition: transform 0.1s ease;
    }
    .fc-event:hover {
        transform: scale(1.02);
        opacity: 0.9;
    }
    .fc-event-title {
        font-weight: 600 !important;
        font-size: 11.5px;
    }
    .fc-event-time {
        font-size: 11px;
        font-weight: 400;
    }

    /* Rapihkan Card AdminLTE */
    .card-calendar {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
</style>
@endpush

@section('content')
<div class="card card-calendar">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
        <h3 class="card-title text-dark" style="font-weight: 700; font-size:16px;">
            <i class="fas fa-calendar-alt mr-2" style="color: #1D9E75;"></i> Jadwal & Deadline
        </h3>
    </div>
    <div class="card-body p-4">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',          // Bahasa Indonesia
        height: 'auto',        // Mencegah kalender terlalu panjang dan scroll di dalam card
        contentHeight: 650,    // Tinggi ideal
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'Daftar'
        },
        events: '{{ route("user.tasks.calendar.events") }}',  // Fetch JSON dari Controller
        eventDisplay: 'block', // Membuat event memblok penuh (tidak hanya titik bulat)
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        },
        eventDidMount: function(info) {
            // Tambahkan tooltip dengan judul task
            info.el.title = info.event.title;
        }
    });
    calendar.render();
});
</script>
@endpush