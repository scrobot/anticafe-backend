<?php

namespace Anticafe\Http\Controllers;

use Anticafe\Http\Models\Booking;
use Anticafe\Http\Models\Client;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = "Бронирование";
    }

    public function getIndex()
    {
        if(can('booking.see.all')) {
            $booking = Booking::where('id', '>', 0)->orderBy('created_at', 'desc');
        } elseif(can('booking.see.own')) {
            $booking = auth()->user()->Bookings;
        } else {
            check_perm('booking.see.all');
        }

        return view('bookings.list')->withBookings($booking)->withTitle($this->title);
    }

    public function postChangeStatus(Request $request)
    {
        $clients = $request->input('clients');
        if($clients != null) {
            foreach ($clients as $id => $status) {
                $booking = Booking::find($id);
                $booking->update([
                    'status' => $status,
                ]);
                $booking->Client->sendEmailNotification($booking, config("statuses.{$status}"));
            }
        }

        return back()->withMsg('common.msg.saved');
    }
}