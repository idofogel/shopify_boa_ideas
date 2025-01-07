<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\LastSyncDate;

use Illuminate\View\View;
//this controller handles the product's details page. both functions here provide details of product so putting them together doesn't break the sacred single responsibility directive
class ProductDetailsController extends Controller
{
    //gets products dynamically
    public function fetchMoreproducts($offset)
    {
        $products = Product::skip($offset)->get(); // Fetch the next batch
        foreach ($products as $prd) {
            $prd->num_of_collections = $prd->collections()->count();
            $products[] = $prd;
        }
        return response()->json($products);
    }
    
    public function products(): View
    {
        $number_of_drawed = 50;
        $products = [];
        //I took the path of greedy collection in order to save unnecessary queries. maybe batches would be a better path
        foreach (Product::limit($number_of_drawed)->get() as $prd) {
            $prd->num_of_collections = $prd->collections()->count();
            $products[] = $prd;
        }
        return view('greet', ['products' => $products,
        'update_date' => LastSyncDate::first(),'num_of_objs' => Product::count(),'batch_size' => $number_of_drawed]);
    }
    public function show(int $id): View
    {
        $product = Product::find($id);
        return view('greet', ['product' => $product,'update_date' => LastSyncDate::first()]);
    }
}
