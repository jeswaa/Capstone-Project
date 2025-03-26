<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
   
    <div class="container-fluid">
        <div class="row h-100">
        @include('Navbar.sidenavbarStaff')
            <div class="col-12 col-md-9 color-background3 flex-column align-items-end h-100 rounded-start-50 main-content ms-auto mt-4 pe-0 ps-0" >
                    <!-- TOP SECTION -->
                <div class="color-background4 p-3 rounded-topright-50 w-100" id="main-content">
                    <div style="height: 30px;" class="d-flex justify-content-start mt-3">
                    </div>
                </div>

                <div class="row mb-1 me-3 ms-3 mt-5">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Reservations</h5>
                                <p class="card-text fs-4">{{ $reservations->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Upcoming</h5>
                                <p class="card-text fs-4">{{ $reservations->where('reservation_status', 'Upcoming')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Checked-in</h5>
                                <p class="card-text fs-4">{{ $reservations->where('reservation_status', 'Checked-in')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Checked-out</h5>
                                <p class="card-text fs-4">{{ $reservations->where('reservation_status', 'Checked-out')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-dismissible alert-success position-absolute end-0 me-3 mt-3 top-0" role="alert" style="animation: fadeOut 5s forwards;">
                        {{ session('success') }}
                    </div>
                @endif
                <style>
                    @keyframes fadeOut {
                        0% {
                            opacity: 1;
                        }
                        100% {
                            opacity: 0;
                        }
                    }
                </style>
                
                <div id="newReservationAlert"></div>

                <div class="p-3 mt-1">
                    <div class="h-50 p-4 rounded-5 mt-1 overflow-y-auto">
                        @include('StaffSide.qrscanner')
                        
                        <h1 class="text-color-1 font-heading fs-1 fw-bold mb-4">Reservations</h1>
                        <!-- Search bar -->
                        <form class="d-flex align-items-center w-100 ms-auto" role="search">
                            <input type="search" class="form-control w-100" placeholder="Search by user's name" aria-label="Search">
                            <button class="align-self-center rounded-end-5 mb-3" type="submit">
                                <i class="p-3 fa-magnifying-glass fa-solid"></i>
                            </button>
                        </form>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <select class="form-select form-select-sm" aria-label="Payment Status Filter" id="paymentStatusFilter">
                                <option value="">All</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="booked">Booked</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th style="font-size: x-small;">Name</th>
                                <th style="font-size: x-small;">Email</th>
                                <th style="font-size: x-small;">Phone Number</th>
                                <th style="font-size: x-small;">Check in Date</th>
                                <th style="font-size: x-small;">Check In</th>
                                <th style="font-size: x-small;">Check Out</th>
                                <th style="font-size: x-small;">Room</th>
                                <th style="font-size: x-small;">Activity</th>
                                <th style="font-size: x-small;">Amount</th>
                                <th style="font-size: x-small;">Balance</th>
                                <th style="font-size: x-small;">Reservation Status</th>
                                <th style="font-size: x-small;">Payment Status</th>
                                <th style="font-size: x-small;">Proof of Payment</th>
                                <th style="font-size: x-small;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td style="font-size: x-small;">{{ $reservation->name }}</td>
                                        <td style="font-size: x-small;">{{ $reservation->email }}</td>
                                        <td style="font-size: x-small;">{{ $reservation->mobileNo }}</td>
                                        <td style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</td>
                                        <td style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('g:i A') }}</td>
                                        <td style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('g:i A') }}</td>
                                        <td style="font-size: x-small;">
                                            {{ $reservation->package_name ?: implode(', ', $reservation->accommodations) }}
                                        </td>
                                        <td style="font-size: x-small;">
                                            {{ implode(', ', $reservation->activities) ?: $reservation->package_activities }}
                                        </td>
                                        <td style="font-size: x-small;">{{ $reservation->amount }}</td>
                                        <td style="font-size: x-small;" id="balance-{{ $reservation->id }}"></td>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                let amountStr = "{{ $reservation->amount }}".replace(/[^\d.]/g, ''); // Remove ₱, commas, spaces
                                                let amount = parseFloat(amountStr); // Convert to number
                                                let isPaid = "{{ $reservation->payment_status }}" === "paid"; // Check payment status

                                                let balanceElement = document.getElementById("balance-{{ $reservation->id }}");

                                                if (!isNaN(amount)) {
                                                    let balance = isPaid ? 0 : amount - (amount * 0.15); // Compute balance (subtract 15% if not paid)
                                                    balanceElement.innerText = "₱ " + balance.toLocaleString('en-PH', { minimumFractionDigits: 2 });
                                                } else {
                                                    balanceElement.innerText = "₱ 0.00"; // Default value if invalid
                                                }
                                            });
                                        </script>

                                        <td style="font-size: x-small;">{{ $reservation->reservation_status }}</td>
                                        <td>
                                            <span class="badge rounded-pill 
                                                {{ $reservation->payment_status == 'pending' ? 'bg-warning' : 
                                                ($reservation->payment_status == 'paid' ? 'bg-success' : 
                                                ($reservation->payment_status == 'booked' ? 'bg-primary' : 'bg-danger')) }}">
                                                {{ ucfirst($reservation->payment_status) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($reservation->upload_payment)
                                                <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                    <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" 
                                                         alt="Proof of Payment" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 50px;">
                                                </a>
                                            @else
                                                <span class="text-muted">No proof uploaded</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateReservationStatusModal{{ $reservation->id }}">
                                                <i class="fa-pencil fa-solid"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="updateReservationStatusModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="updateReservationStatusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateReservationStatusModalLabel">Update Reservation Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('staff.updateStatus', $reservation->id) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="payment_status" class="form-label">Payment Status</label>
                                                                    <select class="form-select" name="payment_status" id="payment_status" aria-label="Payment Status">
                                                                        <option value="" disabled selected hidden>Choose payment status</option>
                                                                        <option value="pending" {{ $reservation->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="booked" {{ $reservation->payment_status == 'booked' ? 'selected' : '' }}>Booked</option>
                                                                        <option value="paid" {{ $reservation->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                                        <option value="cancelled" {{ $reservation->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="reservation_status" class="form-label">Reservation Status</label>
                                                                    <select class="form-select" name="reservation_status" id="reservation_status" aria-label="Reservation Status">
                                                                        <option value="" disabled selected hidden>Choose reservation status</option>
                                                                        <option value="Upcoming" {{ $reservation->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                                        <option value="Checked-in" {{ $reservation->status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                                                        <option value="Checked-out" {{ $reservation->status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                                                    </select>
                                                                </div>
                                                                </select>
                                                                <div class="mb-3 mt-2">
                                                                    <label for="custom_message" class="form-label">Custom Message</label>
                                                                    <textarea class="form-control" name="custom_message" id="custom_message" rows="3"></textarea>
                                                                </div>
                                                        </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary w-100">Update</button>
                                                            </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Payment Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('staff.updateStatus', ['id' => $reservation->id]) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="payment_status" class="form-label">Payment Status</label>
                                                                <select class="form-select" name="payment_status" id="payment_status">
                                                                    <option value="pending" name="payment_status">Pending</option>
                                                                    <option value="paid" name="payment_status">Paid</option>
                                                                    <option value="cancelled" name="payment_status">Cancelled</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" name="id" value="{{ $reservation->id }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $reservations->links() }}
                        
                    </div>
                </div>

                

                <!-- Email Modal -->
                <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('staff.sendEmail') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="email_id">
                                    <div class="mb-3">
                                        <label for="email_to" class="form-label">To</label>
                                        <input type="email" class="form-control" name="email_to" id="email_to" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" name="email_subject" id="email_subject" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_message" class="form-label">Message</label>
                                        <textarea class="form-control" name="email_message" id="email_message" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById('id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }

        function closeModal() {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.hide();
        }
        function openReservationStatusModal(id) {
            document.getElementById('reservation_id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.show();
        }

        function closeReservationStatusModal() {
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.hide();
        }
        
    </script>

    <script>
        let shown = false;

        function checkForNewReservations() {
            fetch('/staff/check-new-reservations')
                .then(response => response.json())
                .then(data => {
                    let alertBox = document.getElementById("newReservationAlert");

                    if (data.new_reservations > 0 && !shown) {
                        alertBox.innerHTML = `
                            <div class="alert alert-warning" id="reservationAlert">
                                <strong>${data.new_reservations}</strong> new reservation(s) received! 
                                <a href="/staff/reservation-details" id="viewReservations">View</a>
                            </div>`;

                        shown = true;
                    }

                    // Remove notification when "View" is clicked
                    document.getElementById("viewReservations").addEventListener("click", function () {
                        alertBox.innerHTML = ""; // Remove the alert box
                        shown = false; // Allow future notifications
                    });
                });
        }

        checkForNewReservations();
    </script>

<script>
    document.getElementById('paymentStatusFilter').addEventListener('change', function () {
        let selectedStatus = this.value.toLowerCase(); // Convert to lowercase for consistency
        let allReservations = document.querySelectorAll('tbody tr'); // Get all table rows

        allReservations.forEach(reservation => {
            let paymentBadge = reservation.querySelector('td span.badge'); // Locate the payment status badge
            let paymentStatus = paymentBadge ? paymentBadge.textContent.trim().toLowerCase() : ''; // Extract text and clean up

            // Show row if "All" is selected or if the payment status matches the selected filter
            reservation.style.display = (selectedStatus === "" || paymentStatus === selectedStatus) 
                ? 'table-row' 
                : 'none';
        });
    });
</script>

</body>
</html>