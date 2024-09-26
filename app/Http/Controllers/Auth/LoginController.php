<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Demande_de_stage;
use App\Models\Entretien;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            /* $request->session()->regenerate(); */
            if ($user->type == 'stagiaire') {
                $demandeExist = Demande_de_stage::where('id_stagiaire', $user->id)->exists();
                $demandeStatus = Demande_de_stage::where('id_stagiaire', $user->id)->first();
                $entretien = Entretien::where('id_stagiaire', $user->id)->first();
                if ($demandeExist) {
                    if ($demandeStatus->status == "postulé" || ($demandeStatus->status == "approuvé" && ($entretien->status == "en attente" || $entretien->status == "refusé"))) {
                        return redirect('/welcome')->with('status', 'Your application is being reviewed.');
                    } elseif ($demandeStatus->status == "approuvé" && $entretien->status == "approuvé") {
                        return redirect()->route('stagiaires.show', [$user->id]);
                    }
                } else {
                    /* dd($user); */
                    return redirect()->route('demande-de-stage.create');
                    /* return view('demandes_de_stage.create'); */
                }
            } elseif ($user->type == 'encadrant') {
                return redirect()->route('encadrants.show', [$user->id]);
            } else {
                return redirect('/home')->with('status', 'Welcome back!');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
