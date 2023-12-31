<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $public_product_count = Product::where('is_public', true)->count();
        $order_count = Order::count();
        $total_income = Order::whereIn('status', ['Paid', 'Shipping', 'Complete'])->sum('total');
        $user_count = User::count();
        return view('admin.dashboard')->with([
            'public_product_count' => $public_product_count,
            'order_count' => $order_count,
            'total_income' => $total_income,
            'user_count' => $user_count,
        ]);
    }

    // public function orders(Request $request)
    // {
    //     $orders = Order::with(['seller', 'user', 'user.region'])
            
    //         ->when(request('search'), function ($query) {
    //             $query->where('id', 'like', '%' . request('search') . '%')
    //                 ->orWhereHas('seller', function ($query) {
    //                     $query->where('name', 'like', '%' . request('search') . '%');
    //                 })
    //                 ->orWhereHas('seller', function ($query) {
    //                     $query->where('name', 'like', '%' . request('search') . '%');
    //               });
    //         })
    //         ->latest()
    //         ->paginate(20)->withQueryString();
    //     return view('admin.orders')->with(['orders' => $orders]);
    // }

    public function orders(Request $request)
    {
        $orders = Order::with(['seller', 'user', 'user.region'])
            ->when(request('search'), function ($query) {
                $query->where('id', 'like', '%' . request('search') . '%')
                    ->orWhereHas('seller', function ($query) {
                        $query->where('name', 'like', '%' . request('search') . '%');
                    })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . request('search') . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    
        return view('admin.orders')->with('orders', $orders);
    }
    

    public function products(Request $request)
    {
        $products = Product::with('orders')
            ->withSum(['orders as sold' => function($query) {
                $query->whereIn('status', ['Complete']);
            }], 'product_orders.quantity')
            ->latest()
            ->when(request('search'), function($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhereHas('seller', function($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                });
            })
            ->paginate(20)
            ->withQueryString();
        return view('admin.products')->with(['products' => $products]);
    }

    public function users(Request $request)
    {
        $users = User::withCount(['orders', 'products', 'incomingOrders'])
            ->latest()
            ->when(request('search'), function ($query) {
                $query->where('id', 'like', '%' . request('search') . '%')
                    ->orWhere('name', 'like', '%' . request('search') . '%')
                    ->orWhereHas('region', function ($query) {
                        $query->where('name', 'like', '%' . request('search') . '%');
                    });
            })
            ->paginate(20)
            ->withQueryString();
        return view('admin.users')->with(['users' => $users]);
    }
}
