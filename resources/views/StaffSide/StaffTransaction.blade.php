<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="color-background5">
   
    <div class="container-fluid">
        <div class="row h-100">
        @include('Navbar.sidenavbarStaff')
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4" >
                <!-- TOP SECTION -->
                <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
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

                <!-- Reservation Details Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
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
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->name }}</td>
                                    <td>{{ $reservation->email }}</td>
                                    <td>{{ $reservation->payment_method }}</td>
                                    <td>{{ $reservation->payment_status }}</td>
                                    <td>
                                        @if ($reservation->upload_payment)
                                            <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                                <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" alt="Proof of Payment" style="max-width: 100px; height: auto;">
                                            </a>
                                        @else
                                            No proof uploaded
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Pass the correct ID and status dynamically -->
                                        <a href="#" onclick="openModal({{ $reservation->id }}, '{{ $reservation->payment_status }}')" class="text-warning mx-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <script>
                    function openModal(id, status) {
                        document.getElementById('modalReservationId').value = id;
                        document.getElementById('modalPaymentStatus').value = status;

                        // Set form action dynamically with correct ID
                        let form = document.getElementById('updatePaymentForm');
                        form.action = `/staff/transactions/update-payment-status/${id}`;

                        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        myModal.show();
                    }

                    function closeModal() {
                        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        myModal.hide();
                    }
                </script>
            </div>
        </div>
    </div>

    <!-- Single Modal Outside Loop -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Payment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updatePaymentForm" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="modalReservationId">
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select class="form-select" name="payment_status" id="modalPaymentStatus">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="custom_message" class="form-label">Message Sent to Email</label>
                            <textarea class="form-control" name="custom_message" id="custom_message" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>
