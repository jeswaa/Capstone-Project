<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
.fancy-link {
    text-decoration: none;
    font-weight: 600;
    position: relative;
    transition: color 0.3s ease;
}

.fancy-link::after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    left: 0;
    bottom: -2px;
    background-color: #0b573d;
    transition: width 0.3s ease;
}

.fancy-link:hover {
    color: #0b573d;
}

.fancy-link:hover::after {
    width: 100%;
}
.fancy-link.active::after {
    width: 100% !important;
}

#calendar-container {
    max-width: 100%; /* Reduce width */
    
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.fc-view-container {
    height: 300px !important; /* Ensure height applies */
}
.fc .fc-toolbar-title{
    font-size: 3rem !important;
    text-transform: uppercase;
    font-family: 'Anton';
    letter-spacing: 0.1em;
    color: #0b573d;
}
.fc-daygrid-day-number {
    font-size: 0.75rem !important; 
    color: #0b573d;
}
.fc .fc-col-header-cell-cushion{
    font-size: 1rem !important; 
    color: #0b573d;
    text-decoration: none !important;
    
}
.fc-direction-ltr .fc-button-group{
    color: #0b573d;
}
.fc-daygrid-event {
    font-size: 0.7rem !important; /* Smaller event text */
    padding: 2px;
    border-radius: 3px;
}
.fc-button {
    background-color: #0b573d !important;
    font-family: 'Anton', sans-serif !important;
    color: white !important;
    text-transform: capitalize !important;
    
    border: none !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    transition: background-color 0.3s ease;
}

/* Style for the active button (selected view) */
.fc-button.fc-button-active {
    background-color: #094a34 !important;
}

/* Hover effect */
.fc-button:hover {
    background-color: #127656 !important;
}
.transition-width {
    transition: all 0.3s ease;
}
#mainContent.full-width {
    width: 100% !important;
    flex: 0 0 100% !important;
    max-width: 100% !important;
}
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            @include('Navbar.sidenavbar')

            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Header -->
                <div class="d-flex justify-content-end mb-2">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                </div>

                <hr class="border-5">

                <!-- Links -->
                <div class="d-flex justify-content-center">
                    <a href="{{ route('reservations') }}" class="text-color-2 text-decoration-none me-5 fancy-link active" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Reservation</h1></a>
                    <a href="{{ route('rooms') }}" class="text-color-2 me-5 text-decoration-none fancy-link" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Room</h1></a>
                    <a href="{{ route('addActivities') }}" class="text-color-2 text-decoration-none fancy-link" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Activities</h1></a>
                </div>

                <div class="mt-5">
                    <h1 class="text-color-2" style="font-family: 'Anton', sans-serif;"> Calendar</h1>
                    <div id="calendar-container" class="shadow-lg rounded-4 p-3 bg-white floating-effect">
                        <div id="calendar" class="mb-5"></div>
                    </div>

                    <h1 class="text-color-2 mt-5" style="font-family: 'Anton', sans-serif;">Guest Reservation Records</h1>
                    <!-- Search Function -->
                    <form class="d-flex justify-content-center align-items-center w-100 mb-3 mt-1" role="search" id="filterForm">
                        <div class="input-group">
                            <input type="text" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search Guest Name" aria-label="Search" id="guestNameFilter">
                            <button class="btn btn-outline-success rounded-end-5" type="button" onclick="filterGuests()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Table -->
                <div class="bg-white shadow-lg rounded-4 p-4 mt-2">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="table-light text-uppercase text-secondary small">
                            <tr>
                                <th scope="col" class="small">Guest Name</th>
                                <th scope="col" class="small">Dates(In-Out)</th>
                                <th scope="col" class="small">Time(In-Out)</th>
                                <th scope="col" class="small">Room Type</th>
                                <th scope="col" class="small">Room Qty</th>
                                <th scope="col" class="small">Mobile Number</th>
                                <th scope="col" class="small">Reference Number</th>
                                <th scope="col" class="small">Payment Status</th>
                                <th scope="col" class="small">Res. Status</th>
                                <th scope="col" class="small">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="reservationTable">
                            @foreach ($reservations as $reservation)
                                <tr class="align-middle">
                                    <td class="fw-semibold">{{ $reservation->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M j, Y') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('M j, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('h:i A') }}</td>
                                    <td>
                                        @if(!empty($reservation->accomodation_names))
                                            {{ implode(', ', $reservation->accomodation_names) }}
                                        @else
                                            <span class="text-muted">No Accommodation</span>
                                        @endif
                                    </td>
                                    <td>{{ $reservation->quantity}}</td>
                                    <td>{{$reservation->mobileNo}}</td>
                                    <td>{{ $reservation->reference_num}}</td>
                                    <td>
                                        <span class="badge 
                                            @if($reservation->payment_status == 'paid') bg-success
                                            @elseif($reservation->payment_status == 'pending') bg-warning text-dark
                                            @elseif($reservation->payment_status == 'booked') bg-primary
                                            @else bg-danger
                                            @endif
                                            px-3 py-2 rounded-pill text-uppercase fw-medium"
                                        >
                                            {{ ucfirst($reservation->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($reservation->reservation_status == 'confirmed') bg-success
                                            @elseif($reservation->reservation_status == 'pending') bg-warning text-dark
                                            @elseif($reservation->reservation_status == 'cancelled') bg-danger
                                            @else bg-secondary
                                            @endif
                                            px-3 py-2 rounded-pill text-uppercase fw-medium"
                                        >
                                            {{ ucfirst($reservation->reservation_status) }}
                                        </span>
                                    </td>
                                    <td>₱{{ number_format($reservation->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" class="pt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} reservations
                                        </div>
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                {{-- Previous Page Link --}}
                                                @if ($reservations->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&laquo;</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $reservations->previousPageUrl() }}" rel="prev">&laquo;</a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                                                    @if ($page == $reservations->currentPage())
                                                        <li class="page-item active" aria-current="page">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Next Page Link --}}
                                                @if ($reservations->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $reservations->nextPageUrl() }}" rel="next">&raquo;</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&raquo;</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Showing Calendar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            contentHeight: 600,
            events: @json($events),
            eventColor: '#0b573d',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventClick: function(info) {
                // Enhanced event details display
                const event = info.event;
                const startDate = moment(event.start).format('MMMM D, YYYY');
                const endDate = event.end ? moment(event.end).format('MMMM D, YYYY') : null;
                
                // Split the description into reserved and available rooms
                const description = event.extendedProps.description;
                const [reservedRooms, availableRooms] = description.split('\n');
                
                const detailsHtml = `
                    <div class="p-4">
                        <h5 class="text-center mb-4" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.1em;">RESERVATION DETAILS</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #f8f9fa; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Reservation Date</h6>
                                        <p class="card-text fw-semibold">${startDate}${endDate ? ' - ' + endDate : ''}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #0b573d; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2 text-white" style="font-family: 'Poppins', sans-serif;">Reserved Rooms</h6>
                                        <p class="card-text text-white fw-semibold">${reservedRooms.replace('Reserved Rooms: ', '')}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #127656; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2 text-white" style="font-family: 'Poppins', sans-serif;">Available Rooms</h6>
                                        <p class="card-text text-white fw-semibold">${availableRooms.replace('Available Rooms: ', '')}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            
                Swal.fire({
                    title: '',
                    html: detailsHtml,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '32rem',
                    padding: '0',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        closeButton: 'btn btn-lg btn-outline-secondary rounded-circle p-2 position-absolute end-0 top-0 m-3'
                    }
                });
            },
            dayMaxEvents: true,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            }
        });

        calendar.render();
    });
</script>
<!-- Search Function -->
<script>
    document.getElementById('guestNameFilter').addEventListener('input', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#reservationTable tr');
        let hasMatch = false;

        rows.forEach(row => {
            const guestNameCell = row.cells[0];
            if (guestNameCell) {
                const guestName = guestNameCell.textContent.toLowerCase();
                if (guestName.includes(filterValue)) {
                    row.style.display = '';
                    hasMatch = true;
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // Show message if no reservations match
        const noResultsRow = document.getElementById('noResultsRow');
        if (!hasMatch) {
            if (!noResultsRow) {
                const noResults = document.createElement('tr');
                noResults.id = 'noResultsRow';
                noResults.innerHTML = `<td colspan="8" class="text-center mt-3">No reservations for that guest</td>`;
                document.getElementById('reservationTable').appendChild(noResults);
            }
        } else {
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    });
</script>
<!-- Something Function -->
<script>
    document.getElementById('user_id').addEventListener('change', function() {
        let userId = this.value;
        let reservationTable = document.getElementById('reservationTable');

        // Clear table content
        reservationTable.innerHTML = '';

        // Fetch filtered reservations
        fetch("{{ route('reservations') }}?user_id=" + userId)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(reservation => {
                        let row = `
                            <tr>
                                <td>${reservation.id}</td>
                                <td>${reservation.reservation_check_in_date}</td>
                                <td>example</td>
                                <td>${reservation.name}</td>
                                <td>${reservation.reservation_check_in}</td>
                                <td>${reservation.reservation_check_out}</td>
                                <td>${reservation.payment_status}</td>
                                <td>${reservation.amount}</td>
                                <td>
                                    <a href="#" class="text-success"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="#" method="POST" style="display:inline;">
                                        <button type="submit" class="text-danger border-0 bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        reservationTable.innerHTML += row;
                    });
                } else {
                    reservationTable.innerHTML = `<tr><td colspan="9" class="text-center mt-3">No Reservations Found</td></tr>`;
                }
            });
    });
</script>
</body>
</html>

