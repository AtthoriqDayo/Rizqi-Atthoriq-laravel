<x-app-layout>
    <style>
        .fc-day-today {
            background-color: rgba(22, 163, 74, 0.4) !important;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="py-12">
        {{-- CDN untuk FullCalendar --}}
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-black/20 backdrop-blur-lg overflow-hidden shadow-sm sm:rounded-lg border-2 border-white/70">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{-- Div ini akan menjadi kalender --}}
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    editable: true,
                    selectable: true,
                    // FullCalendar akan otomatis menggunakan fetch/axios untuk ini, biarkan seperti ini
                    events: '/api/events',

                    select: function(info) {
                        let title = prompt('Enter Event Title:');
                        if (title) {
                            // Menggunakan axios untuk POST
                            axios.post('/api/events', {
                                title: title,
                                start: info.startStr,
                                end: info.endStr
                            })
                            .then(function (response) {
                                calendar.addEvent(response.data); // Tambahkan event baru ke kalender
                            })
                            .catch(function (error) {
                                alert('Could not create event.');
                            });
                        }
                        calendar.unselect();
                    },

                    eventChange: function(info) {
                        if (!confirm("Are you sure about this change?")) {
                            info.revert();
                            return;
                        }
                        // Menggunakan axios untuk PUT
                        axios.put(`/api/events/${info.event.id}`, {
                            title: info.event.title,
                            start: info.event.startStr,
                            end: info.event.endStr
                        });
                    },

                    eventClick: function(info) {
                        if (confirm("Are you sure you want to delete this event?")) {
                            info.event.remove(); // Hapus dari tampilan
                            // Menggunakan axios untuk DELETE
                            axios.delete(`/api/events/${info.event.id}`);
                        }
                    }
                });
                calendar.render();
            });
        </script>
    </div>
</x-app-layout>
