<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #calendar {
            float: left;
            width: 1000px;
            height: 650px;
            margin: 50px 20px;
        }
        #event-modal {
            display: none;
            position: fixed;
            top: 25%;
            right: 20px;
            background: #b5c99a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            width: 450px;
            height: auto;
        }
        .reserved-day {
            background-color: #414141 !important;
            border-radius: 5px;
            cursor: pointer;
        }
        .fc-event {
            border: none !important;
            color: black !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .fc-event-title {
            font-size: 12px;
            color: #e5f9db;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .fc-toolbar-title {
            font-size: 20px;
            color: #4a4a4a;
            font-family: "Montserrat", serif !important;
            text-transform: uppercase;
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
            content: attr(data-tooltip);
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
        .fc-day-today {
            background-color: #fff !important; /* Light green */
        }        
        .position-fixed.bottom-0.end-0.mb-4.me-5 button {
            width: 400px; /* Adjust this value as needed */
        }
        .disabled-date {
            pointer-events: none; /* Disable click */
            background-color: #e0e0e0 !important; /* Gray out */
            color: #a0a0a0 !important; /* Lighten text */
            opacity: 0.6;
            cursor: not-allowed;
        }

    </style>
</head>
<body>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 end-0 mt-3 me-3 z-2" role="alert" style="animation: fadeOut 5s forwards;">
            {{ session('success') }}
            <style>
                @keyframes fadeOut {
                    0% {
                        opacity: 1;
                    }
                    100% {
                        opacity: 0;
                    }
                }
            </style>
        </div>
    @endif 
    
    
    <div style="position: absolute; right: 20px; top: 50px;" title="Your Profile">
        <a href="{{ route('profile') }}"><i class="fa-solid fa-circle-user fs-1 text-color-1 icon-hover"></i></a>
    </div>
        
        <!-- Left: Calendar -->
        <div id="calendar" class="color-background4 p-4 rounded-3" >
        
        </div>
        <div style="position: absolute; right: 420px; top: 50px;">
            <h1 class="fs-3">Logo</h1>
        </div>  
        <!-- Right: Centered Image -->
        <div style="position: absolute; right: 0px; top: 130px; width: 500px;" class="d-flex justify-content-center mt-5">
            <img src="{{ asset('images/Searching - Looking.png') }}" alt="Searching" class="w-75">
        </div>
        


    </div>
    <!-- Modal -->
    <div id="event-modal">
        <h3 id="event-title" class="text-center font-heading fw-bold"></h3>
        <p><strong class="font-heading">Name:</strong> <span id="event-name" class="text-color-1 font-paragraph"></span></p>
        <p><strong class="font-heading">Date:</strong> <span id="event-date" class="text-color-1 font-paragraph"></span></p>
        <p><strong class="font-heading">Check-in:</strong> <span id="event-check_in" class="text-color-1 font-paragraph"></span></p>
        <p><strong class="font-heading">Check-out:</strong> <span id="event-check_out" class="text-color-1 font-paragraph"></span></p>
        <p><strong class="font-heading">Package:</strong> <span id="event-room_type" class="text-color-1 font-paragraph"></span></p> 
        <p><strong class="font-heading">Rooms:</strong> <span id="event-accommodations" class="text-color-1 font-paragraph"></span></p>
        <p><strong class="font-heading">Activities:</strong> <span id="event-activities" class="text-color-1 font-paragraph"></span></p>
        <button class="w-100 border-0 p-2 color-background5 font-paragraph text-color-3 fw-semibold rounded text-hover-1" onclick="closeModal()">Close</button>
    </div>

    <div class="position-fixed bottom-0 end-0 mb-4 me-5">
        <button onclick="window.location.href='{{ route('selectPackage') }}'" class="text-hover-1 color-background6 p-2 border-0 font-paragraph fw-semibold rounded-3">Reserve Now</button>
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
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

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
                    color: event.extendedProps.is_owner ? '#97a97c' : '#4a4a4a',
                    textColor: 'black',
                })),
                dateClick: function(info) {
                    let selectedDate = info.dateStr;

                    // Debugging: Check if selectedDate is correct
                    console.log("Clicked Date:", selectedDate);  

                    // Disable selection for past dates and today
                    if (selectedDate <= today) {
                        Swal.fire({
                            title: "Invalid Selection",
                            text: "You cannot select past dates.",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });
                        return;
                    }

                    // Check if the date is already booked
                    let isBooked = allEvents.some(event => event.start === selectedDate);

                    if (!isBooked) {
                        // Save selected date in session storage
                        sessionStorage.setItem("selectedDate", selectedDate);

                        // SweetAlert2 custom dialog
                        Swal.fire({
                            title: "This date is available!",
                            text: "Select a reservation type:",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonText: "⚙️ Custom Package",
                            cancelButtonText: "📅 Fixed Package",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('selectPackageCustom') }}?date=" + selectedDate;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = "{{ route('selectPackage') }}?date=" + selectedDate;
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Unavailable Date",
                            text: "This date is already reserved. Please choose another date.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                },
                dayCellDidMount: function(info) {
                    let cellDate = info.date.toISOString().split('T')[0];
                    if (cellDate < today) {
                        info.el.classList.add('disabled-date');
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