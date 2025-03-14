<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #calendar {
            float: left;
            width: 800px;
            height: 650px;
            margin: 40px 20px;
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
        .fc-event-title {
            font-size: 12px;
            color: #4a4a4a;
            font-weight: bold;
            text-transform: uppercase;
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
            font-weight: bold;
        }
        .fc-daygrid-event {
            position: relative;
        }

        .fc-daygrid-event:hover::after {
            content: attr(data-tooltip); /* Kunin ang info mula sa data-tooltip */
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 8px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }

    </style>
</head>
<body>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 end-0" role="alert">
            {{ session('success') }}
        </div>
    @endif 

    <div id="calendar"></div>

    <!-- Modal -->
    <div id="event-modal">
        <h3 id="event-title" class="text-uppercase text-center"></h3>
        <p><strong>Name:</strong> <span id="event-name"></span></p>
        <p><strong>Date:</strong> <span id="event-date"></span></p>
        <p><strong>Check-in:</strong> <span id="event-check_in"></span></p>
        <p><strong>Check-out:</strong> <span id="event-check_out"></span></p>
        <p><strong>Room Type:</strong> <span id="event-room_type"></span></p> 
        <button onclick="closeModal()">Close</button>
    </div>

    <div class="position-fixed bottom-0 end-0 mb-4 me-5">
        <button onclick="window.location.href='{{ route('selectPackage') }}'" class="btn btn-primary">Reserve Now</button>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        if (!calendarEl) {
            console.error("Calendar element not found!");
            return;
        }

        const userId = @json($userId); // Get logged-in user ID
        const allEvents = @json($events);

        console.log("Fetched Events:", allEvents);

        try {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: allEvents.map(event => ({
                    ...event,
                    color: event.extendedProps.is_owner ? '#4CAF50' : '#B0B0B0', // Green for own reservation, Gray for others
                    textColor: 'black',
                })),
                eventClick: function(info) {
                    let event = info.event;

                    console.log("Clicked Event:", event.extendedProps);

                    if (event.extendedProps.is_owner) {
                        document.getElementById("event-title").textContent = "Your Reservation";
                        document.getElementById("event-name").innerHTML = `<strong>Name:</strong> ${event.extendedProps.name || "N/A"}`;
                        document.getElementById("event-date").innerHTML = `<strong>Date:</strong> ${event.start.toLocaleDateString()}`;
                        document.getElementById("event-check_in").innerHTML = `<strong>Check-in:</strong> ${event.extendedProps.check_in || "N/A"}`;
                        document.getElementById("event-check_out").innerHTML = `<strong>Check-out:</strong> ${event.extendedProps.check_out || "N/A"}`;
                        document.getElementById("event-room_type").innerHTML = `<strong>Room Type:</strong> ${event.extendedProps.package_room_type || "N/A"}`;

                        document.getElementById("event-modal").style.display = "block";
                    } else {
                        alert("This date is already reserved.");
                    }
                }
            });

            calendar.render();
        } catch (error) {
            console.error("Error initializing FullCalendar:", error);
        }
    });

    function closeModal() {
        document.getElementById('event-modal').style.display = 'none';
    }
</script>



</body>
</html>
