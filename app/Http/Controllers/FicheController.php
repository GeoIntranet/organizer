<?php

namespace App\Http\Controllers;

use App\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FicheController extends Controller
{
    public function all()
    {
        //if(Cache::has('fichesEnCours') )
        //{
        //    return (Cache::get('fichesEnCours'));
        //}


        $fiches  = Commande::encours()
            ->with('ligne','clientDelivered','clientFacture','achat')
            ->get();
        foreach ($fiches as $index => $fich) {
            var_dump($fich->clientDelivered->nsoc);
        }
        //die();
        //dd($fiches[0]->clientDelivered->nsoc);
        return  $fiches;
        $expiresAt = now()->addMinutes(10);

        //Cache::put('fichesEnCours', ($fiches), $expiresAt);
        //return view('home');
    }
}
