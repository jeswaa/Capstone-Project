<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reservation Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
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

        .container-fluid {
            display: flex;
            flex-direction: column;
            padding: 15px;
            gap: 20px;
        }

        #calendar {
            width: 100% !important;
            height: 60vh !important;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .reservation-controls {
            width: 100%;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .fc-toolbar {
            flex-direction: column;
            gap: 8px;
            padding: 0 5px;
        }

        .fc-toolbar-title {
            font-size: 1rem !important;
            order: 2;
            text-align: center;
            margin: 5px 0;
            color: #2c3e50;
        }

        .fc-button {
            padding: 5px 8px !important;
            font-size: 0.8rem !important;
            min-width: 30px;
            border-radius: 8px !important;
        }

        .fc-daygrid-day {
            min-height: 40px;
            position: relative;
            border: 1px solid #e0e0e0 !important;
        }

        .fc-daygrid-day-number {
            font-size: 0.8rem !important;
            padding: 2px 4px !important;
            color: #34495e !important;
        }

        .fc-daygrid-event {
            font-size: 0.65rem !important;
            margin: 1px !important;
            padding: 1px 2px !important;
            line-height: 1.1;
            border-radius: 3px !important;
        }

        /* Responsive button styles */
        .btn-group {
            width: 100% !important;
            gap: 10px;
        }

        .btn-group .btn {
            font-size: 0.8rem;
            padding: 8px 0;
            border-radius: 25px !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        @media (max-width: 575.98px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin-bottom: 10px;
                width: 100%;
            }
        }

        @media (min-width: 576px) {
            .btn-group {
                flex-direction: row;
            }

            .btn-group .btn {
                font-size: 0.9rem;
            }
        }

        @media (min-width: 768px) {
            .btn-group .btn {
                font-size: 0.95rem;
            }
        }

        @media (min-width: 992px) {
            .btn-group .btn {
                font-size: 1rem;
                padding: 10px 0;
            }
        }

        .btn-group .btn.active {
            transform: scale(1.05) !important;
            background-color: #1a8d44 !important;
            box-shadow: 0 0 15px rgba(46, 204, 113, 0.6) !important;
            border: 2px solid #fff !important;
            font-weight: bold !important;
            letter-spacing: 1px !important;
        }

        .btn-group .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
            background-color: #27ae60;
        }

        .btn-group .btn:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            animation: ripple 0.6s ease-out;
        }

        @keyframes ripple {
            from {
                transform: scale(0);
                opacity: 1;
            }

            to {
                transform: scale(2);
                opacity: 0;
            }
        }

        .btn-group .btn.active {
            transform: scale(0.97);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #219653;
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
            font-size: 0.9rem;
        }

        /* Small Mobile Styles */
        @media (min-width: 320px) {
            .fc-toolbar-title {
                font-size: 0.9rem !important;
            }

            .fc-button {
                padding: 4px 6px !important;
                font-size: 0.75rem !important;
            }
        }

        /* Tablet Styles */
        @media (min-width: 576px) {
            #calendar {
                height: 65vh !important;
            }

            .fc-toolbar-title {
                font-size: 1.2rem !important;
            }

            .fc-button {
                padding: 6px 10px !important;
                font-size: 0.85rem !important;
            }

            .btn-group {
                flex-direction: row;
                width: 90% !important;
            }

            .btn-group .btn {
                font-size: 0.9rem;
                padding: 10px 0;
            }
        }

        /* Medium Tablet Styles */
        @media (min-width: 768px) {
            .container-fluid {
                flex-direction: row;
                align-items: flex-start;
            }

            #calendar {
                width: 65% !important;
                height: 75vh !important;
            }

            .reservation-controls {
                width: 35%;
            }

            .fc-toolbar {
                flex-direction: row;
                gap: 10px;
                padding: 0 10px;
            }

            .fc-toolbar-title {
                font-size: 1.3rem !important;
                order: initial;
            }

            .fc-daygrid-day-number {
                font-size: 0.9rem !important;
            }

            .btn-group {
                width: 100% !important;
            }
        }

        /* Desktop Styles */
        @media (min-width: 992px) {
            #calendar {
                width: 70% !important;
                height: 80vh !important;
                max-width: 1000px;
                padding: 20px;
            }

            .reservation-controls {
                width: 30%;
                padding: 20px;
            }

            .fc-toolbar-title {
                font-size: 1.5rem !important;
            }

            .fc-daygrid-day-number {
                font-size: 1rem !important;
            }

            .btn-group {
                width: 90% !important;
                margin-bottom: 25px;
            }

            .btn-group .btn {
                font-size: 1rem;
                padding: 12px 0;
            }
        }

        /* Interaction States */
        .fc-daygrid-day:active {
            background-color: #f8f9fa !important;
        }

        .fc-day-today {
            background-color: #e8f5e9 !important;
        }

        .fc-day-sat {
            background-color: #f8f9fa;
        }

        .fc-day-sun {
            background-color: #fef2f2;
        }

        .btn-group .btn.active {
            transform: scale(0.97);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Navigation Icons */
        .profile-icon {
            width: 35px;
            height: 35px;
            background: #2ecc71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .app-logo {
            width: 80px;
            height: auto;
            transition: transform 0.2s;
        }

        .app-logo:hover {
            transform: scale(1.05);
        }

        @media (min-width: 768px) {
            .profile-icon {
                width: 40px;
                height: 40px;
            }

            .app-logo {
                width: 100px;
            }
        }

        /* Additional responsive styles for calendar events */
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
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        /* Responsive styles for instruction boxes */
        .instructions-box,
        .selected-dates {
            width: 100% !important;
            font-size: 0.9rem;
        }

        @media (min-width: 768px) {

            .instructions-box,
            .selected-dates {
                font-size: 1rem;
            }
        }

        /* Animation for toasts */
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body class="font-paragraph">
    @if (session('login_success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('login_success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true" style="animation: fadeOut 5s forwards;">
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
            <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Navigation -->
    <div class="container d-flex justify-content-between mt-2 mt-md-4 px-2 px-md-4">
        <a href="{{ route('homepage') }}" class="text-decoration-none">
            <div class="profile-icon">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
        <a href="#" class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="app-logo">
        </a>
    </div>

    <!-- Main Content -->
    <div class="container-fluid py-2 py-md-4 mx-auto" style="max-width: 1200px;">
        <div class="row w-100 mx-auto">
            <div class="col-12 col-md-8 col-lg-9 mb-4 mb-md-5">
                <div id="calendar"></div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 pe-md-0">
                <!-- Reservation Type Toggle -->
                <div class="btn-group d-flex mb-4" role="group">
                    <button type="button" class="btn btn-success active flex-grow-1 fs-6 fs-md-5 fs-lg-4" id="stayinBtn"
                        style="min-height: 50px; margin-right: 8px;">
                        <span>OVERNIGHT STAY</span>
                    </button>
                    <button type="button" class="btn btn-success flex-grow-1 fs-6 fs-md-5 fs-lg-4" id="daytourBtn"
                        style="min-height: 50px;">
                        <span>ONE DAY STAY</span>
                    </button>
                </div>
                <!-- Selected Dates Display -->
                <div class="selected-dates bg-light p-3 p-md-4 rounded-3 shadow-sm mb-3" id="selectedDatesBox"
                    style="border: 2px solid #198754;">
                    <h5 class="text-center mb-3" style="color: #198754; font-size: 1rem;">Chosen Dates:</h5>
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <strong>Check-in:</strong>
                            <div id="selectedCheckIn">-</div>
                        </div>
                        <div class="text-center">
                            <strong>Check-out:</strong>
                            <div id="selectedCheckOut">-</div>
                        </div>
                    </div>
                </div>
                <!-- Instructions for Overnight Stay -->
                <div class="instructions-box p-3 p-md-4 bg-light rounded-3 shadow-sm mb-3" id="overnightInstructions"
                    style="border: 2px solid #198754;">
                    <h5 class="text-center mb-2 mb-md-3" style="color: #198754; font-size: 1rem;">How to Book an
                        Overnight
                        Stay</h5>
                    <ol class="mb-0 ps-3" style="color: #333;">
                        <li class="mb-2">Select your Check-in Date</li>
                        <li class="mb-2">Then select your Check-out Date
                            <ul class="mt-1 ps-3">
                                <li>Check-out must be after Check-in</li>
                            </ul>
                        </li>
                    </ol>
                </div>

                <!-- Instructions for Day Tour -->
                <div class="instructions-box p-3 p-md-4 bg-light rounded-3 shadow-sm mb-3" id="daytourInstructions"
                    style="border: 2px solid #198754; display: none;">
                    <h5 class="text-center mb-2 mb-md-3" style="color: #198754; font-size: 1rem;">How to Book a Day Tour
                    </h5>
                    <ol class="mb-0 ps-3" style="color: #333;">
                        <li class="mb-2">Select your preferred date</li>
                        <li class="mb-2">Note:
                            <ul class="mt-1 ps-3">
                                <li>Past dates cannot be selected</li>
                            </ul>
                        </li>
                        <li>Once selected, we'll check availability and show package options</li>
                    </ol>
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

            // Toggle reservation type
            [stayinBtn, daytourBtn].forEach(btn => {
                btn.addEventListener('click', function () {
                    reservationType = this.id.replace('Btn', '');
                    document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    checkInDate = null;
                    checkOutDate = null;
                    highlightSelectedDates();

                    // Toggle visibility of selected dates box
                    const selectedDatesBox = document.getElementById('selectedDatesBox');
                    const overnightInstructions = document.getElementById('overnightInstructions');
                    const daytourInstructions = document.getElementById('daytourInstructions');

                    if (reservationType === 'daytour') {
                        selectedDatesBox.style.display = 'none';
                        overnightInstructions.style.display = 'none';
                        daytourInstructions.style.display = 'block';
                    } else {
                        selectedDatesBox.style.display = 'block';
                        overnightInstructions.style.display = 'block';
                        daytourInstructions.style.display = 'none';
                    }
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
                eventClick: function (info) {
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
                dayCellClassNames: function (arg) {
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
                if (cellDate < today) {
                    info.el.classList.add('past-date');
                }
            }

            calendar.render();

            function handleDateClick(info) {
                const selectedDate = info.dateStr;

                if (selectedDate < today) {
                    Swal.fire("Past Date", "Cannot select dates in the past", "warning");
                    return;
                }

                if (fullyBookedDates.has(selectedDate)) {
                    Swal.fire("Booked Out", "This date is unavailable", "error");
                    return;
                }

                if (reservationType === 'daytour') {
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
                    title: 'Check in Date Selected',
                    text: `Date: ${new Date(date).toLocaleDateString()}`,
                    icon: 'success'
                }).then(() => {
                    window.location.href = `{{ route('selectPackage') }}?checkIn=${date}&checkOut=${date}&type=daytour`;
                });
            }

            function handleStayIn(date) {
                if (!checkInDate) {
                    checkInDate = date;
                    // Update the selected dates display
                    document.getElementById('selectedCheckIn').textContent = new Date(date).toLocaleDateString();
                    document.getElementById('selectedCheckOut').textContent = '-';

                    Swal.fire({
                        title: 'Check-in Date na Napili',
                        text: 'Mangyaring pumili ng Check-out Date',
                        html: `Check-in Date: ${new Date(date).toLocaleDateString()}<br><br>
                       <strong>Pumili ng Check-out Date sa calendar</strong>`,
                        icon: 'info',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#2ecc71'
                    });
                } else if (!checkOutDate && date > checkInDate) {
                    checkOutDate = date;
                    // Update the selected dates display
                    document.getElementById('selectedCheckOut').textContent = new Date(date).toLocaleDateString();

                    // Check availability for each accommodation type
                    fetch(`/check-accommodation-availability?checkIn=${checkInDate}&checkOut=${checkOutDate}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.available_accommodations && data.available_accommodations.length > 0) {
                                Swal.fire({
                                    title: 'Selected Dates',
                                    html: `<strong>Check-in:</strong> ${new Date(checkInDate).toLocaleDateString()}<br>
                                  <strong>Check-out:</strong> ${new Date(checkOutDate).toLocaleDateString()}`,
                                    icon: 'success',
                                    confirmButtonColor: '#2ecc71'
                                }).then(() => {
                                    window.location.href = `{{ route('selectPackageCustom') }}?checkIn=${checkInDate}&checkOut=${checkOutDate}`;
                                });
                            } else {
                                throw new Error('No accommodations available');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: error.message || 'Failed to check availability',
                                icon: 'error',
                                confirmButtonColor: '#e74c3c'
                            });
                            checkInDate = null;
                            checkOutDate = null;
                            highlightSelectedDates();
                        });
                } else if (date <= checkInDate) {
                    Swal.fire({
                        title: 'Invalid Date',
                        text: 'Check-out date must be after the Check-in date',
                        icon: 'error',
                        confirmButtonColor: '#e74c3c'
                    });
                } else {
                    checkInDate = date;
                    checkOutDate = null;
                    Swal.fire({
                        title: 'New Check-in Date',
                        text: 'Please select a new Check-out Date',
                        html: `New Check-in Date: ${new Date(date).toLocaleDateString()}<br><br>
                       <strong>Please select Check-out Date on the calendar</strong>`,
                        icon: 'info',
                        confirmButtonColor: '#2ecc71'
                    });
                }
            }

            function highlightSelectedDates() {
                document.querySelectorAll('.fc-daygrid-day').forEach(day => {
                    const date = day.dataset.date;
                    day.style.backgroundColor = '';
                    day.style.color = '';

                    if (date === checkInDate) {
                        day.style.backgroundColor = '#2ecc71';
                        day.style.color = 'white';
                    } else if (date === checkOutDate) {
                        day.style.backgroundColor = '#e74c3c';
                        day.style.color = 'white';
                    } else if (checkInDate && checkOutDate && date > checkInDate && date < checkOutDate) {
                        day.style.backgroundColor = '#f1c40f';
                    }
                });
            }
        });
    </script>
    <script>
        // Add this after your existing button click handlers
        document.addEventListener('DOMContentLoaded', function () {
            const stayinBtn = document.getElementById('stayinBtn');
            const daytourBtn = document.getElementById('daytourBtn');
            const overnightInstructions = document.getElementById('overnightInstructions');
            const daytourInstructions = document.getElementById('daytourInstructions');

            stayinBtn.addEventListener('click', function () {
                overnightInstructions.style.display = 'block';
                daytourInstructions.style.display = 'none';
            });

            daytourBtn.addEventListener('click', function () {
                overnightInstructions.style.display = 'none';
                daytourInstructions.style.display = 'block';
            });
        });
    </script>
    <script>
        // Add function to reset selected dates display
        function resetSelectedDates() {
            document.getElementById('selectedCheckIn').textContent = '-';
            document.getElementById('selectedCheckOut').textContent = '-';
        }

        // Update the reservation type toggle to reset dates
        [stayinBtn, daytourBtn].forEach(btn => {
            btn.addEventListener('click', function () {
                resetSelectedDates();
            });
        });
    </script>
</body>

</html>