<div class="d-flex flex-wrap justify-content-between">
    @foreach ($reservations as $reservation)
    <div class="card mb-3" style="width: 100%;">
        <div class="card-body">
            <h5 class="card-title">Reservation #{{ $reservation->id }}</h5>
            <p class="card-text">Package: {{ $reservation->package_name }}</p>
            <p class="card-text">Check-in: {{ $reservation->reservation_check_in_date }}</p>
            <p class="card-text">Check-out: {{ $reservation->reservation_check_out }}</p>
            <p class="card-text">Room Type: {{ $reservation->room_preference ?? $reservation->package_room_type ?? 'N/A' }}</p>
            <p class="card-text">Number of Guests: {{ $reservation->total_guest }}</p>
            <p class="card-text">Special Request: {{ $reservation->special_request ?? 'No special request' }}</p>
            <p class="card-text">Payment Status: {{ $reservation->payment_status }}</p>
        </div>
    </div>
    @endforeach
</div>

