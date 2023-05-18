<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function landing(Request $request)
    {
		$todaysReservationsCount = Reservation::whereDate('date', Carbon::today())->count();
		$unreadMessagesCount = ContactMessage::where('read', false)->count();
		
		//$todaysReservations = Reservation::whereDate('date', Carbon::today())->orderBy('created_at')->paginate(7);
		//$unreadMessages = ContactMessage::where('read', false)->orderBy('created_at', 'desc')->paginate(3);
		
		$todaysReservations = Reservation::whereDate('date', Carbon::today())->orderBy('created_at')->paginate(7, ['*'], 'reservationsPage');
		$unreadMessages = ContactMessage::where('read', false)->orderBy('created_at', 'desc')->paginate(3, ['*'], 'messagesPage');
		
        return view('admin.landing', ['unreadMessages' => $unreadMessages,
									  'unreadMessagesCount' => $unreadMessagesCount,
									  'todaysReservations' => $todaysReservations,
									  'todaysReservationsCount' => $todaysReservationsCount,
									  ]);
    }
}
