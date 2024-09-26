<?php

namespace App\Http\Controllers;

use App\Models\Entretien;
use App\Models\User;
use App\Notifications\EntretienApprouved;
use App\Notifications\EntretienNotification;
use App\Notifications\EntretienRefused;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntretienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stagiaires = User::where('type', 'stagiaire')
            ->whereHas('demande', function ($query) {
                $query->select('status')->from('demande_de_stages')->where('status', 'approuvé');
            })
            ->whereNotIn('id', function ($query) {
                $query->select('id_stagiaire')->from('entretiens');
            })
            ->get();
        $entretiens = Entretien::with('stagiaire')->orderBy('created_at', 'desc')->paginate(6);
        return view('entretiens.index', compact('entretiens','stagiaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* $stagiaires = User::where('type', 'stagiaire')->get(); */
        // Get all stagiaires who do not have an entretien yet
        $stagiaires = User::where('type', 'stagiaire')
            ->whereHas('demande', function ($query) {
                $query->select('status')->from('demande_de_stages')->where('status', 'approuvé');
            })
            ->whereNotIn('id', function ($query) {
                $query->select('id_stagiaire')->from('entretiens');
            })
            ->get();
        /* dd($stagiaires); */
        return view('entretiens.create', compact('stagiaires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'id_stagiaire' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today', // Allow today or future dates
            'time' => ['required', 'date_format:H:i', function ($attribute, $value, $fail) use ($request) {
                $date = $request->input('date');
                $currentDate = now()->format('Y-m-d');
                // If the date is today, ensure the time is not in the past
                if ($date === $currentDate && Carbon::parse($value)->lt(now())) {
                    $fail('The ' . $attribute . ' must be equal to or after the current time for today.');
                }
            }],
        ]);

        // Check if an entretien already exists at this date and time
        $existingEntretien = Entretien::where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($existingEntretien) {
            return redirect()->back()->withErrors([
                'error' => "There is already an entretien scheduled at " . $validated['time'] . " on " . $validated['date']
            ]);
        }

        // If no conflict, create the entretien
        $entretien =  Entretien::create($validated);
        // find candidat
        $candidat = User::find($validated['id_stagiaire']);
        //notify candidat
        $candidat->notify(new EntretienNotification($entretien));
        return redirect()->route('entretiens.index')->with('success', 'Entretien créé avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entretien = Entretien::find($id);
        return view('entretiens.show', compact('entretien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entretien = Entretien::find($id);
        $stagiaires = User::where('type', 'stagiaire')->get();
        return view('entretiens.edit', compact('entretien', 'stagiaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entretien = Entretien::find($id);
        $validated = $request->validate([
            'id_stagiaire' => 'required|exists:stagiaires,id',
            'date' => 'required|date',
            'status' => 'required|in:approuvé,refusé,en attente',
        ]);

        $entretien->update($validated);

        return redirect()->route('entretiens.index')->with('success', 'Entretien mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entretien = Entretien::find($id);
        $entretien->delete();
        return redirect()->route('entretiens.index')->with('success', 'Entretien supprimé avec succès.');
    }

    public function approuver($id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->status = 'approuvé';
        $entretien->save();
        //notifier candidat que sa candidature est approuvé
        $stagiaire = User::findOrFail($entretien->id_stagiaire);
        $stagiaire->notify(new EntretienApprouved($entretien));
        return redirect()->route('entretiens.index')->with('success', 'candidat approuvé.');
    }

    public function refuser($id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->status = 'refusé';
        $entretien->save();

        $stagiaire = User::findOrFail($entretien->id_stagiaire);
        $stagiaire->notify(new EntretienRefused($entretien));
        return redirect()->route('entretiens.index')->with('refuse', 'candidat refusé.');
    }

    public function automateForm()
    {
        /* dd('walid'); */
        /* $stagiaires = User::where('type', 'stagiaire')->get(); */
        return view('entretiens.automate');
    }

    public function automate(Request $request)
    {
        // Validate the inputs
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => ['required', 'date_format:H:i', function ($attribute, $value, $fail) use ($request) {
                $date = $request->input('date');
                $currentDate = now()->format('Y-m-d');
                $currentTime = now()->format('H:i');
                // If the selected date is today, ensure the start time is after or equal to the current time
                if ($date === $currentDate && $value < $currentTime) {
                    $fail("The start time must be equal to or after the current system time for today's date.");
                }
            }],
            'end_time' => 'required|date_format:H:i|after:start_time',
            'number_of_stagiaires' => 'required|integer|min:1',
        ]);

        // Parse the date and time inputs
        $date = $validated['date'];
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $numberOfStagiaires = $validated['number_of_stagiaires'];
        /* dd($startTime, $endTime); */

        // Calculate the total duration in minutes between start and end time
        $totalDuration = $endTime->diffInMinutes($startTime); // Total minutes between start and end time
        /* dd($totalDuration); */
        $durationPerInterview = floor($totalDuration / $numberOfStagiaires); // Ensure whole minutes per interview
        /* dd($durationPerInterview, $totalDuration); */

        // Fetch the first X available stagiaires who have an approved demande and no existing entretien
        $stagiaires = User::where('type', 'stagiaire')
            ->whereHas('demande', function ($query) {
                $query->where('status', 'approuvé');  // Only select stagiaires with 'approuvé' demandes
            })
            ->whereNotIn('id', function ($query) {
                $query->select('id_stagiaire')->from('entretiens');  // Exclude stagiaires who already have an entretien
            })
            ->limit($numberOfStagiaires)
            ->get();

        // Check if there are enough stagiaires
        if ($stagiaires->count() < $numberOfStagiaires) {
            return redirect()->back()->withErrors([
                'error' => "Not enough available stagiaires. Maximum available: " . $stagiaires->count()
            ]);
        }

        // Create the entretiens
        foreach ($stagiaires as $stagiaire) {
            // Check if an entretien already exists at this date and time
            $existingEntretien = Entretien::where('date', $date)
                ->where('time', $startTime->format('H:i'))
                ->exists();

            if ($existingEntretien) {
                return redirect()->back()->withErrors([
                    'error' => "There is already an entretien scheduled at " . $startTime->format('H:i') . " on " . $date
                ]);
            }

            // If no conflict, create the entretien
            /*  dd($startTime->format('H:i'), $res = $startTime->addMinutes(-$durationPerInterview)->format('H:i')); */
            $entretien = Entretien::create([
                'id_stagiaire' => $stagiaire->id,
                'date' => $date,
                'status' => 'en attente',
                'time' => $startTime->format('H:i'),
            ]);

            // Notify stagiaire that they have a new entretien
            $stagiaire->notify(new EntretienNotification($entretien));

            // Increment time for the next interview (AFTER creating the current interview)
            $startTime->addMinutes(-$durationPerInterview);
        }

        return redirect()->route('entretiens.index')->with('success', 'Entretiens created successfully.');
    }
}
