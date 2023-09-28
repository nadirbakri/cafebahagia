<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $topProducts = Transaction::select('product_id', DB::raw('COUNT(*) as total_transactions'))
            ->groupBy('product_id')
            ->orderByDesc('total_transactions')
            ->limit(5)
            ->get();

        $labels = $topProducts->pluck('product_id')->map(function ($productId) {
            return Product::find($productId)->product_name;
        });
        $data = $topProducts->pluck('total_transactions');

        return view('home', compact('labels', 'data'));
    }
}
