<?php

namespace App\Http\Controllers;

use App\Models\Blab;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Http\RedirectResponse;

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
    public function edit(Blab $blab)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blab $blab)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blab $blab)
    {
        
    }
}
