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
     color: white;
     border: none;
     border-radius: 5px;
     cursor: pointer;
 }
 
 .custom-btn:hover {
     background-color: #889885 !important;
     transform: translateY(-1px);
 }
 
 .form-control-custom {
     border-radius: 8px;
     border: 1px solid #718355;
     padding: 12px;
     width: 100%;
     background-color: #97A97C;
 }
 
 /* Package Cards Layout */
 .package-container {
     display: flex;
     justify-content: flex-start; /* Align left */
     gap: 20px; /* Space between cards */
     flex-wrap: wrap; /* Allow wrapping */
     padding: 20px;
 }
 

 /* Package Image */
 .package-image {
     width: 120px;
     height: 500px !important;
     object-fit: cover;
     border-radius: 8px;

 }
 .form-check-input {
     display: none;
 }
 
 /* Ensure label has position relative so the checkmark is correctly positioned */
 .form-check-label {
     position: relative;
     cursor: pointer;
     /* Removed padding and border to avoid wrapping issues */
 }
 
 /* Styling for the checked state */
 .form-check-input:checked + .form-check-label {
     background-color: #5a6f48
     border: 3px solid #3b4d32 !important; /* Darker green border */
     box-shadow: 0 0 15px rgba(91, 123, 76, 0.7); /* Green glow */
     transform: scale(1.05); /* Slightly larger */
     transition: all 0.2s ease-in-out;
 }
 
 /* Ensure checkmark appears inside selected card */
 .form-check-input:checked + .form-check-label::after {
     content: "✔";
     font-size: 24px;
     font-weight: bold;
     color: white !important;
    position: absolute;
     top: 10px;
     right: 10px;
     z-index: 90; /* Ensure it appears above other elements */
 }
 
 /* Make sure the card inside the label changes when checked */
 .form-check-input:checked + .form-check-label .card {
     background-color: transparent !important; /* Card should be transparent when selected */
     border: none !important; /* Avoid conflicting borders */
 }
 
 /* Header Section */
 .header-section {
     display: flex;
     align-items: center;
     justify-content: space-between;
     width: 100%;
     margin-bottom: 20px;
 }
 
 h1 {
     color: #2b2b2b;
     font-weight: 600;
     font-size: 1.8rem;
     margin-bottom: 1rem;
     margin-left: 90px;
 }
h4 {
    color: #2b2b2b;
    font-weight: 600;
    font-size: 1.8rem;
    margin-bottom: 1rem;
    margin-left: 90px;
}  
.form-check-label {
    display: block;
}
.row{
    gap: -100px;
}
.package-card {
    border-radius: 20px;
    width: 300px;
    height: 550px;
    transition: 0.3s;
    margin-bottom: 20px;
    border: 2px solid transparent; /* No border by default */
}
.package-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

/* Highlight the selected package */
.package-card.selected {
    background-color: #718355 !important;
    border: 2px solid #414141 !important; /* Dark green border */
    box-shadow: 0 0 15px rgba(91, 123, 76, 0.7); /* Green glow */
    transform: scale(1.05); /* Slightly increase size */
    
}
@media (max-width: 768px) {
    .date-time-selection {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .col-md-5 {
        margin-left: 20px;
    }
    .check-in-time, .check-out-time {
        text-align: center;
    }
    .form-group {
        margin-left:  40px;
    }
    .special-request {
        margin-left: 40px!important;
    }
}

</style>
</head>
<body class="color-background4">
    
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

    <h1>Packages</h1>

    <div class="header-section">
        <h4>Select Package</h4>
        <div class="progress-line">
            <div class="progress-dot active"></div>
            <div class="progress-dot"></div>
            <div class="progress-dot"></div>
            <div class="progress-dot"></div>
            <div class="progress-dot"></div>
        </div>
    </div>
    
    <div class="d-flex mt-5 mb-5" style="text-align: right;">
        <a href="{{ route('selectPackageCustom') }}" class="btn custom-btn" style="margin-left: auto;">Custom Package</a>
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
                <h1 class="font-heading">Packages</h1>
                @php
                    use Illuminate\Support\Facades\DB;
                    $packages = DB::table('packagestbl')->get();
                @endphp
                @foreach($packages as $package)
                <div class="col">
                    <div class="form-check">
                        <input type="checkbox" id="package{{ $package->id }}" 
                            name="selected_packages[]" 
                            value="{{ $package->id }}" 
                            data-price="{{ $package->package_price }}" 
                            data-max-guests="{{ $package->package_max_guests }}" 
                            style="opacity: 0; position: absolute;">
                        <label class="form-check-label" for="package{{ $package->id }}">
                            <div class="color-background5 package-card" id="packageCard{{ $package->id }}" style="border-radius: 20px;  width: 300px;  height: 550px;">
                                <img src="{{ asset('storage/' . $package->image_package) }}" alt="Package Image" style="width: 100%; max-width: 600px; border-radius: 20px;">
                                <div class="p-2">
                                    <p class="fs-4 fw-bold color-3 text-capitalize" >{{ $package->package_name }}</p>
                                    <p class="font-paragraph">{{ $package->package_description }}</p>
                                    <p class="font-paragraph">Duration: {{ $package->package_duration }}</p>
                                    <p class="font-paragraph">Room: {{ $package->package_room_type }}</p>
                                    <p class="font-paragraph">Max Guests: <span class="max-guests">{{ $package->package_max_guests }}</span></p>
                                    <p class="font-paragraph fs-6">Activities: {{ $package->package_activities }}</p>
                                    <p  class="font-paragraph">Price: ₱ <span class="package-price">{{ $package->package_price }}</span></p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach

     
<!-- Date and Time Selection -->
<div class="row mt-4 d-flex align-items-center justify-content-md-between justify-content-center mx-auto date-time-selection" style="margin-top: -20px;">
    <div class="col-md-5 col-12 text-center">
        <label for="check_in_date" class="form-label">Start Date</label>
        <input type="date" id="check_in_date" name="reservation_check_in_date" class="form-control-custom" min="{{ now()->addDay()->toDateString() }}">
        
        <label for="check_out_date" class="form-label mt-3">End Date</label>
        <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control-custom" min="{{ now()->addDay()->toDateString() }}">
    </div>

    <!-- Check-in and Check-out Time -->
    <div class="col-md-5 col-12 check-in-time">
        <label for="check_in" class="form-label" style="text-align: left; display: block;">Check-in Time</label>
        <input type="time" id="check_in" name="reservation_check_in" class="form-control-custom" value="08:00">
        
        <label for="check_out" class="form-label mt-3" style="text-align: left; display: block;">Check-out Time</label>
        <input type="time" id="check_out" name="reservation_check_out" class="form-control-custom" value="12:00">
    </div>
</div>

<!-- Special Request Section -->
<div class="container mt-5">
    <h4 class="special-request" style="text-align: left; margin-left: 0;">Special Requests</h4>

    <div class="form-group">
        <textarea id="special_requests" name="special_requests" class="form-control-custom" rows="4" placeholder="E.g., vegetarian meal, room decoration, accessibility needs"></textarea>
    </div>
</div>



        <!-- Submit Button -->
        <input type="hidden" id="amount" name="amount">
        <div class="d-flex mt-5 mb-5"  style="text-align: right;">
            <button type="submit" class="btn custom-btn" style="margin-left: auto;">Next</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        
            function togglePackageSelection() {
                let packageCheckboxes = document.querySelectorAll('input[name="selected_packages[]"]');
        
                packageCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        let card = document.getElementById('packageCard' + this.id.replace('package', ''));
                        if (this.checked) {
                            card.classList.add('selected'); // Add highlight class
                        } else {
                            card.classList.remove('selected'); // Remove highlight class
                        }
                        computeTotal(); // Ensure total price updates when a package is selected/deselected
                    });
                });
            }
        
            togglePackageSelection();
            computeTotal(); // Compute total initially in case some packages are pre-selected
        });
        </script>
        

</body>
</html>
