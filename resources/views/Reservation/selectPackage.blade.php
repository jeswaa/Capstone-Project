<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background4">
    
    <div class="d-flex align-items-center mt-5 ms-5">
        <a href="{{ route('calendar') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon me-3"></i></a>
        <h1 class="me-3 font-paragraph fs-1 fw-bold">Reservation</h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('fixPackagesSelection') }}">
        @csrf
        
        <!-- Accommodations Section -->
        <div class="container mt-4">
            <h2 class="font-paragraph fw-bold text-color-1">Cottages</h2>
            <div class="row">
                @foreach ($accomodations as $accomodation)
                    @if ($accomodation->accomodation_type === 'cottage')
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                        alt="Accommodation Image" 
                                        class="card-img-top img-fluid object-fit-cover"
                                        style="height: 200px;">
                                </div>
                                <div class="card-body color-background5">
                                    <h5 class="fs-3 fw-bold text-capitalize color-3 font-paragraph">
                                        {{ $accomodation->accomodation_name }}
                                    </h5>
                                    <p class="font-paragraph fs-6 text-color-1">
                                        <strong>Price:</strong> ₱ <span class="accommodation-price">{{ $accomodation->accomodation_price }}</span>
                                    </p>
                                    <input type="checkbox" name="selected_accommodations[]" value="{{ $accomodation->accomodation_id }}" 
                                           class="accommodation-checkbox" data-price="{{ $accomodation->accomodation_price }}" 
                                           onchange="computeTotal()">
                                    <label>Select this accommodation</label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Date and Time Selection -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-color-1 font-paragraph fw-bold mb-3">Number of Visitors</h2>
                    <div class="form-group">
                        <label for="number_of_adults">Adults (Ages 18 and above):</label>
                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" oninput="computeTotal()">
                    </div>
                    <div class="form-group">
                        <label for="number_of_children">Children (Ages 3-12):</label>
                        <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" oninput="computeTotal()">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h2 class="text-color-1 font-paragraph fw-bold mb-3 mt-3">Time</h2>
                    <div class="form-group">
                        <label for="check_in">Check-in Time</label>
                        <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="08:00">
                    </div>
                    <div class="form-group mt-3">
                        <label for="check_out">Check-out Time</label>
                        <input type="time" id="check_out" name="reservation_check_out" class="form-control" value="12:00">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="reservation_date">Check-in Date:</label>
                    <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required>

                    <label for="check_out_date" class="form-label fw-bold mt-3">Check-out Date</label>
                    <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control">
                </div>
            </div>
        </div>

        <!-- Hidden Input for Total Amount -->
        <input type="hidden" id="amount" name="amount">

        <!-- Submit Button -->
        <div class="d-flex mt-5 mb-5">
            <button type="submit" class="color-background5 text-hover-1 fw-semibold font-paragraph p-3 w-25 rounded-3 border-0" style="margin-left: auto;">Next</button>
        </div>
    </form>

    <script>
    function computeTotal() {
        let numberOfAdults = parseInt(document.getElementById("number_of_adults").value) || 0;
        let numberOfChildren = parseInt(document.getElementById("number_of_children").value) || 0;

        let adultFee = numberOfAdults * 100;  // ₱100 per adult
        let childFee = numberOfChildren * 50; // ₱50 per child

        let totalAccommodation = 0;
        document.querySelectorAll(".accommodation-checkbox:checked").forEach(checkbox => {
            totalAccommodation += parseFloat(checkbox.dataset.price) || 0;
        });

        let totalAmount = adultFee + childFee + totalAccommodation;
        document.getElementById('amount').value = totalAmount.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("number_of_adults").addEventListener("input", computeTotal);
        document.getElementById("number_of_children").addEventListener("input", computeTotal);

        document.querySelector("form").addEventListener("submit", function (event) {
            computeTotal();
            let amountValue = document.getElementById('amount').value;
            let selectedAccommodations = document.querySelectorAll(".accommodation-checkbox:checked").length;

            if (!amountValue || amountValue === "0.00" || selectedAccommodations === 0) {
                event.preventDefault();
                alert("Please select at least one accommodation and one visitor before proceeding.");
            }
        });

        computeTotal(); // Initial computation
    });
    </script>

</body>
</html>