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
        return view('bookings.list')->withBookings(Booking::where('id', '>', 0)->orderBy('created_at', 'desc')->paginate(15))->withTitle($this->title);
    }

    public function postChangeStatus(Request $request)
    {
        $clients = $request->input('clients');
        if($clients != null) {
            foreach ($clients as $id => $status) {
                Booking::find($id)->update([
                    'status' => $status,
                ]);
            }
        }

        return back()->withMsg('common.msg.saved');
    }
}