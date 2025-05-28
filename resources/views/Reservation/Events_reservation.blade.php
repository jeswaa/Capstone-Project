<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        body {
            background: url('{{ asset('images/logosheesh.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        #calendar {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: auto !important;
            min-height: 500px;
        }

        .reservation-controls {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        @media (min-width: 768px) {
            .btn-group {
                flex-direction: row;
            }
            
            .container-fluid {
                max-width: 1400px;
            }
        }

        @media (max-width: 767px) {
            .container-fluid {
                flex-direction: column;
            }
            
            .reservation-controls {
                width: 100% !important;
                margin-top: 1rem;
            }
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background: #2ecc71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: transform 0.2s;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        .app-logo {
            max-width: 100px;
            height: auto;
        }

        .instructions-box, .selected-dates {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toast {
            z-index: 1050;
        }
    </style>
</head>

<body class="font-paragraph">
    @if (session('login_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
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
    @endif

    @include('Alert.loginSuccessUser')

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a href="{{ route('homepage') }}" class="navbar-brand">
                <div class="profile-icon">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
            </a>
                <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="app-logo">
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="reservation-controls" style="background-color: white;">
                    <div class="btn-group w-100 mb-4" role="group">
                        <button type="button" class="btn btn-success active flex-grow-1 reservation-btn" id="stayinBtn">
                            OVERNIGHT STAY
                        </button>
                        
                        <button type="button" class="btn btn-success flex-grow-1 reservation-btn" id="daytourBtn">
                            ONE DAY STAY
                        </button>
                    </div>

                    <style>
                        .reservation-btn {
                            position: relative;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        }

                        .reservation-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                        }

                        .reservation-btn.active {
                            background-color: #1a6e3d !important;
                            border-color: #1a6e3d !important;
                            transform: scale(1.02);
                            animation: buttonGlow 2s infinite;
                            font-weight: bold;
                        }

                        @keyframes buttonGlow {
                            0% {
                                box-shadow: 0 0 5px #2ecc71;
                            }
                            50% {
                                box-shadow: 0 0 20px #2ecc71, 0 0 30px #2ecc71;
                            }
                            100% {
                                box-shadow: 0 0 5px #2ecc71;
                            }
                        }

                        .reservation-btn:active {
                            transform: scale(0.98);
                            background-color: #145a32 !important;
                        }
                    </style>

                    <div class="selected-dates mb-4 p-4 rounded-3" id="selectedDatesBox" style="background-color: white;">
                        <h5 class="text-center mb-3 text-success">Chosen Dates:</h5>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <strong>Check-in:</strong>
                                <div id="selectedCheckIn">-</div>
                            </div>
                            
                            <div class="col-6">
                                <strong>Check-out:</strong>
                                <div id="selectedCheckOut">-</div>
                            </div>
                        </div>
                    </div>

                    <div id="overnightInstructions" class="instructions-box p-4 rounded-3" style="background-color: white;">
                        <h5 class="text-center mb-3 text-success">How to Book an Overnight Stay</h5>
                        
                        <ol class="mb-0">
                            <li class="mb-2">Select your Check-in Date</li>
                            
                            <li>Then select your Check-out Date
                                <ul class="mt-1">
                                    <li>Check-out must be after Check-in</li>
                                    <li><span>Check-in Time: 2PM</span></li>
                                    <li><span>Check-out Time: 12PM</span></li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                        
                    
                    <div id="daytourInstructions" class="instructions-box p-4 rounded-3" style="display: none; background-color: white;">
                        <h5 class="text-center mb-3 text-success">How to Book a Day Tour</h5>
                        
                        <ol class="mb-0">
                            <li class="mb-2">Select your preferred date</li>
                            
                            <li class="mb-2">Note:
                                <ul class="mt-1">
                                    <li>Past dates cannot be selected</li>
                                    
                                </ul>
                            </li>
                            
                            <li>Once selected, we'll check availability and show package options</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4 mb-md-0">
                <div id="calendar" class="p-3 mt-4 mt-md-0" style="border: 2px solid #198754; border-radius: 10px; background-color: white;"></div>
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
            title: 'Check in Date Selected',
            text: `Date: ${new Date(date).toLocaleDateString()}`,
            icon: 'success'
        }).then(() => {
            window.location.href = `{{ route('selectPackage') }}?checkIn=${date}&checkOut=${date}&type=daytour`;
        });
    }

    function handleStayIn(date) {
        if(!checkInDate) {
            checkInDate = date;
            // Update the selected dates display
            document.getElementById('selectedCheckIn').textContent = new Date(date).toLocaleDateString();
            document.getElementById('selectedCheckOut').textContent = '-';
            
            Swal.fire({
                title: 'Check-in Date Selected',
                text: 'Please select a Check-out Date',
                html: `Check-in Date: ${new Date(date).toLocaleDateString()}<br><br>
                       <strong>Please select a Check-out Date on the calendar</strong>`,
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2ecc71'
            });
        } else if(!checkOutDate && date > checkInDate) {
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
        } else if(date <= checkInDate) {
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
<script>
// Add this after your existing button click handlers
document.addEventListener('DOMContentLoaded', function() {
    const stayinBtn = document.getElementById('stayinBtn');
    const daytourBtn = document.getElementById('daytourBtn');
    const overnightInstructions = document.getElementById('overnightInstructions');
    const daytourInstructions = document.getElementById('daytourInstructions');

    stayinBtn.addEventListener('click', function() {
        overnightInstructions.style.display = 'block';
        daytourInstructions.style.display = 'none';
    });

    daytourBtn.addEventListener('click', function() {
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
    btn.addEventListener('click', function() {
        resetSelectedDates();
    });
});
</script>

</body>
</html>