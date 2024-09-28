<?php

namespace App\Http\Controllers;

use App\Models\Demande_de_stage;
use App\Models\Entretien;
use App\Models\User;
use App\Notifications\CreateAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('type', 'responsable admin')->get();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $admin = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'type' => "responsable admin",
            'email' => $request->email,
            'password' => Hash::make("admin@cim"),
        ]);
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $admin->profile_picture = $profilePicturePath;
        }
        $admin->save();
        /* dd($admin); */
        // Send notification to the admin
        $admin->notify(new CreateAdmin($admin));
        /* dd($data); */

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::findOrFail($id);
        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = User::findOrFail($id);
        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes',
            'string',
            'regex:/^0[67][0-9]{8}$/',
            'type' => ['sometimes', 'required', Rule::in(['directeur', 'encadrant', 'stagiare'])],
            'email' => 'sometimes|required|string|email|',
            Rule::unique('users')->ignore($admin->id),
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($admin->profile_picture) {
                Storage::disk('public')->delete($admin->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $admin->profile_picture = $profilePicturePath;
        }

        // Update other fields except the password and profile_picture
        $admin->update($request->except(['password', 'profile_picture']));

        // Save the profile picture path if it was updated
        if ($request->hasFile('profile_picture')) {
            $admin->profile_picture = $profilePicturePath;
            $admin->save();
        }

        return redirect()->route('admins.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'User deleted successfully.');
    }

    public function dashboard()
    {
        // Existing statistics
        $totalDemandes = Demande_de_stage::count();
        $approvedDemandes = Demande_de_stage::where('status', 'approuvé')->count();
        $refusedDemandes = Demande_de_stage::where('status', 'refusé')->count();
        $pendingDemandes = Demande_de_stage::where('status', 'postulé')->count();

        $etablissements = Demande_de_stage::select('etablissement', DB::raw('count(*) as total'))
            ->groupBy('etablissement')
            ->get();

        $demandesParMois = Demande_de_stage::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('MONTHNAME(created_at) as month'),
            DB::raw('MONTH(created_at) as month_number'),
            DB::raw('YEAR(created_at) as year')
        )
            ->groupBy('month')
            ->orderBy('year')
            ->orderBy('month_number')
            ->get();

        /* $stagiairesParEtablissement = Demande_de_stage::select('etablissement', DB::raw('COUNT(DISTINCT id_stagiaire) as total'))
            ->groupBy('etablissement')
            ->get(); */
        /* dd($stagiairesParEtablissement); */

        $stagiairesParEtablissement = Demande_de_stage::select('etablissement', DB::raw('COUNT(DISTINCT demande_de_stages.id_stagiaire) as total'))
            ->where('demande_de_stages.status', 'approuvé')  // Only approved demandes
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('entretiens')
                    ->whereColumn('entretiens.id_stagiaire', 'demande_de_stages.id_stagiaire')  // Match stagiaire
                    ->where('entretiens.status', 'approuvé');  // Only approved entretiens
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('users')
                    ->whereColumn('users.id', 'demande_de_stages.id_stagiaire')  // Match stagiaire
                    ->where('users.deleted', false);  // Only non-deleted users
            })
            ->groupBy('etablissement')
            ->get();
        /* dd($stagiairesParEtablissement);  */

        $stagiairesPerPole = Demande_de_stage::select('pole', DB::raw('COUNT(DISTINCT demande_de_stages.id_stagiaire) as total'))
            ->where('demande_de_stages.status', 'approuvé')
            ->whereIn('pole', ['Valorisation', 'Incubation', 'Services Transverses'])  // Only approved demandes
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('entretiens')
                    ->whereColumn('entretiens.id_stagiaire', 'demande_de_stages.id_stagiaire')  // Match stagiaire
                    ->where('entretiens.status', 'approuvé');  // Only approved entretiens
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('users')
                    ->whereColumn('users.id', 'demande_de_stages.id_stagiaire')  // Match stagiaire
                    ->where('users.deleted', false);  // Only non-deleted users
            })
            ->groupBy('pole')
            ->get();
            /* dd($stagiairesParPole); */

        // New statistics for entretiens
        $totalEntretiens = Entretien::count();
        $approvedEntretiens = Entretien::where('status', 'approuvé')->count();
        $refusedEntretiens = Entretien::where('status', 'refusé')->count();
        $pendingEntretiens = Entretien::where('status', 'en attente')->count();

        return view('dashboard', [
            'totalDemandes' => $totalDemandes,
            'approvedDemandes' => $approvedDemandes,
            'refusedDemandes' => $refusedDemandes,
            'pendingDemandes' => $pendingDemandes,
            'etablissements' => $etablissements,
            'demandesParMois' => $demandesParMois,
            'stagiairesParEtablissement' => $stagiairesParEtablissement,
            'totalEntretiens' => $totalEntretiens,
            'approvedEntretiens' => $approvedEntretiens,
            'refusedEntretiens' => $refusedEntretiens,
            'pendingEntretiens' => $pendingEntretiens,
            'stagiairesPerPole' => $stagiairesPerPole
        ]);
    }
}
