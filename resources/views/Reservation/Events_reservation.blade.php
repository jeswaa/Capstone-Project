<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    #calendar {
        width: 100% !important;
        max-width: 65vw !important;
        height: 80vh !important;
        background-color: white !important;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        #calendar {
            width: 95vw !important;
            height: 70vh !important;
            padding: 10px;
        }
    }

    /* Calendar Header */
    .fc-toolbar-title {
        font-size: 20px !important;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .fc-toolbar-title {
            font-size: 18px !important;
        }
    }

    @media (max-width: 480px) {
        .fc-toolbar-title {
            font-size: 16px !important;
        }
    }

    .fc-prev-button, .fc-next-button {
        background-color: #0b573d !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 5px 10px !important;
    }

    /* Day Grid */
    .fc-daygrid-day {
        border: 1px solid #ddd !important;
        transition: background-color 0.2s;
    }

    .fc-daygrid-day:hover {
        background-color: #f0f0f0 !important;
    }

    /* Weekend Highlight */
    .fc-day-sun, .fc-day-sat {
        background-color: #f8f9fa !important;
    }

    /* Current Day Highlight */
    .fc-day-today {
        background-color: #0b573d !important;
        color: black !important;
        font-weight: bold !important;
    }

    /* Events */
    .fc-daygrid-event {
        background-color: #0b573d !important;
        border-radius: 5px !important;
        padding: 2px 5px !important;
        font-size: 12px !important;
        font-weight: bold !important;
        text-align: center !important;
        color: white !important;
    }

    /* Event Title */
    .fc-event-title {
        font-size: 13px !important;
        font-weight: bold !important;
        color: white !important;
    }

    /* Day Number */
    .fc-daygrid-day-number {
        font-weight: bold;
        color: black !important;
    }
</style>



<body class="bg-light font-paragraph" style="background: url('{{ asset('images/logosheesh.png') }}') no-repeat center center fixed; background-size: cover;">

    <!-- Navbar -->
    <div class="container d-flex justify-content-between mt-5">
        <div>
            <a href="{{ route('profile') }}" title="Your Profile" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-user text-white"></i>
                </div>
            </a>
        </div>
        <div>
            <a href="{{ url('/') }}" title="Home" class="text-decoration-none">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="" style="width: 130px; height: 120px">
                </div>
            </a>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <!-- Calendar -->
            <div class="col-12 col-lg-8 col-md-10">
                <div id="calendar" class="bg-white border p-3 rounded shadow"></div>
                <div class="mt-3 text-center">
                    <button class="btn btn-success w-50 border border-2 border-dark rounded-5" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">RESERVE NOW </button>
                </div>
            </div>
        </div>
    </div>


 <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Reservation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="event-name"></span></p>
                    <p><strong>Date:</strong> <span id="event-date"></span></p>
                    <p><strong>Check-in:</strong> <span id="event-check_in"></span></p>
                    <p><strong>Check-out:</strong> <span id="event-check_out"></span></p>
                    <p><strong>Package:</strong> <span id="event-room_type"></span></p>
                    <p><strong>Rooms:</strong> <span id="event-accommodations"></span></p>
                    <p><strong>Activities:</strong> <span id="event-activities"></span></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const allEvents = @json($events);

    console.log("Events received:", allEvents); // 🛠️ Debug: Check if `start` is correct

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: allEvents.map(event => ({
            title: event.title,
            start: event.start, // ✅ Only start date is displayed
            allDay: true, // ✅ Prevents time from appearing
            color: event.extendedProps.is_owner ? '#97a97c' : '#4a4a4a',
            textColor: 'white',
        })),
        dateClick: function(info) {
            let selectedDate = info.dateStr;
            let today = new Date().toISOString().split('T')[0];

            if (selectedDate <= today) {
                Swal.fire("Invalid Selection", "You cannot select past dates.", "warning");
                return;
            }

            let isBooked = allEvents.some(event => event.start === selectedDate);

            if (!isBooked) {
                sessionStorage.setItem("selectedDate", selectedDate);
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
                Swal.fire("Unavailable Date", "This date is already reserved. Please choose another date.", "error");
            }
        }
    });

    calendar.render();
});


    </script>


</body>
</html>

