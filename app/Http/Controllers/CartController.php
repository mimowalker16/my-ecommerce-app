<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'error' => 'Not authenticated.'], 401);
            }
            return Redirect::route('login');
        }

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += (int)$request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => (int)$request->quantity,
            ]);
        }

        if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return Redirect::route('login');
        }

        $cartItems = Cart::with('product')
                         ->where('user_id', $user->id)
                         ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity; 
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->firstOrFail();

        $cartItem->quantity = (int)$request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Product $product)
    {
        $user = Auth::user();

        Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return Redirect::route('login');
        }

        $cartItems = Cart::with('product')
                         ->where('user_id', $user->id)
                         ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Nothing to checkout.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = null;
        DB::transaction(function () use ($user, $cartItems, &$order) {
            $totalAmount = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $order = $user->orders()->create([
                'order_date' => now(),
                'total_amount' => $totalAmount,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        // Defensive: reload order with items and products for the email, and check for null
        if ($order) {
            $order = $user->orders()->with('items.product')->find($order->id);
            if ($order && $order->items) {
                Mail::to($user->email)->send(new OrderConfirmationMail($order, $user));
            }
        }

        return redirect()->route('orders.history')->with('success', 'Order placed successfully!');
    }

    public function orderHistory()
    {
        $user = Auth::user();
        $orders = \DB::table('orders')
            ->where('user_id', $user->id)
            ->orderByDesc('order_date')
            ->get();
        $orderItems = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('order_items.*', 'products.name', 'products.image_url')
            ->get();
        return view('orders.history', compact('orders', 'orderItems'));
    }
}
