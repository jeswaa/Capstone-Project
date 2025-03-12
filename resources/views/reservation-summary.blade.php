@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Reservation Summary</h2>
        @if($reservationDetails)
            <p><strong>Reservation ID:</strong> {{ $reservationDetails->id }}</p>
            <p><strong>Name:</strong> {{ $reservationDetails->name }}</p>
            <p><strong>Email:</strong> {{ $reservationDetails->email }}</p>
            <p><strong>Mobile No:</strong> {{ $reservationDetails->mobileNo }}</p>
            <p><strong>Guests:</strong> {{ $reservationDetails->number_of_guests }}</p>
            <p><strong>Room Preference:</strong> {{ $reservationDetails->room_preference }}</p>
            <p><strong>Activities:</strong> {{ $reservationDetails->activities }}</p>
            <p><strong>Reservation Date:</strong> {{ $reservationDetails->reservation_date }}</p>
            <p><strong>Check-in Time:</strong> {{ $reservationDetails->reservation_check_in }}</p>
            <p><strong>Check-out Time:</strong> {{ $reservationDetails->reservation_check_out }}</p>
            <p><strong>Special Request:</strong> {{ $reservationDetails->special_request }}</p>
            <p><strong>Payment Method:</strong> {{ $reservationDetails->payment_method }}</p>
            <p><strong>Amount:</strong> {{ $reservationDetails->amount }}</p>
            <p><strong>Reference Number:</strong> {{ $reservationDetails->reference_num }}</p>
            <p><strong>Status:</strong> {{ $reservationDetails->payment_status }}</p>
        @else
            <div class="alert alert-warning">Reservation not found.</div>
        @endif
    </div>
@endsection
