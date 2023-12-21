<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $speakers = Speaker::all();
        return view('speakers.index', compact('speakers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('speakers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'nume' => 'required',
            'prenume' => 'required',
            'email' => 'required|email',
        ]);

        Speaker::create($request->all());
        return redirect()->route('speakers.index')->with('success', 'Speaker created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Speaker $speaker): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('speakers.show', compact('speaker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Speaker $speaker): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('speakers.edit', compact('speaker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speaker $speaker): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'nume' => 'required',
            'prenume' => 'required',
            'email' => 'required|email',
        ]);

        $speaker->update($request->all());
        return redirect()->route('speakers.index')->with('success', 'Speaker updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speaker $speaker): \Illuminate\Http\RedirectResponse
    {
        $speaker->delete();
        return redirect()->route('speakers.index')->with('success', 'Speaker deleted successfully.');
    }
}
