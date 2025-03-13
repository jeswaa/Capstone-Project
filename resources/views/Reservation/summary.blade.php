<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reservation Summary</h2>

        <!-- Display error message if any -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($reservationDetails))
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $reservationDetails->name }}</p>
                    <p><strong>Email:</strong> {{ $reservationDetails->email }}</p>
                    <p><strong>Mobile No:</strong> {{ $reservationDetails->mobileNo }}</p>
                    <p><strong>Number of Guests:</strong> 
                        {{ $reservationDetails->total_guest }} 
                        @if(!empty($reservationDetails->package_max_guests))
                            {{ $reservationDetails->package_max_guests }}
                        @endif
                    </p>
                    <p><strong>Address:</strong> {{ $reservationDetails->address }}</p>
                    @if(!empty($reservationDetails->package_name))
                        <p><strong>Package:</strong> {{ $reservationDetails->package_name }}</p>
                    @endif
                    <p><strong>Room Type:</strong>
                        <ul>
                            @if(!empty($reservationDetails->package_room_type))
                                <p>{{ $reservationDetails->package_room_type }}</p>
                            @endif
                            @foreach($accommodations as $acocomodation)
                                <p>{{ $acocomodation }}</p>
                            @endforeach
                        </ul>
                    </p>

                    <p><strong>Activities:</strong> 
                    <ul>
                        @if(!empty($reservationDetails->package_activities))
                            <p>{{ $reservationDetails->package_activities }}</p>
                        @endif
                        @foreach($activities as $activity)
                            <p>{{ $activity }}</p>
                        @endforeach
                    </ul>
                    </p>

                    <p><strong>Reservation Date:</strong> {{ $reservationDetails->reservation_check_in_date }}</p>
                    <p><strong>Reservation Time:</strong> 
                        {{ $reservationDetails->reservation_check_in }} - {{ $reservationDetails->reservation_check_out }}
                    </p>

                    <p><strong>Special Request:</strong> 
                        {{ $reservationDetails->special_request ?? 'No special request' }}
                    </p>

                    <p><strong>Payment Method:</strong> 
                        {{ $reservationDetails->payment_method ?? 'Not specified' }}
                    </p>

                    <p><strong>Amount:</strong> 
                        {{($reservationDetails->amount) }}
                    </p>

                    <p><strong>Reference Number:</strong> 
                        {{ $reservationDetails->reference_num ?? 'N/A' }}
                    </p>

                    @if (!empty($reservationDetails->upload_payment))
                        <p><strong>Payment Proof:</strong> 
                            <a href="{{ route('payment.proof', ['filename' => basename($reservationDetails->upload_payment)]) }}" target="_blank">
                                View Proof
                            </a>
                        </p>
                    @endif

                    <p><strong>Status:</strong> 
                        <span style="text-transform: capitalize" class="badge 
                            @if($reservationDetails->payment_status == 'paid') bg-success 
                            @elseif($reservationDetails->payment_status == 'pending') bg-warning
                            @elseif($reservationDetails->payment_status == 'booked') bg-primary
                            @else bg-danger 
                            @endif">
                            {{ ($reservationDetails->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Display a message if no reservations exist -->
    <div class="alert alert-warning text-center">
        It looks like you don't have any reservations yet.
    </div>
@endif

</body>
</html>
