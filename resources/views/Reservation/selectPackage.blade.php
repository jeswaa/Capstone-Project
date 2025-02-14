<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
</head>
<body>
    <form method="POST" action="{{ route ('savePackageSelection') }}">
        @csrf
            <div class="form-group">
                <label for="rentAsWhole">Rent as Whole</label>
                <select id="rentAsWhole" name="rent_as_whole" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="roomPreference">Room Preference</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="single" name="room_preference" value="single">
                    <label class="form-check-label" for="single">Single</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="double" name="room_preference" value="double">
                    <label class="form-check-label" for="double">Double</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="suite" name="room_preference" value="suite">
                    <label class="form-check-label" for="suite">Suite</label>
                </div>
            </div>

            <div class="form-group">
                <label for="activities">Activities</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="hiking" name="activities" value="hiking">
                    <label class="form-check-label" for="hiking">Hiking</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="camping" name="activities" value="camping">
                    <label class="form-check-label" for="camping">Camping</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="swimming" name="activities" value="swimming">
                    <label class="form-check-label" for="swimming">Swimming</label>
                </div>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control">
            </div>

            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" id="time" name="time" class="form-control">
            </div>

            <div class="form-group">
                <label for="specialRequest">Special Request</label>
                <textarea id="specialRequest" name="special_request" class="form-control" rows="3" placeholder="Enter any special requests"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save and Continue</button>
            </div>
    </form>

</body>
</html>