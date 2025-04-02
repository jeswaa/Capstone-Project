    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Guest</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
           
            <!-- Main Content -->
             <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto" >
                 <!-- TOP SECTION -->
                 <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
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

                <!-- Main Content -->
                 <div class="overflow-y-auto h-auto p-5">
                    <div class="p-3 rounded-4 color-background4">
                        <h1 class="fs-5 font-heading fw-bold text-color-1 mb-3">Guest Overview</h1>
                        <div class="d-flex flex-row justify-content-between gap-1">
                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Registered Guests</h1>
                                <p class="fs-4 text-center color-3">{{ $users }}</p>
                            </div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Checked-in</h1>
                                <p class="fs-4 text-center color-3">#</p></div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Upcoming Reservations</h1>
                                <p class="fs-4 text-center color-3">{{ $upcomingReservations }}</p></div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Cancellations / No-Shows: </h1>
                                <p class="fs-4 text-center color-3">#</p></div>

                            <div class="text-color-1 font-paragraph s p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Guest Feedback & Complaints: </h1>
                                <p class="fs-4 text-center color-3">#</p></div>
                        </div>
                    </div>

                    <div class="p-3 mt-5">
                    <h1 class="fs-5 font-heading fw-bold color-2 mb-3">Guest Information</h1>

                    <!-- Search input with button -->
                    <div class="input-group">
                    <div class="d-flex align-items-center w-100">
                        <input type="search" id="search" class="form-control" placeholder="Search Guest Name" aria-label="Search">
                        <button class="btn btn-outline-secondary ms-2 mb-3" id="search-btn">
                            <i class="fas fa-search"></i> <!-- Search Icon -->
                        </button>
                    </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.querySelector('#search');
                            const tableBody = document.querySelector('tbody');
                            const reservations = @json($reservations); // Pass PHP data to JavaScript

                            // Function to filter table rows based on the search input
                            function filterGuests(search) {
                                // Clear the current table
                                tableBody.innerHTML = '';

                                // Filter the reservations by guest name (case insensitive)
                                const filteredGuests = reservations.filter(guest => {
                                    return guest.name.toLowerCase().includes(search.toLowerCase());
                                });

                                // If no guests match the search, show a "No results found" message
                                if (filteredGuests.length === 0) {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `<td colspan="5" class="text-center">No results found</td>`;
                                    tableBody.appendChild(row);
                                } else {
                                    // Append the filtered guests to the table
                                    filteredGuests.forEach(guest => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                                            <td>${guest.name}</td>
                                            <td>${guest.email}</td>
                                            <td>${guest.mobileNo}</td>
                                            <td>${guest.reservation_check_in}</td>
                                            <td>${guest.reservation_check_out}</td>
                                        `;
                                        tableBody.appendChild(row);
                                    });
                                }
                            }

                            // Search event listener (triggered when typing or clicking search button)
                            searchInput.addEventListener('input', function() {
                                const search = searchInput.value.trim();
                                filterGuests(search); // Filter the guest list based on the input value
                            });

                            // Initial display of all records when the page loads
                            filterGuests('');
                        });
                    </script>

                    <!-- Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Check-in</th>
                                <th scope="col">Check-out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->name }}</td>
                                <td>{{ $reservation->email }}</td>
                                <td>{{ $reservation->mobileNo}}</td>
                                <td>{{ $reservation->reservation_check_in }}</td>
                                <td>{{ $reservation->reservation_check_out }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                 </div>
             </div>
        </div>
    </div>
     <!-- SIDE NAV BAR -->
     @include('Navbar.sidenavbar')

</body>
</html>

