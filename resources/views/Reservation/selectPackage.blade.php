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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .row {
            height: 100%;
        }
        .form-check-input[type="radio"] {
            display: none;
        }
        .form-check-input[type="radio"]:checked + label span {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
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
    <div class="container d-flex justify-content-start">
        <div class="row w-75 g-4 mt-4">
        <form method="POST" action="{{ route('fixPackagesSelection') }}">
            @csrf
            <input type="hidden" name="package_type" value="predefined">
            <h1 class="font-heading">Packages</h1>
            @php
                use Illuminate\Support\Facades\DB;
                $packages = DB::table('packagestbl')->get();
            @endphp
            @foreach($packages as $package)
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="package{{ $package->id }}" 
                        name="selected_packages[]" 
                        value="{{ $package->id }}" 
                        data-price="{{ $package->package_price }}" 
                        data-max-guests="{{ $package->package_max_guests }}">
                    <label class="form-check-label" for="package{{ $package->id }}">
                        <div class="card">
                            <div class="card-header">{{ $package->package_name }}</div>
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $package->image_package) }}" alt="Package Image" style="max-width: 100px; height: auto;">
                                <p>{{ $package->package_description }}</p>
                                <p>Duration: {{ $package->package_duration }}</p>
                                <p>Room: {{ $package->package_room_type }}</p>
                                <p>Max Guests: <span class="max-guests">{{ $package->package_max_guests }}</span></p>
                                <p>Activities: {{ $package->package_activities }}</p>
                                <p>Price: ₱ <span class="package-price">{{ $package->package_price }}</span></p>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>


     
            <!-- Date and Time Selection -->
            @php
                $selectedDate = request()->query('date', ''); // Kunin ang date sa URL
            @endphp
            <div class="row mt-4 d-flex align-items-center justify-content-between mx-auto date-time-selection" style="margin-top: -20px;">
                <div class="col-md-5 col-12 mb-3 mb-md-0">
                    <label for="reservation_date">Selected Date:</label>
                    <input type="date" id="reservation_date" name="reservation_check_in_date" value="{{ $selectedDate }}" class="form-control" required>

                    <label for="check_out_date" class="form-label fw-bold mt-3">End Date</label>
                    <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control p-3" min="{{ now()->addDay()->toDateString() }}">
                </div>
                
                <!-- Check-in and Check-out Time -->
                <div class="col-md-5 col-12">
                    <label for="check_in" class="form-label fw-bold">Check-in Time</label>
                    <input type="time" id="check_in" name="reservation_check_in" class="form-control p-3" value="08:00">
                    
                    <label for="check_out" class="form-label fw-bold mt-3">Check-out Time</label>
                    <input type="time" id="check_out" name="reservation_check_out" class="form-control p-3" value="12:00">
                </div>
            </div>
        @endforeach
            <div class="col-md-6">
                <div class="form-group">
                    <label for="time">Time</label>
                    <h1>Check-in Time</h1>
                    <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="08:00">
                    <h1>Check-out Time</h1>
                    <input type="time" id="check_out" name="reservation_check_out" class="form-control" value="12:00">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date">Start Date</label>
                    <input type="date" id="date" name="reservation_check_in_date" class="form-control" min="{{ now()->addDay()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="date">End Date</label>
                    <input type="date" id="date" name="reservation_check_out_date" class="form-control" min="{{ now()->addDay()->toDateString() }}">
                </div>
            </div>
            <input type="hidden" name="amount" id="amount">
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
        </div>
    </div>
    
    <input type="hidden" name="amount" id="amount">

    <div class="position-absolute top-0 end-0 mt-3 me-3">
        <a href="{{ route ('selectPackageCustom') }}"><button type="button" class="btn btn-primary">Custom Package</button></a>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function computeTotal() {
        let selectedPackages = document.querySelectorAll('input[name="selected_packages[]"]:checked');
        let amountField = document.getElementById('amount');

        let entranceFee = 100; // Fixed entrance fee
        let totalAmount = 0;

        selectedPackages.forEach(packageCheckbox => {
            let packagePrice = parseFloat(packageCheckbox.getAttribute('data-price')) || 0;
            let maxGuests = parseInt(packageCheckbox.getAttribute('data-max-guests')) || 0;

            totalAmount += (maxGuests * entranceFee) + packagePrice;
        });

        // Update hidden input field
        amountField.value = totalAmount.toFixed(2);
        console.log("Total Amount: ₱ " + totalAmount.toFixed(2)); // Debugging
    }

    // Attach event listeners to checkboxes
    document.querySelectorAll('input[name="selected_packages[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', computeTotal);
    });

    computeTotal(); // Compute on page load
});
        </script>
<script>
    console.log("Selected Date:", "{{ $selectedDate }}");
</script>
</body>
</html>



