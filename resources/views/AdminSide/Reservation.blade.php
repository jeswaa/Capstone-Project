<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- Main Content -->
             <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto" >
                <!-- TOP SECTION -->
                <div class="color-background4 w-100 p-3 rounded-topright-50 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success rounded-end-5" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="overflow-y-auto h-100 p-5">
                <div class="d-flex">
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5 text-underline-left-to-right"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('rooms') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Room</h1></a>
                        <a href="{{ route('packages') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Packages</h1></a>
                        <a href="{{ route('addOns') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Add Ons & Services</h1></a>
                        <a href="{{ route('addActivities') }}" class="text-color-1 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Activities</h1></a>
                    </div>

                    <form method="GET" action="{{ route('reservations') }}">
                        <label for="user_id" class="form-label">Select User:</label>
                        <select class="form-control" name="user_id" id="user_id" onchange="this.form.submit()">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if ($noReservationMessage)
                        <div class="alert alert-warning mt-3">
                            {{ $noReservationMessage }}
                        </div>
                    @endif
                    
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Reservation Date</th>
                                <th scope="col">Room Type</th>
                                <th scope="col">Check-in</th>
                                <th scope="col">Check-out</th>
                                <th scope="col">Status</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reservationTable">
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->name }}</td>
                                    <td>{{ $reservation->reservation_check_in_date }}</td>
                                    <td>{{ DB::table('packagestbl')->where('id', $reservation->package_id)->value('package_room_type')}}</td>
                                    <td>{{ $reservation->reservation_check_in }}</td>
                                    <td>{{ $reservation->reservation_check_out }}</td>
                                    <td>{{ $reservation->payment_status }}</td>
                                    <td>{{ $reservation->amount }}</td>
                                    <td>
                                        <a href="#" class="text-success"><i class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="#" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger border-0 bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{ $reservations->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div>
                </div>
             </div>
        </div>
    </div>
    <!-- SIDE NAV BAR -->
    @include('Navbar.sidenavbar')

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
                    reservationTable.innerHTML = `<tr><td colspan="9" class="text-center">No Reservations Found</td></tr>`;
                }
            });
    });
</script>
</body>
</html>

