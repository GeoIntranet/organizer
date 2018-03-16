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
        $semaine = new Carbon($dt);
        $semaine = $semaine->weekOfYear;

        Delais::create(['id_cmd' => $bl->id_cmd, 'semaine_envoie' => $semaine, "date_envoie" => $dt,'id_client' => $bl->id_clientlivr]);

        return ['ok'];
    }
}
