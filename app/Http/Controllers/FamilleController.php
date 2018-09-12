<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FamilleController extends Controller
{
    /**
     * @return $this
     */
    public function index()
    {
        $familles = Categories::all();

        $commandes = Cache::remember('cmd_works_', 10, function () {
            return  $cmd = Commande::enCours()->with('clientDelivered','delais')->limit(0)->take(16)->get();
        });

        return view('settings.famille')
            ->with('familles',$familles)
            ->with('commandes',$commandes)
            ;
    }

    /**
     * update la valeur d'une colonne d'une famille spécific
     */
    public function update()
    {
        $familles = Categories::where('famille',request('famille'))->update([
            request('column') =>  request('value')
        ]);

        return[request('famille').' - '.request('column').' a bien été mis a jour'];
    }

}
