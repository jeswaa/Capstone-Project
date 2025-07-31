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
        <!-- Display Error Messages -->
        @include('Alert.errorLogin')
        <div class="card">
            <div class="card-header">
                <h3>User Details</h3>
            </div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="input-box" placeholder="Enter your email"
                value="{{auth()->user()->email}}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Mobile No</label>
                <input type="number" name="mobileNo" class="input-box" placeholder="Enter mobile number"
                    value="{{auth()->user()->mobileNo}}" required>
            </div>
        </div>

        <button type="submit" class="btn custom-button mt-3 ">
            NEXT
        </button>
        </form>
    </div>
</body>

</html>