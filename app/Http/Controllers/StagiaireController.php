<?php

namespace App\Http\Controllers;

use App\Models\Demande_de_stage;
use App\Models\Presentation;
use App\Models\Rapport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
/* use Barryvdh\DomPDF\Facade as PDF; */
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
/* use PhpOffice\PhpWord\Writer\PDF\DomPDF; */

class StagiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the filter from the request
        $selectedPole = $request->input('pole');

        // Query stagiaires with conditions
        $stagiairesQuery = User::where('type', 'stagiaire')
            ->where('deleted', false)
            ->whereHas('demande', function ($query) {
                $query->where('status', 'approuvé');
            })->whereHas('entretien', function ($query) {
                $query->where('status', 'approuvé');
            });

        // Apply pole filter if selected
        if ($selectedPole) {
            $stagiairesQuery->whereHas('demande', function ($query) use ($selectedPole) {
                $query->where('pole', $selectedPole);
            });
        }

        // Paginate the result
        $stagiaires = $stagiairesQuery->latest()->paginate(6);

        // Get unique poles for the filter dropdown
        $poles = Demande_de_stage::select('pole')->distinct()->pluck('pole');

        // Perform additional logic for progress calculation
        foreach ($stagiaires as $stagiaire) {
            $encadrant = User::find($stagiaire->id_encadrant);
            $demande = $stagiaire->demande;
            if ($demande) {
                $dateDebut = Carbon::parse($demande->date_de_debut);
                $dateFin = Carbon::parse($demande->date_de_fin);
                $stageDurationMonths = $dateDebut->diffInMonths($dateFin) + 1;

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
                $stagiaire->progress = 0;
                $stagiaire->requiredSemiRapports = 0;
                $stagiaire->requiredFinalRapports = 0;
                $stagiaire->requiredPresentations = 0;
                $stagiaire->validatedSemiRapports = 0;
                $stagiaire->validatedFinalRapports = 0;
                $stagiaire->validatedPresentations = 0;
            }
        }

        return view('stagiaires.index', compact("stagiaires", "poles", "selectedPole"));
    }


    public function archive(Request $request)
    {

        // Get the filter from the request
        $selectedPole = $request->input('pole');

        // Query stagiaires with conditions
        $stagiairesQuery = User::where('type', 'stagiaire')
            ->where('deleted', true)
            ->whereHas('demande', function ($query) {
                $query->where('status', 'approuvé');
            })->whereHas('entretien', function ($query) {
                $query->where('status', 'approuvé');
            });

        // Apply pole filter if selected
        if ($selectedPole) {
            $stagiairesQuery->whereHas('demande', function ($query) use ($selectedPole) {
                $query->where('pole', $selectedPole);
            });
        }

        // Paginate the result
        $stagiaires = $stagiairesQuery->latest()->paginate(6);

        // Get unique poles for the filter dropdown
        $poles = Demande_de_stage::select('pole')->distinct()->pluck('pole');

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
        return view('stagiaires.index', compact("stagiaires", "poles", "selectedPole"));
    }

    public function listCandidats(Request $request)
    {
        // First set: Stagiaires with demande status 'postulé' or 'refusé'
        $stagiairesWithDemande = User::where('type', 'stagiaire')
            ->whereHas('demande', function ($query) {
                $query->whereIn('status', ['postulé', 'refusé']);
            })
            ->latest()
            ->get();

        // Second set: Stagiaires who have entretien 'en attente' or 'refusé', or who do not have any entretien
        $stagiairesWithEntretien = User::where('type', 'stagiaire')
            ->where(function ($query) {
                $query->whereHas('entretien', function ($query) {
                    $query->whereIn('status', ['en attente', 'refusé']);
                })
                    ->orWhereDoesntHave('entretien');
            })
            ->get();

        // Merge the two sets and remove duplicates
        $candidats = $stagiairesWithDemande->merge($stagiairesWithEntretien)->unique('id');
        $candidatsSorted = $candidats->sortByDesc('created_at');

        // Paginate the merged collection manually
        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $candidatsCollection = Collection::make($candidatsSorted); // Create a collection from the merged data
        $currentPageItems = $candidatsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Create a paginator instance
        $candidatsPaginated = new LengthAwarePaginator($currentPageItems, $candidatsCollection->count(), $perPage);
        $candidatsPaginated->setPath($request->url());
        /* dd($candidatsPaginated); */

        return view('stagiaires.candidats', compact('candidatsPaginated'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stagiaires.create');
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
            /* 'type' => ['required', Rule::in(['directeur', 'encadrant', 'stagiare', 'responsable admin'])], */
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'etablissement' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'type' => "stagiaire",
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'etablissement' => $request->etablissement,
            'profile_picture' => $profilePicturePath,
        ]);

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stagiaire = User::findOrFail($id);
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
                // Default case for shorter durations
                $requiredSemiRapports = 1;
                $requiredFinalRapports = 1;
                $requiredPresentations = 1;
            }

            // Fetch the number of validated semi and final rapports and presentations
            $validatedSemiRapports = Rapport::where('id_stagiaire', $id)->where('type', 'semi')->where('status', 'validé')->count();
            $validatedFinalRapports = Rapport::where('id_stagiaire', $id)->where('type', 'final')->where('status', 'validé')->count();
            $validatedPresentations = Presentation::where('id_stagiaire', $id)->where('status', 'validé')->count();

            // Total items to track progress
            $totalItems = $requiredSemiRapports + $requiredFinalRapports + $requiredPresentations;
            $completedItems = $validatedSemiRapports + $validatedFinalRapports + $validatedPresentations;

            // Calculate the progress percentage
            $progress = ($totalItems > 0) ? ($completedItems / $totalItems) * 100 : 0;
        } else {
            // If there's no demande, default progress to 0
            $progress = 0;
        }

        return view('stagiaires.show', compact(
            'stagiaire',
            'encadrant',
            'progress',
            'requiredSemiRapports',
            'requiredFinalRapports',
            'requiredPresentations',
            'validatedSemiRapports',
            'validatedFinalRapports',
            'validatedPresentations'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $stagiaire)
    {
        $encadrants = User::where('type', 'encadrant')->get();
        return view('stagiaires.edit', compact('stagiaire', 'encadrants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $stagiaire)
    {
        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^0[67][0-9]{8}$/',
            ],
            'type' => ['sometimes', Rule::in(['directeur', 'encadrant', 'stagiare', 'responsable admin'])],
            'email' => 'sometimes|string|email|max:255|email',
            Rule::unique('users')->ignore($stagiaire->id),
            'password' => 'nullable|string|min:8',
            'etablissement' => 'sometimes|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'encadrant' => 'nullable|exists:users,id',
        ]);

        if ($request->filled('password')) {
            $stagiaire->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($stagiaire->profile_picture) {
                Storage::disk('public')->delete($stagiaire->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $stagiaire->profile_picture = $profilePicturePath;
        }

        // Update other fields except the password and profile_picture
        $stagiaire->update($request->except(['password', 'profile_picture', 'encadrant']));

        // Save the profile picture path if it was updated
        if ($request->hasFile('profile_picture')) {
            $stagiaire->profile_picture = $profilePicturePath;
        }
        if ($request->filled('encadrant')) {
            $stagiaire->id_encadrant = $request->encadrant;
        }
        $stagiaire->save();
        if (Auth::id() == $stagiaire->id) {
            return redirect()->route('stagiaires.show', $stagiaire->id);
        }
        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $demande = Demande_de_stage::where('id_stagiaire', $id)->first();
        $rapports = Rapport::where('id_stagiaire', $id)->get();
        $presentations = Presentation::where('id_stagiaire', $id)->get();
        $user = User::findOrFail($id);
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $demande->delete();
        foreach ($rapports as $rapport) {
            $rapport->delete();
        };
        foreach ($presentations as $presentation) {
            $presentation->delete();
        };

        $user->delete();
        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire deleted successfully.');
    }

    public function archiver($id)
    {
        $stagiaire = User::findOrFail($id);
        $stagiaire->deleted = true;
        $stagiaire->save();
        return redirect()->route('stagiaires.index')->with('success', 'Stagiaires deleted successfully.');
    }

    public function restore($id)
    {
        $stagiaire = User::findOrFail($id);
        $stagiaire->deleted = false;
        $stagiaire->save();
        return redirect()->route('stagiaires.index')->with('success', 'Stagiaires restored successfully.');
    }

    public function downloadAttestation($id){
        $stagiaire = User::where('type', 'stagiaire')->findOrFail($id);
        $year = Carbon::now()->format('y');
        $pdf = PDF::loadView('attestation', [
            'stagiaire' => $stagiaire,
            'code' => $stagiaire->code,
            'year' => $year,
        ]);
        //download attestation
        /* dd($pdf); */
        return $pdf->download('attestation_de_stage_' . $stagiaire->nom . '_' . $stagiaire->prenom . '.pdf');
    }
}
