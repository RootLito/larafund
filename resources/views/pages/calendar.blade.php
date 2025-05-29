@extends('layout.app')

@section('title', 'Calendar')

@section('content')
    <div class="flex-1 p-10">
        <div class="w-full h-full bg-white p-10 rounded-lg ">
            <div id='calendar'></div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script>
@endsection
