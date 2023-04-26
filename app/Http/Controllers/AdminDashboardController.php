<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function landing(Request $request)
    {
		$unreadMessagesCount = ContactMessage::where('read', false)->count();
		$unreadMessages = ContactMessage::where('read', false)->orderBy('created_at', 'desc')->paginate(3);
        return view('dashboard.landing', ['unreadMessages' => $unreadMessages,
										  'unreadMessagesCount' => $unreadMessagesCount,
										 ]);
    }
}
