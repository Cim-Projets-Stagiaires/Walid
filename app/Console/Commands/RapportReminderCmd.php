<?php

namespace App\Console\Commands;
use App\Models\Demande_de_stage;
use App\Models\Rapport;
use App\Notifications\RapportReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RapportReminderCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:stagiaire-upload';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifier les stagiaires à deposer un rapport lorsque la moitié de leur periode de stage est depassé';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demandes = Demande_de_stage::with('stagiaire')->where('status', 'approuvé')->get();

        foreach ($demandes as $demande) {
            $debut = Carbon::parse($demande->date_de_debut);
            $fin = Carbon::parse($demande->date_de_fin);
            $halfwayDate = $debut->copy()->addDays($fin->diffInDays($debut) / 2);

            $stagiaireRapports = Rapport::where('id_stagiaire', $demande->stagiaire->id)->exists();

            if (Carbon::now()->greaterThanOrEqualTo($halfwayDate) && !$stagiaireRapports) {
                // Send email notification to the stagiaire
                $demande->stagiaire->notify(new RapportReminder($demande));
            }
        }
    }
}
