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
@endpush
 
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar mr-2"></i>Kalender Deadline Tugas</h3>
    </div>
    <div class="card-body">
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
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '{{ route("user.tasks.calendar.events") }}',  // Fetch JSON dari Controller
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