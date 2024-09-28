<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\User;
use App\Notifications\NouveauRapport;
use App\Notifications\rapportValide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        if (Auth::user()->type == "stagiaire") {
            $rapports = Rapport::where('id_stagiaire', $userId)->paginate(5);
            if ($rapports->count() == 0) {
                $rapport = new Rapport();
                return view('rapports.index', compact('rapport', 'rapports'));
            }
            return view('rapports.index', compact('rapports'));
        } else {
            /* dd($userId); */
            $rapports = Rapport::with('stagiaire')->paginate(5);
            return view('rapports.index', compact('rapports'));
        }
    }

    public function list($id)
    {
        $rapports = Rapport::where('id_stagiaire', $id)->paginate(4);
        if($rapports->count() == 0){
            $rapport = new Rapport();
            return view('rapports.index', compact('rapport', 'rapports'));
        }
        return view('rapports.index', compact('rapports'));
    }

    public function listRapport($id)
    {
        $encadrant = User::findOrFail($id);
        // Get the stagiaires assigned to this encadrant
        $stagiaires = User::where('id_encadrant', $encadrant->id)->pluck('id');

        // Get the rapports for those stagiaires
        $rapports = Rapport::whereIn('id_stagiaire', $stagiaires)->paginate(5);
        if ($rapports->isEmpty()) {
            $rapport = Rapport::create();
            return view('rapports.listRapports', compact('rapport', 'rapports'));
        }
        return view('rapports.listRapports', compact('rapports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rapports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'lien' => 'required|file|mimes:pdf,doc,docx',
        ]);
        $validated['lien'] = $request->file('lien')->store('rapports', 'public');
        $validated['id_stagiaire'] = auth()->id();
        $validated['status'] = 'postulé'; // Default status when a new report is submitted

        $rapport = new Rapport($validated);
        /* dd($rapport); */
        $rapport->save();

        // Notify the encadrant
        $stagiaire = Auth::user();
        $encadrant = User::find($stagiaire->id_encadrant);
        if ($encadrant) {
            $encadrant->notify(new NouveauRapport($rapport, $encadrant));
        }

        return redirect()->route('rapports.index')->with('success', 'Rapport created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        return view('rapports.show', compact('rapport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        return view('rapports.edit', compact('rapport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rapport = Rapport::findOrFail($id);

        $validated = $request->validate([
            'title' => 'somtimes|string|max:255',
            'type' => 'sometimes|string',
            'lien' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => "sometimes|in:postulé,approuvable,refusé",
        ]);

        if ($request->hasFile('lien')) {
            if ($rapport->lien) {
                Storage::disk('public')->delete($rapport->lien);
            }
            $filePath = $request->file('lien')->store('rapports', 'public');
            $validated['lien'] = $filePath;
        }
            /* dd($validated) */;

        $rapport->update($validated);

        return redirect()->route('rapports.index')->with('success', 'Rapport updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function download(Rapport $rapport)
    {
        $stagiaire = $rapport->stagiaire;
        $filePath = storage_path('app/public/' . $rapport->lien);
        $fileName = $stagiaire->nom . '_' . $stagiaire->prenom . '_' . $rapport->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }
    public function destroy(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        Storage::disk('public')->delete($rapport->getOriginal('lien'));
        $rapport->delete();
        return redirect()->route('rapports.index')->with('success', 'Rapport deleted successfully.');
    }

    public function rapportValide($id)
    {
        $rapport = Rapport::findOrFail($id);
        $rapport->status = 'validé';
        $rapport->save();
        $rapports = Rapport::paginate(5);
        /* dd(1); */
        $stagiaire = $rapport->stagiaire;
        $stagiaire->notify(new rapportValide($rapport));
        return view('rapports.listRapports', compact('rapports'))->with('success', 'Rapport validé.');
    }

    public function rapportNonValide($id)
    {
        $rapport = Rapport::findOrFail($id);
        $rapport->status = 'non validé';
        $rapport->save();
        $rapports = Rapport::paginate(5);
        return view('rapports.listRapports', compact('rapports'))->with('success', 'Rapport  non validé.');
    }
}
