<?php

namespace App\Http\Middleware;

use App\Models\Demande_de_stage;
use App\Models\Entretien;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Usertype
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->type == "responsable admin" || $user->type == "directeur") {
            return $next($request);
        }

        if ($user->type == "stagiaire") {
            $demande = Demande_de_stage::where('id_stagiaire', $user->id)->first();
            $entretien = Entretien::where('id_stagiaire', $user->id)->first();
           /*  dd($user,$demande, $entretien); */
            $allowedRoutes = [
                'logout',
                'login',
                'welcome',
                'demande-de-stage.edit',
                'demande-de-stage.create',
                'demande-de-stage.store',
                'demande-de-stage.update',
            ];
            if ($demande && $demande->status == "approuvé" && $entretien->status == "approuvé") {
                $allowedRoutes = array_merge($allowedRoutes, [
                    'stagiaires.show',
                    'stagiaires.edit',
                    'stagiaires.update',
                    'rapports.create',
                    'rapports.index',
                    'rapports.edit',
                    'rapports.store',
                    'rapports.show',
                    'rapports.update',
                    'rapports.destroy',
                    'presentations.create',
                    'presentations.store',
                    'presentations.show',
                    'presentations.edit',
                    'presentations.index',
                ]);
            }
            if (in_array($request->route()->getName(), $allowedRoutes)) {
                /* dd($request->route()->getName()); */
                return $next($request);
            } else {
                /* dd($request->route()->getName()); */
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['error' => 'Access denied']);
            }
        }

        if ($user->type == "encadrant") {
            $allowedRoutes = [
                'encadrants.show',
                'encadrants.edit',
                'stagiaires.show',
                'encadrants.update',
                'encadrants.stagiaires',
                'encadrant.rapports',
                'rapports.index',
                'rapports.edit',
                'rapports.destroy',
                'rapports.update',
                'rapports.show',
                'rapports.list',
                'logout',
                'login',
                'presentations.index',
                'presentations.edit',
                'presentations.show',
                'presentations.store',
                'presentations.approuver',
                'presentations.refuser',
                'presentations.list'
            ];
            if ($user->permanent) {
                $allowedRoutes = array_merge($allowedRoutes, ['stagiaires.index']);
            }
            if (in_array($request->route()->getName(), $allowedRoutes)) {
                return $next($request);
            } else {
                /* dd($request->route()->getName()); */
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['error' => 'Access denied']);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withErrors(['error' => 'Access denied']);
    }
}
