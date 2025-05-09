<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reservation Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        /* Mobile-first styles */
        body {
            background: url('{{ asset('images/logosheesh.png') }}') no-repeat center center fixed;
            background-size: cover;
            overflow-x: hidden;
        }

        #calendar {
            width: 95vw !important;
            height: 70vh !important;
            padding: 10px;
            margin: 10px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .fc-toolbar {
            flex-direction: column;
            gap: 8px;
            padding: 0 5px;
        }

        .fc-toolbar-title {
            font-size: 1.1rem !important;
            order: 2;
            text-align: center;
            margin: 5px 0;
            color: #2c3e50;
        }

        .fc-button {
            padding: 6px 10px !important;
            font-size: 0.85rem !important;
            min-width: 35px;
            border-radius: 8px !important;
        }

        .fc-daygrid-day {
            min-height: 50px;
            position: relative;
            border: 1px solid #e0e0e0 !important;
        }

        .fc-daygrid-day-number {
            font-size: 0.9rem !important;
            padding: 3px 5px !important;
            color: #34495e !important;
        }

        .fc-daygrid-event {
            font-size: 0.7rem !important;
            margin: 1px !important;
            padding: 2px 3px !important;
            line-height: 1.2;
            border-radius: 4px !important;
        }

        .btn-group {
            width: 90% !important;
            margin: 0 auto 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-group .btn {
            font-size: 0.9rem;
            padding: 10px 0;
            border-radius: 25px !important;
            transition: all 0.2s ease;
        }

        /* Mobile Modal Adjustments */
        #eventModal .modal-dialog {
            margin: 10px;
            max-width: 95%;
        }

        #eventModal .modal-content {
            border-radius: 12px;
        }

        #eventModal .modal-body p {
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        /* Tablet Styles */
        @media (min-width: 480px) {
            #calendar {
                height: 75vh !important;
            }

            .fc-toolbar-title {
                font-size: 1.3rem !important;
            }

            .fc-button {
                padding: 8px 12px !important;
            }

            .btn-group .btn {
                font-size: 1rem;
                padding: 12px 0;
            }
        }

        /* Desktop Styles */
        @media (min-width: 768px) {
            #calendar {
                width: 85vw !important;
                height: 80vh !important;
                max-width: 1000px;
                padding: 20px;
            }

            .fc-toolbar {
                flex-direction: row;
                gap: 15px;
                padding: 0 15px;
            }

            .fc-toolbar-title {
                font-size: 1.5rem !important;
                order: initial;
            }

            .fc-daygrid-day-number {
                font-size: 1rem !important;
            }

            .btn-group {
                width: 75% !important;
                margin-bottom: 25px;
            }
        }

        /* Interaction States */
        .fc-daygrid-day:active {
            background-color: #f8f9fa !important;
        }

        .fc-day-today {
            background-color: #e8f5e9 !important;
        }

        .fc-day-sat { background-color: #f8f9fa; }
        .fc-day-sun { background-color: #fef2f2; }

        .btn-group .btn.active {
            transform: scale(0.97);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Navigation Icons */
        .profile-icon {
            width: 40px;
            height: 40px;
            background: #2ecc71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .app-logo {
            width: 100px;
            height: auto;
            transition: transform 0.2s;
        }

        .app-logo:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="font-paragraph">
    @if (session('login_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('login_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap toast and auto-hide after 5 seconds
        const toastEl = document.querySelector('.toast');
        const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        
        setTimeout(() => {
            toast.hide();
        }, 5000);
        
        // Also hide when clicked
        toastEl.addEventListener('click', () => toast.hide());
    });
    </script>
    @endif
    @include('Alert.loginSuccessUser')
    <div class="position-absolute top-0 end-0 mt-3 me-5">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="animation: fadeOut 5s forwards;">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (session('error'))
        <div class="position-absolute top-0 end-0 mt-3 me-5" style="z-index: 11; animation: fadeOut 5s forwards;">
            <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Navigation -->
    <div class="container d-flex justify-content-between mt-3 mt-md-5 px-4">
        <a href="{{ route('profile') }}" class="text-decoration-none">
            <div class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </div>
        </a>
        <a href="{{ url('/') }}" class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="app-logo">
        </a>
    </div>

    <!-- Main Content -->
    <div class="container-fluid py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-md-10">
                <!-- Reservation Type Toggle -->
                <div class="text-center mb-4">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success active" id="stayinBtn">
                            OVERNIGHT STAY
                        </button>
                        <button type="button" class="btn btn-success" id="daytourBtn">
                            ONE DAY STAY
                        </button>
                    </div>
                </div>

                <!-- Calendar Container -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Guest:</strong> <span id="event-name"></span></p>
                    <p><strong>Dates:</strong> <span id="event-date"></span></p>
                    <p><strong>Check-in:</strong> <span id="event-check_in"></span></p>
                    <p><strong>Check-out:</strong> <span id="event-check_out"></span></p>
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
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const allEvents = @json($events);
    const today = new Date().toISOString().split('T')[0];
    const stayinBtn = document.getElementById('stayinBtn');
    const daytourBtn = document.getElementById('daytourBtn');
    let reservationType = 'stayin';
    let checkInDate = null;
    let checkOutDate = null;
    let fullyBookedDates = new Set();

    // Toggle reservation type
    [stayinBtn, daytourBtn].forEach(btn => {
        btn.addEventListener('click', function() {
            reservationType = this.id.replace('Btn', '');
            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            checkInDate = null;
            checkOutDate = null;
            highlightSelectedDates();
        });
    });

    // Process events data
    const eventsByDate = {};
    allEvents.forEach(event => {
        const eventDate = event.start;
        eventsByDate[eventDate] = eventsByDate[eventDate] || [];
        eventsByDate[eventDate].push(event);
    });

    const filteredEvents = [];
    Object.entries(eventsByDate).forEach(([date, events]) => {
        events.forEach(event => {
            if (event.extendedProps?.status === 'reserved' || event.extendedProps?.status === 'checked-in') {
                filteredEvents.push({
                    title: event.title,
                    start: event.start,
                    end: event.end,
                    allDay: true,
                    color: event.extendedProps.status === 'checked-in' ? '#2ecc71' : '#97a97c',
                    extendedProps: event.extendedProps
                });
            }
        });

        if (events.some(e => e.title === "Fully Booked")) {
            fullyBookedDates.add(date);
            filteredEvents.push({
                title: "Fully Booked",
                start: date,
                allDay: true,
                color: '#FF0000',
                textColor: 'white'
            });
        }
    });

    // Initialize calendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: filteredEvents,
        eventClick: function(info) {
            if (info.event.title !== "Fully Booked") {
                const props = info.event.extendedProps;
                document.getElementById('event-name').textContent = props.name;
                document.getElementById('event-date').textContent = `${new Date(info.event.start).toLocaleDateString()}`;
                document.getElementById('event-check_in').textContent = props.check_in;
                document.getElementById('event-check_out').textContent = props.check_out;
                document.getElementById('event-accommodations').textContent = props.accommodations;
                document.getElementById('event-activities').textContent = props.activities;
                
                const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();
            }
        },
        dateClick: handleDateClick,
        dayCellDidMount: handleDayCellMount,
        selectable: true,
        selectConstraint: {
            start: today,
            end: '2100-12-31' // Far future date
        },
        validRange: {
            start: today
        },
        dayCellClassNames: function(arg) {
            if (arg.date < new Date(today)) {
                return ['past-date'];
            }
            return [];
        }
    });

    // Add these styles to your existing style element
    const style = document.createElement('style');
    style.textContent = `
        .past-date {
            background-color: #f5f5f5 !important;
            color: #999 !important;
            cursor: not-allowed !important;
        }
        .fc-daygrid-day-number {
            position: absolute !important;
            top: 5px !important;
            right: 5px !important;
        }
        .fc-day-today {
            background-color: #e8f4ea !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            background-color: #198754 !important;
            color: white !important;
            border-radius: 50% !important;
            width: 24px !important;
            height: 24px !important;
            text-align: center !important;
            line-height: 24px !important;
            padding: 0 !important;
            margin: 5px !important;
        }
        
        .fc-event {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 20px !important;
            text-align: center !important;
        }

        .fc-daygrid-event-harness {
            margin-top: 15px !important;
        }

        .fc-event-title {
            text-align: center !important;
            width: 100% !important;
        }
    `;
    document.head.appendChild(style);

    // Update handleDayCellMount function
    function handleDayCellMount(info) {
        const cellDate = info.date.toISOString().split('T')[0];
        if(cellDate < today) {
            info.el.classList.add('past-date');
        }
    }

    calendar.render();

    function handleDateClick(info) {
        const selectedDate = info.dateStr;

        if(selectedDate < today) {
            Swal.fire("Past Date", "Cannot select dates in the past", "warning");
            return;
        }

        if(fullyBookedDates.has(selectedDate)) {
            Swal.fire("Booked Out", "This date is unavailable", "error");
            return;
        }

        if(reservationType === 'daytour') {
            handleDayTour(selectedDate);
        } else {
            handleStayIn(selectedDate);
        }

        highlightSelectedDates();
    }

    function handleDayTour(date) {
        checkInDate = date;
        checkOutDate = date;
        Swal.fire({
            title: 'Day Pass Selected',
            text: `Date: ${new Date(date).toLocaleDateString()}`,
            icon: 'success'
        }).then(() => {
            window.location.href = `{{ route('selectPackage') }}?checkIn=${date}&checkOut=${date}&type=daytour`;
        });
    }

    function handleStayIn(date) {
        if(!checkInDate) {
            checkInDate = date;
            Swal.fire('Check-in Set', new Date(date).toLocaleDateString(), 'success');
        } else if(!checkOutDate && date > checkInDate) {
            checkOutDate = date;
            Swal.fire({
                title: 'Dates Selected',
                html: `Check-in: ${new Date(checkInDate).toLocaleDateString()}<br>
                      Check-out: ${new Date(checkOutDate).toLocaleDateString()}`,
                icon: 'success'
            }).then(() => {
                window.location.href = `{{ route('selectPackageCustom') }}?checkIn=${checkInDate}&checkOut=${checkOutDate}`;
            });
        } else if(date <= checkInDate) {
            Swal.fire('Invalid', 'Check-out must be after check-in', 'error');
        } else {
            checkInDate = date;
            checkOutDate = null;
            Swal.fire('New Check-in', new Date(date).toLocaleDateString(), 'info');
        }
    }

    function highlightSelectedDates() {
        document.querySelectorAll('.fc-daygrid-day').forEach(day => {
            const date = day.dataset.date;
            day.style.backgroundColor = '';
            day.style.color = '';

            if(date === checkInDate) {
                day.style.backgroundColor = '#2ecc71';
                day.style.color = 'white';
            } else if(date === checkOutDate) {
                day.style.backgroundColor = '#e74c3c';
                day.style.color = 'white';
            } else if(checkInDate && checkOutDate && date > checkInDate && date < checkOutDate) {
                day.style.backgroundColor = '#f1c40f';
            }
        });
    }
});
</script>
</body>
</html>