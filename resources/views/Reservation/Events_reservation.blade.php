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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    #calendar {
        background-color: #97a97c !important;
        color: white !important;
    }
    .fc-event-title {
        font-size: 13px !important;
        font-weight: bold !important;
        text-align: center !important;
    }
    .fc-daygrid-day-number {
        color: white !important;
        text-decoration: none !important;
    }
    .fc-col-header-cell-cushion {
        color: white !important;
    }
    .fc-prev-button, .fc-next-button {
        background-color: #4a4a4a !important;
    }
</style>

<body class="font-paragraph">

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
    // Get the calendar element
    const calendarEl = document.getElementById('calendar');
    console.log("Calendar Element:", calendarEl); // Debugging

    // Get events data from Laravel
    const allEvents = @json($events);
    console.log("Events received from Laravel:", allEvents); // Debugging

    // Get the logged-in user's ID
    const userId = @json(auth()->id());
    console.log("Logged-in User ID:", userId); // Debugging

    // Initialize FullCalendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: allEvents.map(event => {
            console.log("Mapping Event:", event); // Debugging
            return {
                id: event.id,
                title: event.title, // Use event.title for the calendar display
                start: event.start,
                allDay: true,
                color: event.user_id == userId ? '#97a97c' : '#4a4a4a', // Green for user, dark for others
                textColor: 'white',
                extendedProps: {
                    ...event, // Include all event data
                }
            };
        }),

        // Event click handler (SweetAlert instead of Modal)
        eventClick: function (info) {
    console.log("Event Clicked:", info.event); // Debugging
    console.log("Extended Props:", info.event.extendedProps); // Debugging
    
    let eventData = info.event.extendedProps || {};

    console.log("Raw Event Data:", eventData); // Debugging

    // Ayusin ang property names (dapat case-sensitive)
    let checkIn = eventData.check_in ? eventData.check_in : "Not specified";
    let checkOut = eventData.check_out ? eventData.check_out : "Not specified";
    let roomType = eventData.room_type ? eventData.room_type : "Not specified"; // Dapat `room_type`
    let accommodations = eventData.accommodations ? eventData.accommodations : "Not specified";
    let activities = eventData.activities ? eventData.activities : "Not specified";

    let reservationDetails = `
        <strong>Date:</strong> ${info.event.startStr || "Not specified"}<br>
        <strong>Check-in:</strong> ${checkIn}<br>
        <strong>Check-out:</strong> ${checkOut}<br>
        <strong>Room Type:</strong> ${roomType}<br>
        <strong>Accommodations:</strong> ${accommodations}<br>
        <strong>Activities:</strong> ${activities}
    `;

    console.log("Final Reservation Details:", reservationDetails); // Debugging

    Swal.fire({
        title: "Reservation Details",
        html: reservationDetails,
        icon: "info"
    });
}
,

        // Date click handler
        dateClick: function (info) {
            let selectedDate = info.dateStr;
            console.log("Selected Date:", selectedDate); // Debugging

            let today = new Date().toISOString().split('T')[0];
            if (selectedDate < today) {
                Swal.fire("Invalid Selection", "You cannot select past dates.", "warning");
                return;
            }

            // Check if the selected date is already booked
            let isBooked = allEvents.some(event => event.start === selectedDate);
            console.log("Is Booked:", isBooked); // Debugging

            if (!isBooked) {
                // Store the selected date in session storage
                sessionStorage.setItem("selectedDate", selectedDate);

                // Show a confirmation dialog for reservation type
                Swal.fire({
                    title: "This date is available!",
                    text: "Select a reservation type:",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Custom Package",
                    cancelButtonText: "Fixed Package",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('selectPackageCustom') }}?date=" + selectedDate;
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = "{{ route('selectPackage') }}?date=" + selectedDate;
                    }
                });
            } else {
                // Show an error if the date is already booked
                Swal.fire({
                    icon: "error",
                    title: "Date Unavailable",
                    text: "This date is already booked."
                });
            }
        }
    });

    // Render the calendar
    calendar.render();
    console.log("Calendar rendered successfully!"); // Debugging
});

</script>

</body>
</html>