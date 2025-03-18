<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show p-2 mt-2 position-absolute top-0 end-0 w-auto" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show p-2 mt-2 position-absolute top-0 end-0 w-auto" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row h-100">
        @include('Navbar.sidenavbarStaff')
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4  flex-column align-items-end ms-auto" >
                <!-- TOP SECTION -->
                <div class="color-background4 w-100 p-3 rounded-topright-50" id="main-content">
                        <div class="d-flex justify-content-end" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                        <form class="d-flex align-items-center w-75 mt-3" role="search">
                            <input type="search" class="form-control rounded-start-5 bg-light border border-secondary" placeholder="Search by user's name" aria-label="Search">
                            <button class="btn btn-outline-success rounded-end-5" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let searchInput = document.querySelector("input[type='search']");
                                let userRows = document.querySelectorAll(".user-row"); // Adjust selector to match your user list/table rows

                                searchInput.addEventListener("input", function () {
                                    let searchTerm = searchInput.value.toLowerCase().trim();

                                    userRows.forEach(row => {
                                        let userName = row.querySelector(".user-name").textContent.toLowerCase(); // Adjust selector

                                        if (userName.includes(searchTerm)) {
                                            row.style.display = ""; // Show matching user
                                        } else {
                                            row.style.display = "none"; // Hide non-matching users
                                        }
                                    });
                                });
                            });

                        </script>
                </div>

                <div class=" ms-5 mt-4 p-3">
                    <a href="#reservationPending" id="pendingLink" class="fs-5 me-3  font-paragraph text-decoration-none text-color-1 text-underline-left-to-right">Pending Reservations</a>
                    <a href="#reservationBooked" id="bookedLink" class="fs-5 me-3 ms-3 font-paragraph text-decoration-none text-color-1 text-underline-left-to-right">Booked Reservations</a>
                    <a href="#reservationPaid" id="paidLink" class="fs-5 me-3 ms-3 font-paragraph text-decoration-none text-color-1 text-underline-left-to-right">Paid Reservations</a>
                    <a href="#reservationCancel" id="cancelledLink" class="fs-5 ms-3 font-paragraph text-decoration-none text-color-1 text-underline-left-to-right">Cancelled Reservations</a>
                </div>

                <!-- Reservation Pending section -->
                <section id="reservationPending">
                    <div class="table-responsive mt-1 p-5">
                        <table class="table table-striped table-hover">
                            <thead class="">
                                <tr>
                                    <th scope="col">Guest Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Check-In  and Check-Out Date</th>
                                    <th scope="col">Proof of Payment</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending as $reservation)
                                    <tr class="user-row">
                                        <td class="user-name">{{ $reservation->name }}</td>
                                        <td>{{ $reservation->email }}</td>
                                        <td>{{ $reservation->payment_method }}</td>
                                        <td>{{ $reservation->amount }}</td>
                                        <td>
                                            <span class="badge 
                                                {{ $reservation->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ ucfirst($reservation->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</td>
                                        <td>
                                            @if ($reservation->upload_payment)
                                                <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                    <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" alt="Proof of Payment" class="img-thumbnail" style="max-width: 100px;">
                                                </a>
                                            @else
                                                <span class="text-muted">No proof uploaded</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" onclick="openModal({{ $reservation->id }}, '{{ $reservation->payment_status }}', '{{ $reservation->amount }}')" class="text-warning mx-2">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="text-danger">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Bootstrap Pagination (if $pending is paginated, otherwise remove this) -->
                        @if ($pending instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pending->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Paid Reservations -->
                <section id="reservationPaid">
                    <div class="table-responsive mt-1 p-5">
                        <h2 class="text-center mb-4">Paid Reservations</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Guest Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Check-In  and Check-Out Date</th>
                                        <th scope="col">Proof of Payment</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paid as $reservation)
                                        <tr class="user-row">
                                            <td class="user-name">{{ $reservation->name }}</td>
                                            <td>{{ $reservation->email }}</td>
                                            <td>{{ $reservation->payment_method }}</td>
                                            <td>{{ $reservation->amount }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ ucfirst($reservation->payment_status) }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</td>
                                            <td>
                                                @if ($reservation->upload_payment)
                                                    <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                        <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" alt="Proof of Payment" class="img-thumbnail" style="max-width: 100px;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No proof uploaded</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" onclick="openModal({{ $reservation->id }}, '{{ $reservation->payment_status }}', '{{ $reservation->amount }}')" class="text-warning mx-2">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" class="text-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            @if ($paid instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $paid->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Booked Reservation -->
                <section id="reservationBooked">
                    <div class="table-responsive mt-1 p-5">
                        <h2 class="text-center mb-4">Booked Reservations</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Guest Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Check-In  and Check-Out Date</th>
                                        <th scope="col">Proof of Payment</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booked as $reservation)
                                        <tr class="user-row">
                                            <td class="user-name">{{ $reservation->name }}</td>
                                            <td>{{ $reservation->email }}</td>
                                            <td>{{ $reservation->payment_method }}</td>
                                            <td>{{ $reservation->amount }}</td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ ucfirst($reservation->payment_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservation->upload_payment)
                                                    <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                    <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" 
                                                         alt="Proof of Payment" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No proof uploaded</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</td>
                                            <td>
                                                <a href="#" onclick="openModal({{ $reservation->id }}, '{{ $reservation->payment_status }}', '{{ $reservation->amount }}')" class="text-warning mx-2">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" class="text-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Bootstrap Pagination (if paginated) -->
                            @if ($booked instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $booked->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Cancelled Reservation -->
                <section id="reservationCancel">
                    <div class="table-responsive mt-1 p-5">
                        <h2 class="text-center mb-4">Cancelled Reservations</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Guest Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Proof of Payment</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cancelled as $reservation)
                                        <tr class="user-row">
                                            <td class="user-name">{{ $reservation->name }}</td>
                                            <td>{{ $reservation->email }}</td>
                                            <td>{{ $reservation->payment_method }}</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    {{ ucfirst($reservation->payment_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservation->upload_payment)
                                                    <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                        <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" 
                                                            alt="Proof of Payment" 
                                                            class="img-thumbnail" 
                                                            style="max-width: 100px;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No proof uploaded</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" onclick="openModal({{ $reservation->id }}, '{{ $reservation->payment_status }}', '{{ $reservation->amount }}')" class="text-warning mx-2">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" class="text-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Bootstrap Pagination (if paginated) -->
                            @if ($cancelled instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $cancelled->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Single Modal Outside Loop -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePaymentForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="modalReservationId">
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Status</label>
                        <select class="form-select" name="payment_status" id="modalPaymentStatus">
                            <option value="pending">Pending</option>
                            <option value="booked">Booked</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control" id="modalAmount" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="discount_amount" class="form-label">Downpayment</label>
                        <input type="text" class="form-control" id="modalDiscountAmount" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="discountedAmount" class="form-label">Balance</label>
                        <input type="text" class="form-control" id="modalDiscountedAmount" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="custom_message" class="form-label">Message Sent to Email</label>
                        <textarea class="form-control" name="custom_message" id="custom_message" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
        document.addEventListener("DOMContentLoaded", function () {
    let updatePaymentForm = document.getElementById("updatePaymentForm");

    document.querySelectorAll(".open-payment-modal").forEach(button => {
        button.addEventListener("click", function () {
            let reservationId = this.getAttribute("data-reservation-id"); // Get ID from button

            // Update hidden input field
            document.getElementById("modalReservationId").value = reservationId;

            // Dynamically update form action with the correct ID
            updatePaymentForm.action = "/staff/transactions/update-payment-status/" + reservationId;
        });
    });
});

function openModal(id, status, amount) {
    console.log("Opening Modal for ID:", id);
    console.log("Payment Status:", status);
    console.log("Amount Received (Raw):", amount);

    // Ensure amount is a valid string before using replace
    if (!amount || typeof amount !== "string") {
        console.warn("Amount is not a valid string, defaulting to 0.");
        amount = "0"; // Default value
    }

    // Remove commas and currency symbols, ensure it’s a number
    amount = parseFloat(amount.replace(/,/g, '').replace(/[^\d.-]/g, ''));

    if (isNaN(amount)) {
        console.error("Amount is not a valid number!");
        amount = 0;
    }

    // Format amount after calculation
    let formattedAmount = "₱" + amount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let discountAmount = amount * 0.15;
    let formattedDiscountAmount = "₱" + discountAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let discountedAmount = amount - discountAmount;
    let formattedDiscountedAmount = "₱" + discountedAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    console.log("Original Amount:", formattedAmount);
    console.log("Discount (15%):", formattedDiscountAmount);
    console.log("Discounted Amount:", formattedDiscountedAmount);

    // Set values in the modal
    document.getElementById('modalReservationId').value = id;
    document.getElementById('modalPaymentStatus').value = status;
    document.getElementById('modalAmount').value = formattedAmount;
    document.getElementById('modalDiscountAmount').value = formattedDiscountAmount;

    if (status.toLowerCase() === 'paid') {
        document.getElementById('modalDiscountedAmount').value = "₱0.00";
    } else {
        document.getElementById('modalDiscountedAmount').value = formattedDiscountedAmount;
    }

    // Update form action dynamically
    document.getElementById("updatePaymentForm").action = "/staff/transactions/update-payment-status/" + id;

    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
}



        document.addEventListener("DOMContentLoaded", function () {
            function showSection(sectionId) {
                // Hide all reservation sections
                document.querySelectorAll("section").forEach((section) => {
                    section.style.display = "none";
                });

                // Show the selected section
                document.getElementById(sectionId).style.display = "block";
            }

            // Set default visible section
            showSection("reservationPending");

            // Attach event listeners to links
            document.getElementById("pendingLink").addEventListener("click", function (e) {
                e.preventDefault();
                showSection("reservationPending");
            });

            document.getElementById("bookedLink").addEventListener("click", function (e) {
                e.preventDefault();
                showSection("reservationBooked");
            });

            document.getElementById("paidLink").addEventListener("click", function (e) {
                e.preventDefault();
                showSection("reservationPaid");
            });

            document.getElementById("cancelledLink").addEventListener("click", function (e) {
                e.preventDefault();
                showSection("reservationCancel");
            });
        });

    </script>
</body>
</html>

