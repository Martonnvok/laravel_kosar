<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function index(){
        return response()->json(Basket::all());
    }

    public function show($user_id, $item_id){
        $basket = Basket::where('user_id', $user_id)
        ->where('item_id',"=", $item_id)
        ->get();
        return $basket[0];
    }

    public function store(Request $request){
        $item = new Basket();
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;
                
        $item->save();
    }

    public function update(Request $request, $user_id, $item_id){
        $item = $this->show($user_id, $item_id);
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function destroy($user_id, $item_id){
        $this->show($user_id, $item_id)->delete();
    }

    //1.feladat A bejelentkezett felhasználó kosarában lévő termékek összes adatát jelenítsd meg (fg+with)!
    public function userBasket(){
        $userId=Auth::user();
        return Basket::with('felhasznalo', 'productok')->where('user_id','=', $userId->id)->get();
    }

    //2. feladat jelenítsd meg az adott felhasználó (id a paraméter) kosara alapján azon termékeket, amelyek bizonyos terméktípushoz tartoznak (a típusnév is paraméter legyen); innentől DB:table...
    public function bizonyosTermektipus($user_id, $type_id){
        $baskets = DB::table('baskets')
            ->join('products', 'baskets.item_id', '=', 'products.item_id')
            ->where('baskets.user_id', $user_id)
            ->where('products.type_id', $type_id)
            ->select('baskets.user_id', 'products.*')
            ->get();

        return response()->json($baskets);
    }

    //3.feladat Töröld az összes 2 napnál régebbi kosár tartalmakat!
    public function basketTodayDelete(){
        
        $basketsToday = DB::table('baskets')
            ->whereDate('baskets.date', now()->subDays(2))
            ->delete();
    }
}
