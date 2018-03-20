<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Delais;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DelaisController extends Controller
{
    public function add($bl , $dt)
    {
        $bl = Commande::where('id_cmd',$bl)->first();

        if( $bl == null)
            return [
                'state' => 0,
                'msg' => 'Le n° de bl est inconnu'
            ];

        $semaine = new Carbon($dt);
        $semaine = $semaine->weekOfYear;

        $isCreatedYet = Delais::where('id_cmd',$bl->id_cmd)->first();

        if(  $isCreatedYet !== null )
            return [
                'state' => 0,
                'msg' => 'Le delais est deja ajouté'
            ];

        $test = Delais::FirstOrCreate([
            'id_cmd' => $bl->id_cmd,
            'semaine_envoie' => $semaine,
            "date_envoie" => $dt,
            'id_client' => $bl->id_clientlivr
        ]);
        return [
            'state' => 1,
            'msg' => 'Le delais a bien été ajouté'
        ];
    }
}
