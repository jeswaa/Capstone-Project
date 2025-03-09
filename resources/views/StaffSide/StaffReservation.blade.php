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

                <div class="p-3 mt-3">
                    <div class="p-4 mt-1 rounded-5 h-50 overflow-y-auto">
                        <h1 class="font-heading fw-bold text-color-1 fs-3">Reservations</h1>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->name }}</td>
                                        <td>{{ $reservation->email }}</td>
                                        <td>{{ $reservation->mobileNo }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('g:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('g:i A') }}</td>
                                        <td>{{ $reservation->reservation_status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateReservationStatusModal{{ $reservation->id }}">
                                                <i class="fa-solid fa-pencil"></i>
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
                                                            <form action="{{ route('updatereservationStatus', $reservation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <select class="form-select" name="reservation_status" aria-label="Reservation Status">
                                                                    <option value="" disabled selected hidden>Choose reservation status</option>
                                                                    <option value="Upcoming" {{ $reservation->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                                    <option value="Checked-in" {{ $reservation->status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                                                    <option value="Checked-out" {{ $reservation->status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                                                    <option value="Cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary w-100">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
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
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
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
</body>
</html>