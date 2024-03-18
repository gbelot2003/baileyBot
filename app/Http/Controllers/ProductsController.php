<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class ProductsController extends Controller
{
    protected $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    public function index()
    {
        $products = $this->products->orderBy("id","desc")->paginate(10);
        return View("products.index", ["products"=> $products]);
    }

    public function show($id)
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(Product $product)
    {
        return View("products.edit", ["product"=> $product]);
    }

    public function update(Request $request, $id)
    {
        $products = Product::find($id);

        $products->update($request->validate([
            'name' => 'required',
            'tag' => Rule::in(['camas', 'sillas', 'miselaneos']),
            'description' => 'required',
            'price' => 'required',
            'image_url' => 'required'
        ]));

        return redirect(route('products.index'))->with('success','success');
    }

}
