<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\Rapport;
use App\Models\User;
use App\Notifications\CreateEncadrant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EncadrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encadrants = User::where("type", "encadrant")->where('deleted', false)->paginate(6);
        return view('encadrants.index', compact('encadrants'));
    }

    public function archive()
    {
        $encadrants = User::where("type", "encadrant")->where('deleted', true)->paginate(6);
        return view('encadrants.archive', compact('encadrants'));
    }
    public function listStagiaires($id)
    {
        $encadrant = User::findOrFail($id);
        $stagiaires = User::where('id_encadrant', $encadrant->id)->where('deleted', false)->latest()->paginate(5);
        foreach ($stagiaires as $stagiaire) {
            $encadrant = User::find($stagiaire->id_encadrant);
            $demande = $stagiaire->demande;
            if ($demande) {
                // Calculate the duration in months between 'date_de_debut' and 'date_de_fin'
                $dateDebut = Carbon::parse($demande->date_de_debut);
                $dateFin = Carbon::parse($demande->date_de_fin);
                $stageDurationMonths = $dateDebut->diffInMonths($dateFin) + 1;
                // Determine the required number of semi and final rapports and presentations
                if ($stageDurationMonths <= 2) {
                    $requiredSemiRapports = 1;
                    $requiredFinalRapports = 1;
                    $requiredPresentations = 2;
                } elseif ($stageDurationMonths == 3) {
                    $requiredSemiRapports = 1;
                    $requiredFinalRapports = 1;
                    $requiredPresentations = 2;
                } elseif ($stageDurationMonths >= 4) {
                    $requiredSemiRapports = 1;
                    $requiredFinalRapports = 2;
                    $requiredPresentations = 3;
                } else {
                    $requiredSemiRapports = 1;
                    $requiredFinalRapports = 1;
                    $requiredPresentations = 1;
                }
                // Fetch the number of validated semi and final rapports and presentations
                $validatedSemiRapports = Rapport::where('id_stagiaire', $stagiaire->id)->where('type', 'semi')->where('status', 'validé')->count();
                $validatedFinalRapports = Rapport::where('id_stagiaire', $stagiaire->id)->where('type', 'final')->where('status', 'validé')->count();
                $validatedPresentations = Presentation::where('id_stagiaire', $stagiaire->id)->where('status', 'validé')->count();
                // Total items to track progress
                $totalItems = $requiredSemiRapports + $requiredFinalRapports + $requiredPresentations;
                $completedItems = $validatedSemiRapports + $validatedFinalRapports + $validatedPresentations;
                // Calculate the progress percentage
                $stagiaire->progress = ($totalItems > 0) ? ($completedItems / $totalItems) * 100 : 0;
                $stagiaire->requiredSemiRapports = $requiredSemiRapports;
                $stagiaire->requiredFinalRapports = $requiredFinalRapports;
                $stagiaire->requiredPresentations = $requiredPresentations;
                $stagiaire->validatedSemiRapports = $validatedSemiRapports;
                $stagiaire->validatedFinalRapports = $validatedFinalRapports;
                $stagiaire->validatedPresentations = $validatedPresentations;
                $stagiaire->encadrant = $encadrant;
            } else {
                // If there's no demande, default progress to 0
                $stagiaire->progress = 0;
                $stagiaire->requiredSemiRapports = 0;
                $stagiaire->requiredFinalRapports = 0;
                $stagiaire->requiredPresentations = 0;
                $stagiaire->validatedSemiRapports = 0;
                $stagiaire->validatedFinalRapports = 0;
                $stagiaire->validatedPresentations = 0;
            }
        }

        return view('encadrants.listStagiaires', compact('encadrant', 'stagiaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $encadrant = new User();
        return view('encadrants.create', compact('encadrant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^0[67][0-9]{8}$/',
            ],
            'email' => 'required|string|email|max:255|unique:users',
            'etablissement' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'permanent' => 'boolean',
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $encadrant = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'type' => "encadrant",
            /* 'id_encadrant' => Auth::id(), */
            'email' => $request->email,
            'password' => Hash::make("123456789"),
            'etablissement' => $request->etablissement,
            'profile_picture' => $profilePicturePath,
            'permanent' => $request->permanent,

        ]);
        $encadrant->save();
        // Send notification to the encadrant
        $encadrant->notify(new CreateEncadrant($encadrant));
        /* dd($encadrant); */

        return redirect()->route('encadrants.index')->with('success', 'Encadrant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $encadrant = User::findOrFail($id);
        $stagiaires = User::where('id_encadrant', $encadrant->id)->where('type', 'stagiaire')->get();
        return view('encadrants.show', compact('encadrant', 'stagiaires'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $encadrant = User::findOrFail($id);
        return view('encadrants.edit', compact('encadrant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $encadrant = User::findOrFail($id);
        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^0[67][0-9]{8}$/',
            ],
            'type' => ['sometimes', 'required', Rule::in(['directeur', 'encadrant', 'stagiare', 'responsable admin'])],
            'email' => 'sometimes|string|email|max:255|email',
            Rule::unique('users')->ignore($encadrant->id),
            'password' => 'nullable|string|min:8',
            'etablissement' => 'sometimes|required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'permanent' => 'sometimes|boolean',
        ]);

        if ($request->filled('password')) {
            $encadrant->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($encadrant->profile_picture) {
                Storage::disk('public')->delete($encadrant->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $encadrant->profile_picture = $profilePicturePath;
        }

        // Update other fields except the password and profile_picture
        $encadrant->update($request->except(['password', 'profile_picture']));

        // Save the profile picture path if it was updated
        if ($request->hasFile('profile_picture')) {
            $encadrant->profile_picture = $profilePicturePath;
            $encadrant->save();
        }

        return redirect()->route('encadrants.index')->with('success', 'encadrant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stagiaires = User::where('id_encadrant', $id)->get();
        /* dd($stagiaires); */
        if ($stagiaires) {
            foreach ($stagiaires as $stagiaire) {
                $stagiaire->id_encadrant == null;
                $stagiaire->update();
            }
        }
        $encadrant = User::findOrFail($id);
        $encadrant->delete();
        return redirect()->route('encadrants.index')->with('success', 'Encadrant deleted successfully.');
    }
}
