<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with(['galleries'])->paginate(50);

        return view('pages.product',[
            'products' =>$products
        ]);
    } 

    public function redirect(Request $request)
    {
        return redirect('/search/' . $request->cari);
    }

    public function query($slug)
    {
        $categories = Category::all();
        $products = Product::with(['galleries'])->where('name','LIKE','%'.$slug.'%')->paginate(50);

        return view('pages.product',[
            'categories' =>$categories,
            'products' =>$products
        ]);
    }
}
