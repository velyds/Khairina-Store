<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductGalleryRequest;
use App\Models\Category;
use App\Models\ProductGallery;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with(['category'])->get();

            foreach ($query as $q) {
                $q['price'] = 'Rp. ' . number_format($q['price'], 2, ',', '.');
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                        type="button"
                                        data-toggle="dropdown">
                                        Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                                Sunting
                                            </a>
                                            <form action="' . route('product.destroy', $item->id) . '"  method="POST">
                                                ' . method_field('delete') . csrf_field() . '
                                                <button type="submit" class="dropdown-item text-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div> 
                                    </div>
                                </div>
                            ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('pages.admin.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $categories = Category::all();

        if (request()->ajax()) {
            $query = ProductGallery::with('product')->where('products_id', $id);

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                        type="button"
                                        data-toggle="dropdown">
                                        Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="' . route('destroyVariant', $item->id) . '"  method="POST">
                                                ' . method_field('delete') . csrf_field() . '
                                                <button type="submit" class="dropdown-item text-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div> 
                                    </div>
                                </div>
                            ';
                })
                ->editColumn('photos', function ($item) {
                    return $item->photos ? '<img src="' . Storage::url($item->photos) . '" style="max-height: 80px;"/>' : '';
                })
                ->rawColumns(['action', 'photos'])
                ->make();
        }

        return view('pages.admin.product.edit', [
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }

    // Variants Product
    public function createVariant($id)
    {
        $product = Product::find($id);

        return view('pages.admin.product.createVariant', [
            'product' => $product
        ]);
    }

    public function storeVariant(ProductGalleryRequest $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductGallery::create($data);

        return redirect()->route('product.edit', $data['products_id']);
    }

    public function destroyVariant($id)
    {
        $item = ProductGallery::findOrFail($id);
        $productId = $item['products_id'];
        $item->delete();

        return redirect()->route('product.edit', $productId);
    }
}
