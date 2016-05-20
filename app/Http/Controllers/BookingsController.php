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
            $booking = Booking::where('id', '>', 0)->orderBy('created_at', 'desc')->get();
        } elseif(can('booking.see.own')) {
            $booking = collect();
            foreach(auth()->user()->Anticafes() as $a) {
                $booking->push($a->Bookings);
            }
            $booking = $booking->collapse();
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
                $oldStatus = $booking->status;
                $booking->status = $status;
                $booking->save();
                if($booking->Client->email != null && $oldStatus != $status) $booking->Client->sendEmailNotification($booking, config("statuses.{$status}"));
            }
        }

        return back()->withMsg('common.msg.saved');
    }
}