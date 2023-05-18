<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Menu;
use App\Models\Reservation;
use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\ReservationRequest;
use App\Services\ReservationDateService;
use Log;

class FrontController extends Controller
{
	public function landing()
	{
		return view('front.landing');
	}
	
	public function showCalendar()
	{
		return view('front.reservation-calendar');
	}
	
	public function checkDate(Request $request)
	{
		$date = $request->input('date');
		$time = $request->input('time');

		Log::info($date);
		if (!ReservationDateService::isReservationLimitReached($date, $time)) {
			return redirect('/reservations?date=' . $date . '&time=' . $time);
		} else {
			// show error message
			return redirect('/reservation')->withInput()->withErrors(['date' => __('front.reservation_limit_reached')]);
		}
	}
	
	public function reservation()
	{
		return view('front.reservation');
	}
	
	public function submitReservation(ReservationRequest $request) {
		
		$reservation = new Reservation;
		$reservation->fill($request->validated());
		$reservation->save();
		
		$request->session()->flash('reservation_id', $reservation->id);
		$request->session()->flash('reservation_created', true);
		
		return redirect('/reservation-success');
	}
	
	public function reservationSuccess(Request $request)
	{
		if ($request->session()->has('reservation_created')) {
			
			$reservation = Reservation::find($request->session()->get('reservation_id'));
			return view('front.reservation-success')->with([
				'reservation' => $reservation,
			]);
			
		} else {
			return redirect('/');
		}
	}
	
	public function cookie()
	{
		return view('front.cookies');
	}
	
    public function menu()
    {
        $categories = Category::with('menus')->get();
		$recommendedMenus = Menu::where('recommended', true)->get();
		
        return view('front.menu', ['categories' => $categories,
							 'recommendedMenus' => $recommendedMenus,
							]);
    }
	
	public function contact()
	{
		return view('front.contact');
	}
	
	public function submitContactForm(ContactFormRequest $request) {
		
		$message = new ContactMessage;
		$message->fill($request->validated());
		$message->save();

		return redirect('/contact#sent')->with('success', __('front.message_success'));
	}
}
