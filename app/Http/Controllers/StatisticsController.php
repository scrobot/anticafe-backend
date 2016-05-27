<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 27.05.2016
 * Time: 15:46
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Client;
use Anticafe\Http\Models\Stata;
use DB;

class StatisticsController extends Controller
{

    private $title;
    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = "Консоль";
    }

    public function getIndex()
    {
        $q = DB::table('anticafes');
        $stata = new Stata();
        $stata->likes = $q->sum('total_likes');
        $stata->views = $q->sum("total_views");
        $stata->bookings = $q->sum("total_bookings");
        $stata->clients = Client::all()->count();
//        dd($q->sum('total_likes'), $q->sum("total_views"), $q->sum("total_bookings"));
        return view("dashboard.index")->withTitle($this->title)->withStata($stata);
    }

}