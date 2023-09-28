<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = Carbon::now();
        
        $data = Product::whereDate('expired_date', '>=', $today)->get();
        return view('transaction.index', compact('data'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'order_date' => 'required',
            'order_number' => 'required|unique:transactions',
            'customer_name' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $product = Product::find($request->product_id);

        $data = Transaction::create([
            'order_date' => $request->input('order_date'),
            'order_number' => $request->input('order_number'),
            'customer_name' => $request->input('customer_name'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total_price' => $product->unit_price * $request->input('quantity')
        ]);

        Session::flash('success', 'Success to create new transaction.');
        
        return redirect()->route('home');
    }
}
