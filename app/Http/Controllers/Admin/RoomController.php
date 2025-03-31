<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accomodation;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    // Auto-update room availability
        public function updateRoomAvailability()
    {
        // Kunin lahat ng accommodations
        $accommodations = DB::table('accomodations')->get();

        foreach ($accommodations as $accommodation) {
            // Check if may active reservations NA HINDI PA LUMALAGPAS SA CHECK-OUT DATE
            $hasActiveReservation = DB::table('reservation_details')
                ->where('accomodation_id', $accommodation->accomodation_id)
                ->whereDate('reservation_check_out_date', '>', now()->toDateString())  // Dapat hindi pa lampas
                ->exists();

            \Log::info("Accommodation ID: {$accommodation->accomodation_id}, Has Active Reservations? " . ($hasActiveReservation ? 'YES' : 'NO'));

            // Update ang status: magiging available lang kapag WALA nang active reservations
            DB::table('accomodations')->where('accomodation_id', $accommodation->accomodation_id)->update([
                'accomodation_status' => $hasActiveReservation ? "unavailable" : "available",
            ]);
        }

        return response()->json(['message' => 'Accommodation availability updated successfully']);
    }

}


