<?php

namespace App\Http\Controllers;

use App\Models\Blab;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Contracts\Service\Attribute\Required;


class BlabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // $blabs = Blab::all();
        return view('blabs.index', ['blabs' => Blab::with('user')->latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->blabs()->create($validatedData);

        return redirect(route('blabs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blab $blab)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blab $blab): View
    {
        // Let's verify that the currently logged in user is authorized to update this specific blab.
        Gate::authorize('update', $blab);

        return view('blabs.edit', ['blab' => $blab]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blab $blab): RedirectResponse
    {
        Gate::authorize('update', $blab);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $blab->update($validated);

        return redirect(route('blabs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blab $blab): RedirectResponse
    {
        Gate::authorize('delete', $blab);
        $blab->delete();
        return redirect(route('blabs.index'));
    }
}
