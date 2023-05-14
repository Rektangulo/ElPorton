<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationDateService
{
    public static function isReservationLimitReached($date, $time)
	{
		$formattedDate = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
		$reservationCount = Reservation::where('date', $formattedDate)
			->where('time', $time)
			->where(function ($query) {
				$query->whereNull('status')
					->orWhere('status', 'accepted');
			})
			->count();

		return $reservationCount >= 10;
	}
}