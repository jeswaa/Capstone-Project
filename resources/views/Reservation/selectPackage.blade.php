<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            padding: 2rem;
        }
        .progress-line {
            width: 50%;
            height: 2px;
            background-color: #a9b9a6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }
        .progress-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #a9b9a6;
        }
        .progress-dot.active {
            background-color: #718355;
        }
        .custom-btn {
            background-color: #718355 !important;
            padding: 15px 100px !important;
            transition: all 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #889885 !important;
            transform: translateY(-1px);
        }
        .form-control-custom {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px;
        }
        .card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }
        .card:hover {
            border-color: #007bff;
            transform: translateY(-2px);
        }
        .form-check-input[type="checkbox"]:checked + label .card {
            border-color: #007bff;
            background-color: #f0f8ff;
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a202c;
            background: none;
            padding: 0 0 1rem 0;
        }
        .card-body {
            padding: 0;
        }
        .card-body p {
            margin: 0.5rem 0;
            color: #4a5568;
        }
    </style>
</head>
<body class="color-background5" style="font-family: 'Poppins', sans-serif;" >
    
    <div class="position-absolute top-0 start-0 mt-5 ms-5">
        <a href="{{ route('landingpage') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon"></i></a>
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
                    </label>
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

    <div class="container position-relative">
        <!-- Main Content -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="fw-bold mb-4">Packages</h1>
                <hr class="border-3 border-top border-secondary">

                <!-- Progress Indicator -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h4 class="mb-0">Select Package</h4>
                    <div class="d-flex align-items-center progress-line">
                        <div class="progress-dot active position-relative"></div>
                        <div class="progress-dot position-relative"></div>
                        <div class="progress-dot position-relative"></div>
                        <div class="progress-dot position-relative"></div>
                        <div class="progress-dot position-relative"></div>
                    </div>
                </div>

                  <div class="d-flex justify-content-between mt-5" style="margin-right: 200px;">
                      <a href="{{ route('selectPackageCustom') }}" class="btn custom-btn">Custom Package</a>
                  </div>


                <form method="POST" action="{{ route('fixPackagesSelection') }}">
                    @csrf
                    <input type="hidden" name="package_type" value="predefined">
                    
                    <!-- Package Cards -->
                    <div class="row g-4">
                        @php
                            use Illuminate\Support\Facades\DB;
                            $packages = DB::table('packagestbl')->get();
                        @endphp
                        @foreach($packages as $package)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="package{{ $package->id }}" name="selected_packages[]" value="{{ $package->id }}">
                                    <label class="form-check-label" for="package{{ $package->id }}">
                                        <div class="card">
                                            <div class="card-header">{{ $package->package_name }}</div>
                                            <div class="card-body">
                                                <img src="{{ asset('storage/' . $package->image_package) }}" alt="Package Image" class="img-fluid mb-3" style="max-width: 100px;">
                                                <p>{{ $package->package_description }}</p>
                                                <p>Duration: {{ $package->package_duration }}</p>
                                                <p>Room: {{ $package->package_room_type }}</p>
                                                <p>Max Guests: {{ $package->package_max_guests }}</p>
                                                <p>Activities: {{ $package->package_activities }}</p>
                                                <p>Price: {{ $package->package_price }}</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Date and Time Selection -->
                    <div class="row g-4 mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time" class="form-label">Time</label>
                                <h4>Check-in Time</h4>
                                <input type="time" id="check_in" name="reservation_check_in" class="form-control form-control-custom" value="08:00">
                                <h4 class="mt-3">Check-out Time</h4>
                                <input type="time" id="check_out" name="reservation_check_out" class="form-control form-control-custom" value="12:00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="form-label">Start Date</label>
                                <input type="date" id="date" name="reservation_check_in_date" class="form-control form-control-custom" min="{{ now()->addDay()->toDateString() }}">
                            </div>
                            <div class="form-group">
                                <label for="date" class="form-label">End Date</label>
                                <input type="date" id="date" name="reservation_check_out_date" class="form-control form-control-custom" min="{{ now()->addDay()->toDateString() }}">
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-5 mb-5">
                        <button type="submit" class="btn custom-btn">Next</button>
                    </div>
                </form>
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

</body>
</html>



