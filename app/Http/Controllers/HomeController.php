<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bus = Bus::latest()->paginate(5);
        $buses = Bus::with('bookings')->get();

        return view('bus.index', compact('bus', 'buses'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
