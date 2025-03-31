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

    /* Button Group Styles */
    .btn-group .btn.active {
        background-color: #0b573d !important;
        color: white !important;
        font-weight: bold;
        transform: scale(0.98);
    }

    .btn-group .btn:not(.active) {
        background-color: #28a745 !important;
        opacity: 0.8;
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
                <!-- Reservation Type Buttons -->
                <div class="text-center mb-4">
                    <div class="btn-group w-75" role="group">
                        <button type="button" class="btn btn-success border border-2 border-dark rounded-5 active" 
                                id="stayinBtn" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                            STAY-IN
                        </button>
                        <button type="button" class="btn btn-success border border-2 border-dark rounded-5" 
                                id="daytourBtn" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                            DAY TOUR
                        </button>
                    </div>
                </div>

                <div id="calendar" class="bg-white border p-3 rounded shadow"></div>
                <div class="mt-3 text-center">
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
        const today = new Date().toISOString().split('T')[0];
        const stayinBtn = document.getElementById('stayinBtn');
        const daytourBtn = document.getElementById('daytourBtn');
        let reservationType = 'stayin';
        let checkInDate = null;
        let checkOutDate = null;
        let fullyBookedDates = new Set();

        // Button toggle functionality
        stayinBtn.addEventListener('click', () => {
            reservationType = 'stayin';
            stayinBtn.classList.add('active');
            daytourBtn.classList.remove('active');
            checkInDate = null;
            checkOutDate = null;
            highlightSelectedDates();
        });

        daytourBtn.addEventListener('click', () => {
            reservationType = 'daytour';
            daytourBtn.classList.add('active');
            stayinBtn.classList.remove('active');
            checkInDate = null;
            checkOutDate = null;
            highlightSelectedDates();
        });

        // Process events data
        let eventsByDate = {};
        allEvents.forEach(event => {
            let eventDate = event.start;
            if (!eventsByDate[eventDate]) {
                eventsByDate[eventDate] = [];
            }
            eventsByDate[eventDate].push(event);
        });

        let filteredEvents = [];
        Object.keys(eventsByDate).forEach(date => {
            let events = eventsByDate[date];
            let isFullyBooked = events.some(event => event.title === "Fully Booked");
            if (isFullyBooked) {
                fullyBookedDates.add(date);
                let onlyFullyBooked = events.filter(event => event.title === "Fully Booked");
                filteredEvents.push(...onlyFullyBooked);
            } else {
                filteredEvents.push(...events);
            }
        });

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: filteredEvents.map(event => ({
                title: event.title,
                start: event.start,
                allDay: true,
                color: event?.extendedProps?.is_owner ? '#97a97c' : '#4a4a4a',
                textColor: 'white',
            })),
            dateClick: function (info) {
                let selectedDate = info.dateStr;

                if (selectedDate < today) {
                    Swal.fire("Invalid Selection", "You cannot select past dates.", "warning");
                    return;
                }

                if (fullyBookedDates.has(selectedDate)) {
                    Swal.fire("Fully Booked", "This date is fully booked and cannot be selected.", "error");
                    return;
                }

                if (reservationType === 'daytour') {
                    checkInDate = selectedDate;
                    checkOutDate = selectedDate;
                    Swal.fire("Day Tour Selected", `Date: ${checkInDate}`, "success").then(() => {
                        let route = "{{ route('selectPackageCustom') }}";
                        window.location.href = `${route}?checkIn=${checkInDate}&checkOut=${checkOutDate}&type=daytour`;
                    });
                } else {
                    if (!checkInDate) {
                        checkInDate = selectedDate;
                        Swal.fire("Check-in Selected", `Date: ${checkInDate}`, "success");
                    } else if (!checkOutDate && selectedDate > checkInDate) {
                        checkOutDate = selectedDate;
                        Swal.fire("Dates Selected", `Check-in: ${checkInDate}\nCheck-out: ${checkOutDate}`, "success").then(() => {
                            let route = "{{ route('selectPackageCustom') }}";
                            window.location.href = `${route}?checkIn=${checkInDate}&checkOut=${checkOutDate}`;
                        });
                    } else if (selectedDate <= checkInDate) {
                        Swal.fire("Invalid Selection", "Check-out must be after check-in.", "error");
                    } else {
                        checkInDate = selectedDate;
                        checkOutDate = null;
                        Swal.fire("New Check-in Selected", `Date: ${checkInDate}`, "success");
                    }
                }

                highlightSelectedDates();
            },
            dayCellDidMount: function (info) {
                let cellDate = info.date.toISOString().split('T')[0];
                if (cellDate < today) {
                    info.el.style.opacity = "0.5";
                    info.el.style.position = "relative";
                    let xMark = document.createElement("div");
                    xMark.innerHTML = "❌";
                    xMark.style.position = "absolute";
                    xMark.style.top = "50%";
                    xMark.style.left = "50%";
                    xMark.style.transform = "translate(-50%, -50%)";
                    xMark.style.fontSize = "1.5rem";
                    xMark.style.color = "red";
                    xMark.style.fontWeight = "bold";
                    info.el.appendChild(xMark);
                }
            }
        });

        calendar.render();

        function highlightSelectedDates() {
            document.querySelectorAll('.fc-daygrid-day').forEach(cell => {
                let cellDate = cell.getAttribute('data-date');
                if (cellDate < today || fullyBookedDates.has(cellDate)) return;

                cell.style.backgroundColor = "";
                cell.style.color = "black";

                if (cellDate === checkInDate) {
                    cell.style.backgroundColor = "#28a745";
                    cell.style.color = "white";
                } else if (cellDate === checkOutDate) {
                    cell.style.backgroundColor = "#dc3545";
                    cell.style.color = "white";
                } else if (checkInDate && checkOutDate && cellDate > checkInDate && cellDate < checkOutDate) {
                    cell.style.backgroundColor = "#ffc107";
                }
            });
        }
    });
    </script>
</body>
</html>