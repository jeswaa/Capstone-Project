<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Error Message -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <h3>User Details</h3>
                </div>
                <div class="card-body">
                    <h4>Logged in as: {{ auth()->user()->name }}</h4>
                    <form method="POST" action="{{ route('saveReservationDetails') }}">
                        @csrf
                        <div>
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div>
                            <label for="phone">Phone:</label>
                            <input type="text" name="mobileNo" id="phone" value="{{ auth()->user()->mobileNo }}" required>
                        </div>
                        <div>
                            <label for="address">Address:</label>
                            <textarea name="address" id="address">{{ auth()->user()->address }}</textarea>
                        </div>
                        <div>
                            <label for="number_of_guests">Number of Guests:</label>
                            <input type="number" name="number_of_guests" id="number_of_guests" value="{{ auth()->user()->number_of_guests }}" required>
                        </div>
                        <button type="submit">Save and Continue</button>
                    </form>
            </div>
    </div>
</body>
</html>

