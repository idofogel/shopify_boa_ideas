<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\LastSyncDate;
use Illuminate\View\View;

//this controller handles product in relation to a collection. it is seperate from the other ProductController that handles singular product without relation to its collection parent
class ProdController extends Controller
{
    public function show(int $id): View
    {
        $coll = Collection::find($id);
        
        $prods = $coll->products();
        // return view('coll', [
        //     'collection' => $coll,
        //     'prods' => compact('prods')
        // ]);
        return view('greet', [
            'collection' => $coll,
            'prods' => compact('prods'),
            'update_date' => LastSyncDate::first()
        ]);
        
    }
}
