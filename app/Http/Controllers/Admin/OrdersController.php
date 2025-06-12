<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // your Order model
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of orders, optionally filtered by status.
     */
    public function index(Request $request)
    {
        // Determine filter from query parameter
        $status = $request->query('status'); // 'unpaid', 'done', 'cancelled', or null for all

        // Base query
        $query = Order::query();

        // Filter by status if provided
        if ($status === 'unpaid') {
            $query->where('status', 'Unpaid');
        } elseif ($status === 'done') {
            // if your model uses 'Paid' as done
            $query->where('status', 'Paid');
        } elseif ($status === 'cancelled') {
            $query->where('status', 'Cancelled');
        }

        // Fetch orders, you might want pagination
        $orders = $query->orderBy('created_at', 'desc')->get();

        // Counts for badges/tabs
        $counts = [
            'all'       => Order::count(),
            'unpaid'    => Order::where('status', 'Unpaid')->count(),
            'done'      => Order::where('status', 'Paid')->count(),
            'cancelled' => Order::where('status', 'Cancelled')->count(),
        ];

        return view('admin.orders', [
            'orders' => $orders,
            'counts' => $counts,
            'currentStatus' => $status, 
        ]);
    }

    /**
     * Cancel the given order.
     */
    public function cancel(Request $request, Order $order)
    {
        // Logic to cancel the order.
        // For example, only if it's not already paid/cancelled:
        if ($order->status !== 'Cancelled' && $order->status !== 'Paid') {
            $order->status = 'Cancelled';
            $order->save();
            Session::flash('success', 'Order cancelled successfully.');
        } else {
            Session::flash('error', 'Order cannot be cancelled.');
        }
        // Redirect back to the orders list, preserving filter if any
        return redirect()->route('admin.orders.index', [
            'status' => $request->query('status')
        ]);
    }
}
