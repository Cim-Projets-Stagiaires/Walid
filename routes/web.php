<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DirecteurController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\StagiaireController;
use App\Models\Demande_de_stage;
use App\Models\Entretien;
use App\Models\Presentation;
use App\Models\Rapport;
use App\Models\User;
use App\Notifications\EntretienApprouved;
use App\Notifications\EntretienNotification;
use App\Notifications\EntretienRefused;
use App\Notifications\PresentationNonValider;
use App\Notifications\PresentationValider;
use App\Notifications\RapportNonValider;
use App\Notifications\RapportReminder;
use App\Notifications\rapportValide;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
})/* ->middleware('logoutOnBack') */;

Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth','logoutOnBack']);

// Auth Routes
Route::middleware(['guest','logoutOnBack','noCache'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/* Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth'); */
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Welcome Route
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth')->name('welcome');

// Home Route
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');


// Demande Routes
Route::resource('demande-de-stage', DemandeController::class)->middleware(['auth', 'usertype','logoutOnBack','noCache']);
Route::patch('demande-de-stage/{demande}/approve', [DemandeController::class, 'approve'])->name('demande-de-stage.approve');
Route::patch('demande-de-stage/{demande}/deny', [DemandeController::class, 'deny'])->name('demande-de-stage.deny');

// Stagiaire Routes
Route::get('/stagiaires/archive', [StagiaireController::class, 'archive'])->name('stagiaires.archive')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::resource('stagiaires', StagiaireController::class)->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::get('candidats', [StagiaireController::class, 'listCandidats'])->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache'])->name('stagiaires.candidats');

// Encadrant Routes
Route::get('/encadrants/archive', [EncadrantController::class, 'archive'])->name('encadrants.archive')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::resource('encadrants', EncadrantController::class)->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::get('encadrants/{id}/stagiaires', [EncadrantController::class, 'listStagiaires'])->name('encadrants.stagiaires');

// Admin Routes
Route::resource('admins', AdminController::class)->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);

// Directeur Routes
Route::resource('directeur', DirecteurController::class)->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);

// Rapport Routes
Route::get('rapports/list/{id}', [RapportController::class, 'list'])->name('rapports.list')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::resource('rapports', RapportController::class)->middleware(['auth', 'usertype']);
Route::get('encadrant/{id}/rapports', [RapportController::class, 'listRapport'])->name('encadrant.rapports')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::get('rapports/download/{rapport}', [RapportController::class, 'download'])->name('rapports.download');
Route::patch('encadrant/{id}/rapports/valide', [RapportController::class, 'rapportValide'])->name('rapports.rapportValide');
Route::patch('/rapports/{id}/non-valide', [RapportController::class, 'rapportNonValide'])->name('rapports.rapportNonValide');


// this is a test
Route::get('/test-rapport-reminder', function() {
    // Find the demande for the stagiaire with id = 1
    $demande = Demande_de_stage::with('stagiaire')
        ->where('status', 'approuvé')
        ->where('id_stagiaire', 1)
        ->first();

    if ($demande) {
        // Send the notification to the stagiaire
        $demande->stagiaire->notify(new RapportReminder($demande));
        return 'Rapport reminder sent to stagiaire with id = 1';
    } else {
        return 'No approved demande found for stagiaire with id = 1';
    }
});

//Entretien Routes
//create entretien automatically
Route::get('/entretiens/automateForm', [EntretienController::class, 'automateForm'])->name('entretiens.automateForm');
Route::post('/entretiens/automate', [EntretienController::class, 'automate'])->name('entretiens.automate');
Route::resource('entretiens', EntretienController::class);
// Additional Routes for Status Changes
Route::patch('/entretiens/{id}/approuver', [EntretienController::class, 'approuver'])->name('entretiens.approuver');
Route::patch('/entretiens/{id}/refuser', [EntretienController::class, 'refuser'])->name('entretiens.refuser');


// test entretien notification
Route::get('/test-entretien-notification/{stagiaire}', function ($stagiaireId) {
    // Find the stagiaire (user) by ID
    $stagiaire = User::where('type', 'stagiaire')->findOrFail($stagiaireId);
    // Create a dummy entretien for testing purposes
    $entretien = new Entretien([
        'id_stagiaire' => $stagiaire->id,
        'date' => now()->addDays(2)->format('Y-m-d'),  // Set the date 2 days from now
        'time' => now()->addHours(2)->format('H:i'),    // Set the time 2 hours from now
    ]);

    // Send notification to the stagiaire
    $stagiaire->notify(new EntretienNotification($entretien));

    // Return a response for testing
    return "Notification sent to " . $stagiaire->nom . " " . $stagiaire->prenom;
});

Route::get('/test-entretien-approuve/{stagiaire}', function ($stagiaireId) {
    // Find the stagiaire (user) by ID
    $stagiaire = User::where('type', 'stagiaire')->findOrFail($stagiaireId);

    // Create a dummy entretien for testing purposes
    $entretien = new Entretien([
        'id_stagiaire' => $stagiaire->id,
        'date' => now()->addDays(2)->format('Y-m-d'),  // Set the date 2 days from now
        'time' => now()->addHours(3)->format('H:i'),    // Set the time 3 hours from now
    ]);

    // Send the approved notification to the stagiaire
    $stagiaire->notify(new EntretienApprouved($entretien));

    // Return a response for testing
    return "Entretien approuvé notification sent to " . $stagiaire->nom . " " . $stagiaire->prenom;
});

Route::get('/test-entretien-refuse/{stagiaire}', function ($stagiaireId) {
    // Find the stagiaire (user) by ID
    $stagiaire = User::where('type', 'stagiaire')->findOrFail($stagiaireId);

    // Create a dummy entretien for testing purposes
    $entretien = new Entretien([
        'id_stagiaire' => $stagiaire->id,
        'date' => now()->addDays(2)->format('Y-m-d'),  // Set the date 2 days from now
        'time' => now()->addHours(3)->format('H:i'),    // Set the time 3 hours from now
    ]);

    // Send the refused notification to the stagiaire
    $stagiaire->notify(new EntretienRefused($entretien));

    // Return a response for testing
    return "Entretien refusé notification sent to " . $stagiaire->nom . " " . $stagiaire->prenom;
});

Route::resource('presentations', PresentationController::class)->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);

// Additional routes for approving/refusing presentations
Route::patch('/presentations/{id}/approuver', [PresentationController::class, 'approuver'])->name('presentations.approuver')->middleware(['auth', 'usertype', 'logoutOnBack', 'noCache']);
Route::patch('/presentations/{id}/refuser', [PresentationController::class, 'refuser'])->name('presentations.refuser')->middleware('[auth, usertype, logoutOnBack, noCache]');

// Test route for sending rapport validated notification
Route::get('/test-rapport-validated/{id}', function ($id) {
    $rapport = Rapport::find($id);
    if ($rapport) {
        $rapport->stagiaire->notify(new rapportValide($rapport));
        return "Rapport Validated Notification sent to " . $rapport->stagiaire->nom . " " . $rapport->stagiaire->prenom;
    }
    return "No stagiaire found.";
});

// Test route for sending rapport not validated notification
Route::get('/test-rapport-not-validated/{id}', function ($id) {
    $rapport = Rapport::find($id);
    if ($rapport) {
        $rapport->stagiaire->notify(new RapportNonValider($rapport));
        return "Rapport Not Validated Notification sent to " . $rapport->stagiaire->nom . " " . $rapport->stagiaire->prenom;
    }
    return "No stagiaire found.";
});

// Test route for sending presentation validated notification
Route::get('/test-presentation-validated/{id}', function ($id) {
    $presentation = Presentation::findOrFail($id);
    if ($presentation) {
        $presentation->stagiaire->notify(new PresentationValider($presentation));
        return "Presentation Validated Notification sent to " . $presentation->stagiaire->nom . " " . $presentation->stagiaire->prenom;
    }

    return "No presentation found.";
});

// Test route for sending presentation not validated notification
Route::get('/test-presentation-not-validated/{id}', function ($id) {
    $presentation = Presentation::findOrFail($id);
    if ($presentation) {
        $presentation->stagiaire->notify(new PresentationNonValider($presentation));
        return "Presentation Not Validated Notification sent to " . $presentation->stagiaire->nom . " " . $presentation->stagiaire->prenom;
    }
    return "No presentation found.";
});