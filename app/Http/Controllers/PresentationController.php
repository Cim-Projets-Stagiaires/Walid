<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\User;
use App\Notifications\PresentationNonValider;
use App\Notifications\PresentationValider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        if (Auth::user()->type == 'stagiaire') {
            // Fetch presentations for the currently logged-in stagiaire
            $presentations = Presentation::where('id_stagiaire', $userId)->paginate(5);
        } elseif (Auth::user()->type == 'encadrant') {
            // Fetch presentations for stagiaires assigned to the encadrant
            $stagiaires = User::where('id_encadrant', $userId)->pluck('id'); // Get IDs of stagiaires assigned to this encadrant
            $presentations = Presentation::whereIn('id_stagiaire', $stagiaires)->paginate(5);
        } else {
            // For other user types, fetch all presentations
            $presentations = Presentation::with('stagiaire')->paginate(5);
        }
        return view('presentations.index', compact('presentations'));
    }

    public function list($id){
        $presentations = Presentation::where('id_stagiaire', $id)->paginate(5);
        return view('presentations.index', compact('presentations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lien' => 'required|file|mimes:ppt,pptx,pdf', // Validate file types
        ]);

        $filePath = $request->file('lien')->store('presentations', 'public'); // Store file in 'storage/app/public/presentations'

        Presentation::create([
            'id_stagiaire' => Auth::id(), // The current logged-in stagiaire
            'title' => $validated['title'],
            'lien' => $filePath,
            'status' => 'en attente', // Default status
        ]);

        return redirect()->route('presentations.index')->with('success', 'Presentation uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $presentation = Presentation::findOrFail($id);
        return view('presentations.show', compact('presentation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $presentation = Presentation::findOrFail($id);
        return view('presentations.edit', compact('presentation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $presentation = Presentation::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:ppt,pptx,pdf',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($presentation->file); // Delete the old file
            $filePath = $request->file('file')->store('presentations', 'public');
            $presentation->file = $filePath;
        }

        $presentation->update([
            'title' => $validated['title'],
            'file' => $presentation->file,
        ]);

        return redirect()->route('presentations.index')->with('success', 'Presentation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $presentation = Presentation::findOrFail($id);

        // Check if the file exists and is not null
        if ($presentation->lien && Storage::disk('public')->exists($presentation->lien)) {
            Storage::disk('public')->delete($presentation->lien); // Delete the file
        }

        // Delete the presentation from the database
        $presentation->delete();

        return redirect()->route('presentations.index')->with('success', 'Presentation deleted successfully.');
    }

    public function approuver($id)
    {
        $presentation = Presentation::findOrFail($id);
        $presentation->status = 'validé';
        $presentation->save();
        $stagiaire = $presentation->stagiaire;
        //notify stagiaire
        $stagiaire->notify(new PresentationValider($presentation));
        return redirect()->route('presentations.index')->with('success', 'Presentation approved.');
    }

    public function refuser($id)
    {
        $presentation = Presentation::findOrFail($id);
        $presentation->status = 'refusé';
        $presentation->save();
        $stagiaire = $presentation->stagiaire;
        //notify stagiaire
        $stagiaire->notify(new PresentationNonValider($presentation));
        return redirect()->route('presentations.index')->with('error', 'Presentation refused.');
    }
}
