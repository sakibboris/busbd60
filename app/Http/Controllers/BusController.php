<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bus;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BusController extends Controller
{

    public function index(): View
    {
        $bus = Bus::latest()->paginate(5);
        $buses = Bus::with('bookings')->get();

        // dd($bookings);

        return view('bus.index', compact('bus', 'buses'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('bus.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'busname' => 'required',
            'seats' => 'required|integer',
        ]);

        $bus = new Bus();
        $bus->name = $request->busname;
        $bus->seats = $request->seats;
        $bus->save();

        return redirect()->route('bus.index')->with('success', 'Bus created successfully.');
    }

    public function show($id): View
    {
        $bus = Bus::findOrFail($id);
        $books = Book::where('busname', $bus->name)->get();
        // dd($books);
        return view('bus.show', compact('bus', 'books'));
    }

    public function edit(Bus $bus): View
    {
        return view('bus.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $bus->update($request->all());

        return redirect()->route('bus.index')->with('success', 'Bus updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus): RedirectResponse
    {
        $bus->delete();

        return redirect()->route('bus.index')->with('success', 'Bus deleted successfully');
    }
}
