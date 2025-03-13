<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #calendar {
            position: absolute;
            left: 30px;
            width: 1000px;
            height: 650px;
            margin: 40px auto;
        }
        #event-modal {
            display: none;
            position: fixed;
            top: 10%;
            right: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            width: 450px;
            height: auto;
        }
        .fc-h-event .fc-event-title{    
            display: block;
        }
        .reserved-day {
            background-color: #97a97c !important;
            border-radius: 5px;
            cursor: pointer;
        }
        .fc-event {
            background-color: #97a97c !important;
            border: none !important;
            color: black !important;
        }
        .fc-event-title, .fc-event-name, .fc-event-date, .fc-event-time {
            font-family: "Montserrat", serif !important;
            text-align: center;
        }
        .fc-event-title {
            font-size: 12px;
            color: #4a4a4a;
            text-transform: uppercase;
            font-weight: bold;
            
        }
        .fc-event-name {
            font-size: 10px;
            color: #b5c99a;
            font-weight: bold;
        }
        .fc-event-date, .fc-event-time {
            font-size: 12px;
        }
        .fc-toolbar-title {
            font-size: 20px;
            color: #b5c99a;
        }
        .fc-daygrid-day-number, .fc-col-header-cell-cushion {
            color: #4a4a4a !important;
        }
        .fc-today-button, .fc-button {
            background-color: #718355 !important;
            border-color: #718355 !important;
            color: #e5f9db !important;
            font-family: "Montserrat", serif !important;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
        }
        .fc-today-button:hover, .fc-button:hover {
            background-color: #5a6b47 !important;
            border-color: #5a6b47 !important;
        }
        .fc-button:active, .fc-button.fc-button-active {
            background-color: #4a5a3a !important;
            border-color: #4a5a3a !important;
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 end-0" role="alert" style="animation: fadeOut 5s forwards;">
            {{ session('success') }}
        </div>
    @endif 
    <div id="calendar"></div>

    <div id="event-modal">
        <h3 id="event-title" class="color-4 text-uppercase font-heading fs-2 text-center ls-5"></h3>
        <p><strong class="font-paragraph">Name:</strong> <span id="event-name" class="font-paragraph"></span></p>
        <p><strong>Date:</strong> <span id="event-date"></span></p>
        <p><strong>Check-in:</strong> <span id="event-check_in"></span></p>
        <p><strong>Check-out:</strong> <span id="event-check_out"></span></p>
        <p><strong>Room Type:</strong> <span id="event-room_type"></span></p> 
        <button onclick="closeModal()">Close</button>
    </div>

    <div class="position-absolute top-0 end-0 me-3 mt-4">
        <a href="{{ route('profile') }}" title="Go to Profile">
            <i class="fa-regular fa-circle-user fs-2 text-color-1"></i>
        </a>
    </div>

    <div class="position-fixed bottom-0 end-0 mb-4 me-5 w-25">
        <button onclick="window.location.href='{{ route('selectPackage') }}'" class="btn btn-primary">Reserve Now</button>
    </div>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const events = @json($events); // Laravel variable for reservations

    console.log("Fetched Events:", events); // Debugging - Check fetched events

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events,
        eventDisplay: 'block',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        },
        eventContent: function (arg) {
            let event = arg.event;
            let title = document.createElement('div');
            title.classList.add('fc-event-title');
            title.innerText = event.title;

            let name = document.createElement('div');
            name.classList.add('fc-event-name');
            name.innerText = `Name: ${event.extendedProps.name || 'N/A'}`;

            let reservationDate = document.createElement('div');
            reservationDate.classList.add('fc-event-date');
            reservationDate.innerText = `${new Date(event.start).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) || 'N/A'}`;

            let reservationCheckIn = document.createElement('div');
            reservationCheckIn.classList.add('fc-event-time');
            reservationCheckIn.innerText = `Check-in: ${event.extendedProps.check_in || 'N/A'}`;

            let reservationCheckOut = document.createElement('div');
            reservationCheckOut.classList.add('fc-event-time');
            reservationCheckOut.innerText = `Check-out: ${event.extendedProps.check_out || 'N/A'}`;

            let roomType = document.createElement('div');
            roomType.classList.add('fc-event-room');
            roomType.innerText = `Room Type: ${event.extendedProps.package_room_type || 'N/A'}`;

            return { domNodes: [title, name, reservationDate, reservationCheckIn, reservationCheckOut, roomType] };
        },
        dayCellDidMount: function (info) {
            let cellDate = new Date(info.date).toLocaleDateString();

            let hasReservation = events.some(event => {
                let eventDate = new Date(event.start).toLocaleDateString();
                return eventDate === cellDate;
            });

            if (hasReservation) {
                info.el.classList.add("reserved-day");

                // Add hover effect
                info.el.addEventListener('mouseenter', () => {
                    const reservedEvents = events.filter(event => new Date(event.start).toLocaleDateString() === cellDate);
                    if (reservedEvents.length > 0) {
                        const event = reservedEvents[0];
                        document.getElementById('event-title').innerText = event.title;
                        document.getElementById('event-name').innerText = event.extendedProps.name || 'N/A';
                        document.getElementById('event-date').innerText = new Date(event.start).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) || 'N/A';
                        document.getElementById('event-check_in').innerText = event.extendedProps.check_in || 'N/A';
                        document.getElementById('event-check_out').innerText = event.extendedProps.check_out || 'N/A';
                        document.getElementById('event-room_type').innerText = event.extendedProps.package_room_type || 'N/A';
                        document.getElementById('event-modal').style.display = 'block';
                    }
                });

                info.el.addEventListener('mouseleave', () => {
                    document.getElementById('event-modal').style.display = 'none';
                });
            }
        }
    });

    calendar.render();
});

    </script>

</body>
</html>



