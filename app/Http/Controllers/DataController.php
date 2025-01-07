<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Collection;
use App\Models\LastSyncDate;
class DataController extends Controller
{
    //both of these function draw collections from the DB, there for putting them together doesn't break the single responsibility rule
    public function fetchMoreCollections($offset)
    {
        $collections = Collection::skip($offset)->get(); // Fetch the next batch
        foreach ($collections as $cls) {
            $cls->num_of_products = $cls->products()->count();
            $collections[] = $cls;
        }
        return response()->json($collections);
    }
    public function show(): View
    {
        $number_of_drawed = 50;
        // $coll = Collection::all();//I replaced the "all" with limit in order to prevent slow loading of page
        $coll = Collection::limit($number_of_drawed)->get();
        return view('greet', ['collect' => $coll,'update_date' => LastSyncDate::first(),'num_of_objs' => Collection::count(),'limit' => 50,'batch_size' => $number_of_drawed]);
    }
}
