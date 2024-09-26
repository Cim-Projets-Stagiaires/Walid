<?php

namespace App\Http\Controllers;

use App\Models\Demande_de_stage;
use App\Models\User;
use App\Notifications\DemandeApprouve;
use App\Rules\Duree_de_stage;
use App\Rules\ValidDateDebut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = Demande_de_stage::latest()->paginate(6);
        return view('demandes_de_stage.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* dd(auth()->user()); */
        $stagiaire = User::find(auth()->user()->id);
        /* return redirect()->route('demande-de-stage.create', compact('stagiaire')); */
        return view('demandes_de_stage.create', compact('stagiaire'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*  dd($request); */
        $stagiaire = User::find(auth()->user()->id);
        $validated = $request->validate([
            'etablissement' => 'required|string|max:255',
            'type_de_stage' => 'required|string|max:255',
            'modalite_de_stage' => 'required|string|max:255',
            'obligation' => 'required|string|max:255',
            'pole' => ['required', Rule::in(['Services transverses', 'Incubation', 'Valorisation'])],
            /* 'objectif_de_stage' => 'required|string|max:255', */
            'date_de_debut' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'date_de_fin' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:date_de_debut',
                new Duree_de_stage($request->input('date_de_debut'))
            ],
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'lettre_de_motivation' => 'required|mimes:pdf,doc,docx|max:2048',
            /* 'attestation_assurance' => 'required|mimes:pdf,doc,docx|max:2048', */
            'autre_etablissement' => 'nullable|string|max:255',
            'autre_type_de_stage' => 'nullable|string|max:255',
            'planning_mi_temps' => 'nullable|string|max:255'
        ]);

        if ($request->filled('autre_etablissement')) {
            $validated['etablissement'] = $request->input('autre_etablissement');
        }

        if ($request->filled('autre_type_de_stage')) {
            $validated['type_de_stage'] = $request->input('autre_type_de_stage');
        }

        if ($request->input('modalite_de_stage') === 'mi-temps' && $request->filled('planning_mi_temps')) {
            $validated['modalite_de_stage'] = 'mi-temps (' . $request->input('planning_mi_temps') . ')';
        }

        $validated['id_stagiaire'] = auth()->user()->id;
        $validated['cv'] = $request->file('cv')->store('cvs', 'public');
        $validated['lettre_de_motivation'] = $request->file('lettre_de_motivation')->store('lettres', 'public');
        /* $validated['attestation_assurance'] = $request->file('attestation_assurance')->store('attestations', 'public'); */
        $demande = new Demande_de_stage($validated);
        $demande->date_de_debut = $request->input('date_de_debut');
        $demande->date_de_fin = $request->input('date_de_fin');
        $demande->pole = $request->input('pole');
        /* dd($demande); */

        $demande->save();
        $stagiaire['id_demande'] = $demande->id;
        $stagiaire->save();
        /*  dd($demande); */

        return redirect()->route('welcome')->with([
            'status' => 'Demande créée avec succès',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demande = Demande_de_stage::findOrFail($id);
        return view('demandes_de_stage.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $demande = Demande_de_stage::where("id_stagiaire", $id)->firstOrFail();
        return view('demandes_de_stage.edit', compact('demande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $demande = Demande_de_stage::where("id_stagiaire", $id)->firstOrFail();

        $validated = $request->validate([
            'etablissement' => 'sometimes|string|max:255',
            'type_de_stage' => 'sometimes|string|max:255',
            'modalite_de_stage' => 'sometimes|string|max:255',
            'pole' => ['sometimes', Rule::in(['Services transverses', 'Incubation', 'Valorisation'])],
            /* 'objectif_de_stage' => 'sometimes|string|max:255', */
            'date_de_debut' => [
                'sometimes',
                'date',
                'date_format:Y-m-d',
                new ValidDateDebut($demande->date_de_debut),
            ],
            'date_de_fin' => [
                'sometimes',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:date_de_debut',
                new Duree_de_stage($request->input('date_de_debut'))
            ],
            'cv' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
            'lettre_de_motivation' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
            /* 'attestation_assurance' => 'sometimes|file|mimes:pdf,doc,docx|max:2048', */
            'autre_etablissement' => 'nullable|string|max:255',
            'autre_type_de_stage' => 'nullable|string|max:255',
            'planning_mi_temps' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('cv')) {
            Storage::disk('public')->delete($demande->cv);
            $validated['cv'] = $request->file('cv')->store('cvs', 'public');
        }
        if ($request->hasFile('lettre_de_motivation')) {
            Storage::disk('public')->delete($demande->lettre_de_motivation);
            $validated['lettre_de_motivation'] = $request->file('lettre_de_motivation')->store('lettres', 'public');
        }
        /* if ($request->hasFile('attestation_assurance')) {
            $validated['attestation_assurance'] = $request->file('attestation_assurance')->store('attestations', 'public');
        } */
        if ($request->filled('autre_etablissement')) {
            $validated['etablissement'] = $request->input('autre_etablissement');
        }
        if ($request->filled('autre_type_de_stage')) {
            $validated['type_de_stage'] = $request->input('autre_type_de_stage');
        }
        if ($request->input('modalite_de_stage') === 'mi-temps' && $request->filled('planning_mi_temps')) {
            $validated['modalite_de_stage'] = 'mi-temps (' . $request->input('planning_mi_temps') . ')';
        }
        /* dd($validated); */

        $demande->update($validated);

        return view('welcome');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demande = Demande_de_stage::findOrFail($id);
        Storage::disk('public')->delete($demande->cv);
        Storage::disk('public')->delete($demande->lettre_motivation);
        $demande->delete();
        return redirect()->route('demande-de-stage.index');
    }

    public function approve($id)
    {
        $demande = Demande_de_stage::findOrFail($id);
        $demande->status = 'approuvé';
        $demande->save();

        //Notify the stagiaire
        $stagiaire = User::findOrFail($demande->id_stagiaire);
        $stagiaire->notify(new DemandeApprouve($demande));

        return redirect()->route('demande-de-stage.index')->with('approve', 'Demande approved successfully.');
    }

    public function deny($id)
    {
        $demande = Demande_de_stage::findOrFail($id);
        $demande->status = 'refusé';
        $demande->save();

        return redirect()->route('demande-de-stage.index')->with('deny', 'Demande denied successfully.');
    }

}
