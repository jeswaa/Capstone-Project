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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    #calendar {
        background-color: #97a97c !important;
        color: white !important; /* Ensures text is visible */
    }
    .fc-daygrid-event {
        background-color: #4a4a4a !important; 
    }
    .fc-event-title {
        font-size: 13px !important;
        font-weight: bold !important;
        text-align: center !important;
        color: white !important;
    }
    .fc-daygrid-day-number {
        color: white !important;
        text-decoration: none !important;
    }
    .fc-col-header-cell-cushion {
        color: white !important;
        text-decoration: none !important;
    }
    .fc-prev-button, .fc-next-button {
        background-color: #4a4a4a !important;
    }
</style>

<body class="bg-light font-paragraph">

    <!-- Navbar -->
    <div class="container d-flex justify-content-end mt-5">
        <div>
            <a href="{{ route('profile') }}" title="Your Profile" class="text-dark text-decoration-none">
                <i class="fa-circle-user fa-solid fs-1"></i>
            </a>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <!-- Calendar -->
            <div class="col-12 col-lg-8 col-md-10">
                <div id="calendar" class="bg-white border p-3 rounded shadow"></div>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    
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
