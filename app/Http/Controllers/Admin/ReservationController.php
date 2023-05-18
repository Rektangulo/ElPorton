<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
		$reservations = Reservation::orderBy('created_at')->paginate(10);
        return view('admin.reservations', ['reservations' => $reservations]);
    }
	
	public function acceptReservation($id)
	{
		$reservation = Reservation::findOrFail($id);
		$reservation->status = 'accepted';
		$reservation->save();

		return response()->json(['success' => true]);
	}

	public function cancelReservation($id)
	{
		$reservation = Reservation::findOrFail($id);
		$reservation->status = 'canceled';
		$reservation->save();

		return response()->json(['success' => true]);
	}
	
	public function showReservationsByDate($date)
	{
		$reservations = Reservation::whereDate('date', $date)->paginate(10);
		$reservations->setPath('/admin/reservations');
		return view('admin.reservationRender', ['reservations' => $reservations]);
	}
	
	public function showReservationsByStatus($status)
	{
		if ($status === 'all') {
			$reservations = Reservation::paginate(10);
		} elseif ($status === 'accepted') {
			$reservations = Reservation::where('status', 'accepted')->paginate(10);
		} elseif ($status === 'canceled') {
			$reservations = Reservation::where('status', 'canceled')->paginate(10);
		} elseif ($status === 'pending') {
			$reservations = Reservation::whereNull('status')->paginate(10);
		}

		$reservations->setPath('/admin/reservations');
		return view('admin.reservationRender', ['reservations' => $reservations]);
	}
	
	public function showReservationsByStatusAndDate($status, $date)
	{
		if ($status === 'all') {
			$reservations = Reservation::whereDate('date', $date)->paginate(10);
		} elseif ($status === 'accepted') {
			$reservations = Reservation::where('status', 'accepted')->whereDate('date', $date)->paginate(10);
		} elseif ($status === 'canceled') {
			$reservations = Reservation::where('status', 'canceled')->whereDate('date', $date)->paginate(10);
		} elseif ($status === 'pending') {
			$reservations = Reservation::whereNull('status')->whereDate('date', $date)->paginate(10);
		}

		$reservations->setPath('/admin/reservations');
		return view('admin.reservationRender', ['reservations' => $reservations]);
	}
}
