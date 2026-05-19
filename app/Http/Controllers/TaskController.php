<?php

namespace App\Http\Controllers;
 
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
 
class TaskController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $tasks = Task::latest()->paginate(15);
        return view('tasks.index', compact('tasks'));
    }
 
    public function create(): \Illuminate\View\View
    {
        return view('tasks.create');
    }
 
    public function store(StoreTaskRequest $request): \Illuminate\Http\RedirectResponse
    {
        Task::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);
 
        return redirect()->route('user.tasks.index')
                         ->with('success', 'Tugas berhasil ditambahkan!');
    }
 
    public function show(Task $task): \Illuminate\View\View
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
 
        return view('tasks.show', compact('task'));
    }
 
    public function edit(Task $task): \Illuminate\View\View
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
 
        return view('tasks.edit', compact('task'));
    }
 
    public function update(StoreTaskRequest $request, Task $task): \Illuminate\Http\RedirectResponse
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
 
        $task->update($request->validated());
 
        return redirect()->route('user.tasks.index')
                         ->with('success', 'Tugas berhasil diperbarui!');
    }
 
    public function destroy(Task $task): \Illuminate\Http\RedirectResponse
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
 
        $task->delete();
 
        return redirect()->route('user.tasks.index')
                         ->with('success', 'Tugas berhasil dihapus!');
    }
 
    public function calendar(): \Illuminate\View\View
    {
        return view('tasks.calendar');
    }
 
    public function calendarEvents(Request $request): \Illuminate\Http\JsonResponse
    {
        $tasks = Task::whereNotNull('due_date')
            ->whereIn('status', ['pending', 'in_progress'])
            ->get()
            ->map(fn($task) => [
                'id'              => $task->id,
                'title'           => $task->title,
                'start'           => $task->due_date->toDateString(),
                'backgroundColor' => match($task->priority) {
                    'high'   => '#dc3545',
                    'medium' => '#ffc107',
                    'low'    => '#28a745',
                    default  => '#6c757d',
                },
                'borderColor'     => match($task->priority) {
                    'high'   => '#c82333',
                    'medium' => '#e0a800',
                    'low'    => '#1e7e34',
                    default  => '#545b62',
                },
                'textColor'       => $task->priority === 'medium' ? '#212529' : '#ffffff',
                'extendedProps'   => [
                    'status'      => $task->status,
                    'priority'    => $task->priority,
                    'description' => $task->description,
                ],
                'url'             => route('user.tasks.show', $task->id),
            ]);
 
        return response()->json($tasks);
    }
}
