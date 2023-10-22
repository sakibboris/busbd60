<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'busname' => 'required',
            'seatnumber' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'phone' => 'required',
        ]);

        $bus = new Book();
        $bus->busname = $request->busname;
        $bus->seatnumber = $request->seatnumber;
        $bus->username = $request->username;
        $bus->gender = $request->gender;
        $bus->phone = $request->phone;
        $bus->save();

        return redirect()->route('bus.index')->with('success', 'Bus created successfully.');
    }
}
