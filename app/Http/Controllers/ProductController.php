<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $today = Carbon::now();

        $data = Product::whereDate('expired_date', '>=', $today)->get();
        return view('product.index', compact('data'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products',
            'product_name' => 'required',
            'expired_date' => 'required|date',
            'unit_price' => 'required|numeric|min:0',
            'size' => 'required',
            'category' => 'required'
        ]);

        $data = Product::create([
            'product_code' => $request->input('product_code'),
            'product_name' => $request->input('product_name'),
            'expired_date' => $request->input('expired_date'),
            'unit_price' => $request->input('unit_price'),
            'size' => $request->input('size'),
            'category' => $request->input('category')
        ]);

        Session::flash('success', 'Success to create new product.');
        
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $data = Product::find($id);
        return view('product.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'product_name' => 'required',
            'expired_date' => 'required|date',
            'unit_price' => 'required|numeric',
            'size' => 'required',
            'category' => 'required',
        ]);

        $data = Product::find($id);

        if (!$data) {
            Session::flash('fail', 'Product not found.');
            return redirect()->route('product.index');
        }

        $data->product_code = $request->input('product_code');
        $data->product_name = $request->input('product_name');
        $data->expired_date = $request->input('expired_date');
        $data->unit_price = $request->input('unit_price');
        $data->size = $request->input('size');
        $data->category = $request->input('category');

        $data->save();

        Session::flash('success', 'Success to update a product.');

        return redirect()->route('product.index');
    }

    public function destroy($id) 
    {
        $data = Product::find($id);

        if ($data) {
            $data->delete();
            Session::flash('success', 'Success to delete a product.');
            return redirect()->route('product.index');
        } else {
            Session::flash('fail', 'Fail to delete a product.');
            return redirect()->route('product.index');
        }
    }
}
