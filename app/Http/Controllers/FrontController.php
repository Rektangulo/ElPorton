<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Menu;
use App\Models\Reservation;
use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\ReservationRequest;

class FrontController extends Controller
{
	public function landing()
	{
		return view('front.landing');
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
		
		// Verify reCAPTCHA response
		/*$response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret' => '',
			'response' => $request->input('g-recaptcha-response')
		]);

		if (! $response->json()['success']) {
			// reCAPTCHA verification failed
			return redirect('/contact')->withErrors(['captcha' => 'reCAPTCHA verification failed']);
		}*/
		
		$message = new ContactMessage;
		$message->fill($request->validated());
		$message->save();

		return redirect('/contact#sent')->with('success', __('front.message_success'));
	}
}
