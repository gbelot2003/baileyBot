<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

    public function edit(Product $products)
    {

    }

    public function update(Request $request, Product $products)
    {

    }

}
