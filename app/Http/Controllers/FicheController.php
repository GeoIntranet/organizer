<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Delais;
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
            ->with('delais','ligne','clientDelivered','clientFacture','achat','itCmd')
            ->get();


        //die();
        //dd($fiches[0]->clientDelivered->nsoc);
        $expiresAt = now()->addMinutes(10);
        return  $fiches->chunk(intval(count($fiches))/2);

        //Cache::put('fichesEnCours', ($fiches), $expiresAt);
        //return view('home');
    }
}
