<?php

namespace App\Http\Controllers;

use App\Models\Blirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('blirps.index', [
            'blirps' => Blirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'file|image'
        ]);

        $request->user()->blirps()->create($validated);

        return redirect(route('blirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blirp $blirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blirp $blirp): View
    {
        $this->authorize('update', $blirp);

        return view('blirps.edit', [
            'blirp' => $blirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blirp $blirp): RedirectResponse
    {
        $this->authorize('update', $blirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $blirp->update($validated);

        return redirect(route('blirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blirp $blirp)
    {
        $this->authorize('delete', $blirp);

        $blirp->delete();

        return redirect(route('blirps.index'));
    }
}
