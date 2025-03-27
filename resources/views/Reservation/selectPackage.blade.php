<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style> 
.package-label {
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.05);
}

/* Hover Effect */
.package-card:hover .package-label {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 16px 32px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

/* Selected Effect */
.package-checkbox:checked + .package-label,
.package-label.selected {
    background-color: #718355; /* Light green background to indicate selection */
    border: 2px solid #414141;
}

</style>
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

    <div class="d-flex mt-5 mb-5 me-5">
        <a href="{{ route('selectPackageCustom') }}" class="text-decoration-none text-color-1 p-3 color-background5 rounded-3 text-paragraph fw-semibold text-hover-1" style="margin-left: auto;">Custom Package</a>
    </div>

    <form method="POST" action="{{ route('fixPackagesSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="predefined">
        
        <!-- Package Selection -->
        <div class="container d-flex justify-content-start" style="margin-top: -50px;">
            <div class="row w-100 mt-2">
            <form method="POST" action="{{ route('fixPackagesSelection') }}">
                @csrf
                <input type="hidden" name="package_type" value="predefined">
                <h1 class="font-paragraph fw-bold text-color-1 ms-3">Packages</h1>
                @php
                    use Illuminate\Support\Facades\DB;
                    $packages = DB::table('packagestbl')->get();
                @endphp
                <div class="row">
                    @foreach($packages as $package)
                    <div class="col-lg-4 col-md-6 col-12 mb-3 package-card">
                        <div class="form-check">
                            <input type="checkbox" id="package{{ $package->id }}" 
                                name="selected_packages[]" 
                                value="{{ $package->id }}" 
                                data-price="{{ $package->package_price }}" 
                                data-max-guests="{{ $package->package_max_guests }}" 
                                class="position-absolute opacity-0 package-checkbox">
                            
                            <label class="form-check-label w-100 rounded-3 package-label" for="package{{ $package->id }}">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $package->image_package) }}" 
                                            alt="Package Image" 
                                            class="card-img-top img-fluid object-fit-cover"
                                            style="height: 200px;">
                                    </div>
                                    <div class="card-body color-background5">
                                        <h5 class="fs-3 fw-bold text-capitalize color-3 font-paragraph">{{ $package->package_name }}</h5>
                                        <p class="card-text mb-1 font-paragraph fs-6 text-color-1">{{ $package->package_description }}</p>
                                        <p class="mb-1 font-paragraph fs-6 text-color-1"><strong>Duration:</strong> {{ $package->package_duration }}</p>
                                        <p class="mb-1 font-paragraph fs-6 text-color-1"><strong>Room:</strong>  <td>{{ DB::table('accomodations')->where('accomodation_id', $package->package_room_type)->value('accomodation_name') }}</td></p>
                                        <p class="mb-1 font-paragraph fs-6 text-color-1"><strong>Max Guests:</strong> <span class="max-guests">{{ $package->package_max_guests }}</span></p>
                                        <p class="mb-1 font-paragraph fs-6 text-color-1"><strong>Activities:</strong> {{ $package->package_activities }}</p>
                                        <p class="fw-bold mb-0 font-paragraph fs-6 text-color-1">Price: ₱ <span class="package-price">{{ $package->package_price }}</span></p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    @endforeach
                </div>


     
            <!-- Date and Time Selection -->
            @php
                $selectedDate = request()->query('date', ''); // Kunin ang date sa URL
            @endphp
            <div class="row mt-4 d-flex align-items-center justify-content-between mx-auto date-time-selection" style="margin-top: -20px;">
                <div class="row mt-4 d-flex align-items-center justify-content-between mx-auto">
                    <div class="col-md-5 col-12 mb-3 mb-md-0">
                        <label for="reservation_date">Check-in Date:</label>
                        <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required>

                        <label for="check_out_date" class="form-label fw-bold mt-3">Check-out Date</label>
                        <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control">
                    </div>
                </div>
                    
                <!-- Check-in and Check-out Time -->
                <div class="col-md-5 col-12">
                    <label for="check_in" class="form-label fw-bold">Check-in Time</label>
                    <input type="time" id="check_in" name="reservation_check_in" class="form-control p-3" value="08:00">
                    
                    <label for="check_out" class="form-label fw-bold mt-3">Check-out Time</label>
                    <input type="time" id="check_out" name="reservation_check_out" class="form-control p-3" value="12:00">
                </div>
            </div>

            <!-- Special Request Section -->
            <div class="container mt-5">
                <div class="mb-3">
                    <label for="special_requests" class="form-label fw-bold font-paragraph">Special Requests</label>
                    <textarea class="form-control" id="special_requests" name="special_requests" rows="4" placeholder="E.g., vegetarian meal, room decoration, accessibility needs" style="resize: none;"></textarea>
                </div>
            </div>
        <!-- Submit Button -->
        <input type="hidden" id="amount" name="amount">
        <div class="d-flex mt-5 mb-5"  style="text-align: right;">
            <button type="submit" class="color-background5 text-hover-1 fw-semibold font-paragraph p-3 w-25 rounded-3 border-0 " style="margin-left: auto;">Next</button>
        </div>
    </form>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    function computeTotal() {
        let selectedPackages = document.querySelectorAll('input[name="selected_packages[]"]:checked');
        let amountField = document.getElementById('amount');

        let entranceFee = 100;
        let totalAmount = 0;

        selectedPackages.forEach(packageCheckbox => {
            let packagePrice = parseFloat(packageCheckbox.getAttribute('data-price')) || 0;
            let maxGuests = parseInt(packageCheckbox.getAttribute('data-max-guests')) || 0;

            totalAmount += (maxGuests * entranceFee) + packagePrice;
        });

        amountField.value = totalAmount.toFixed(2);
    }

    function updateSelectionUI() {
        let packageCheckboxes = document.querySelectorAll('input[name="selected_packages[]"]');

        packageCheckboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                let label = this.closest(".form-check").querySelector(".package-label");

                if (this.checked) {
                    label.classList.add("selected"); // Add highlight class
                } else {
                    label.classList.remove("selected"); // Remove highlight class
                }

                computeTotal(); // Update amount immediately
            });
        });
    }

    // 🔥 Ensure the amount is computed before submitting the form
    document.querySelector("form").addEventListener("submit", function (event) {
        computeTotal(); // Ensure amount field is set
        let amountValue = document.getElementById('amount').value;
        if (!amountValue || amountValue === "0.00") {
            event.preventDefault(); // Stop form submission if no package is selected
            alert("Please select at least one package before proceeding.");
        }
    });

    updateSelectionUI();
    computeTotal(); // Compute total initially
});
        </script>
<script>
    console.log("Selected Date:", "{{ $selectedDate }}");
</script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get check-in and check-out dates from URL
            const urlParams = new URLSearchParams(window.location.search);
            const checkIn = urlParams.get("checkIn") || "";
            const checkOut = urlParams.get("checkOut") || "";

            // Set values in the date inputs
            document.getElementById("reservation_date").value = checkIn;
            document.getElementById("check_out_date").value = checkOut;

            // Set hidden inputs for form submission
            document.getElementById("hidden_checkin").value = checkIn;
            document.getElementById("hidden_checkout").value = checkOut;
        });
    </script>
</body>
</html>

