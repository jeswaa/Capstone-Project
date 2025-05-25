<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 25px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        h2 {
            color: #2a5d34;
            margin-top: 0;
        }
        h5 {
            color: #2a5d34;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .status-box {
            background-color: #f0f7f1;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2a5d34;
        }
        .details-box {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #2a5d34;
            display: inline-block;
            width: 120px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            color: #777;
            font-size: 14px;
        }
        .amount-highlight {
            font-size: 18px;
            font-weight: bold;
            color: #2a5d34;
        }
        .message-box {
            background-color: #fff8e6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #e6a700;
        }
        .thank-you {
            font-size: 16px;
            color: #2a5d34;
            font-weight: bold;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Payment Status Update</h2>
        </div>

        <p>Dear {{ $reservation->name }},</p>
        
        <div class="status-box">
            <h5>Your payment status has been updated:</h5>
            <p><strong>Payment Status:</strong> <span style="color: {{ $reservation->payment_status === 'paid' ? '#2a5d34' : ($reservation->payment_status === 'pending' ? '#e6a700' : ($reservation->payment_status === 'booked' ? '#428bca' : '#d9534f')) }}; font-weight: bold; text-transform: capitalize;">
                {{ $reservation->payment_status }}
            </span></p>
            <p>Your reservation status is: <span style="color: {{ $reservation->reservation_status === 'reserved' ? '#428bca' : ($reservation->reservation_status === 'checked-in' || $reservation->reservation_status === 'checked-out' ? '#2a5d34' : ($reservation->reservation_status === 'cancelled' ? '#d9534f' : 'inherit')) }}; font-weight: bold; text-transform: capitalize;">{{ $reservation->reservation_status }}</span></p>
        </div>

        <div class="details-box">
            <div class="detail-item">
                <span class="detail-label">Mobile No:</span> {{ $reservation->mobileNo ?? 'No mobile number provided'  }}
            </div>
            <div class="detail-item">
                <span class="detail-label">Address:</span> {{ $reservation->address ?? 'No address provided' }}
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Amount:</span> 
                <span class="amount-highlight">₱ {{ number_format($reservation->amount, 2) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Balance:</span> 
                <span class="amount-highlight">₱ {{ number_format($balance, 2) }}</span>
            </div>
        </div>

        @if($reservationDetails)
        <div class="details-box">
            <h5>Reservation Details</h5>
            
            @if(isset($reservationDetails->package_name))
                <div class="detail-item">
                    <span class="detail-label">Package:</span> {{ $reservationDetails->package_name }}
                </div>
            @elseif(isset($accomodations))
                <div class="detail-item">
                    <span class="detail-label">Accommodation:</span> 
                    {{ is_array($accomodations) ? implode(', ', $accomodations) : $accomodations }}
                </div>
            @endif
            
            @if(isset($reservationDetails->package_room_type))
                <div class="detail-item">
                    <span class="detail-label">Room Type:</span> {{ $reservationDetails->package_room_type }}
                </div>
            @endif
            
            @if(isset($activities) && !empty($activities))
                <div class="detail-item">
                    <span class="detail-label">Activities:</span> 
                    {{ is_array($activities) ? implode(', ', $activities) : $activities }}
                </div>
            @elseif(isset($reservationDetails->package_activities))
                <div class="detail-item">
                    <span class="detail-label">Activities:</span> {{ $reservationDetails->package_activities }}
                </div>
            @endif
            
            <div class="detail-item">
                <span class="detail-label">Check-in Date:</span> {{ date('F j, Y', strtotime($reservationDetails->reservation_check_in_date)) }}
            </div>
            <div class="detail-item">
                <span class="detail-label">Check-out Date:</span> {{ date('F j, Y', strtotime($reservationDetails->reservation_check_out_date)) }}
            </div>
            <div class="detail-item">
                <span class="detail-label">Check-in Time:</span> {{ date('g:i A', strtotime($reservationDetails->reservation_check_in)) }}
            </div>
            <div class="detail-item">
                <span class="detail-label">Check-out Time:</span> {{ date('g:i A', strtotime($reservationDetails->reservation_check_out)) }}
            </div>
        </div>
        @endif

        @if($customMessage)
        <div class="message-box">
            <h5>Message from Lelo's Resort:</h5>
            <p>{{ $customMessage }}</p>
        </div>
        @endif

        <p class="thank-you">Thank you for choosing Lelo's Resort!</p>

        <div class="footer">
            <div class="booking-policies" style="margin-bottom: 20px; padding: 15px; background-color: #f8f8f8; border-radius: 8px;">
                <h5 style="color: #2a5d34; margin-bottom: 10px;">Our Policies:</h5>
                <ul style="list-style-type: disc; margin-left: 20px; font-size: 14px;">
                    <li>50% down payment is required to confirm your reservation</li>
                    <li>Full payment must be settled upon check-in</li>
                    <li>No refund for no-show or late cancellation</li>
                    <li>Early check-in and late check-out are subject to room availability</li>
                    <li>The resort is not liable for loss of personal belongings</li>
                    <li>Guests must follow resort rules and regulations during their stay</li>
                </ul>
            </div>
            
            <p>If you have any questions, please contact us at:</p>
            <p>Email: lelosresort@gmail.com | Phone: +09297278336</p>
            <p>© {{ date('Y') }} Lelo's Resort. All rights reserved.</p>
        </div>
    </div>
</body>
</html>