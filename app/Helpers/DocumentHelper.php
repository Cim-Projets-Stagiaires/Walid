<?php

namespace App\Helpers;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class DocumentHelper
{
    public static function generateCharteDoc($demande)
    {
        $templatePath = storage_path('app\\public\\templates\\Charte_du_stagiaire_CIM.docx');
        $outputPath = storage_path('app\\public\\generated_chartes\\');
        
        // Create output directory if it does not exist
        if (!Storage::exists('public\\generated_chartes')) {
            Storage::makeDirectory('public\\generated_chartes');
        }
        
        $template = new TemplateProcessor($templatePath);
        $year = now()->year;
        $stagiaireId = str_pad($demande->stagiaire->id, 4, '0', STR_PAD_LEFT);

        // Map pole to the appropriate abbreviation
        $poleMap = [
            'Services transverses' => 'ST',
            'Incubation' => 'INC',
            'Valorisation' => 'VAL',
        ];

        $poleAbbreviation = $poleMap[$demande->pole] ?? 'UNK';
        $referenceCode = "{$year}\CS\{$poleAbbreviation}\{$stagiaireId}";
        /* dd($demande); */


        // Replace placeholder in the document
        $template->setValue('reference_code', $referenceCode);
        $outputFile = "{$outputPath}{$referenceCode}.docx";
        dd($outputFile);
        $template->saveAs($outputFile);

        return $outputFile;
    }
}
