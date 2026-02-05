<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::withCount('items')
            ->where('created_by', $user->id)->orderBy('created_at', 'desc')->paginate(5);

        return view('order.index', compact('orders'));
    }

    public function view(Order $order)
    {

        $condition = $order->created_by == Auth::user()->id;
        if (! $condition) {
            // return abort(404);
            return response("You don't have permission to view this order", 403);
        }

        return view('order.view', compact('order'));
    }
}
