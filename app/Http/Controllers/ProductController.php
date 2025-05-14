<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'category' => $validated['category'],
            'image_url' => $imagePath ? '/storage/' . $imagePath : null,
        ]);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'category' => $validated['category'],
        ];

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    // Shop page with category filtering
    public function shop(Request $request)
    {
        $query = Product::query();
        $categories = Product::select('category')->distinct()->pluck('category');
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%");
            });
        }
        $products = $query->paginate(12);

        // Best-sellers per category for the current month
        $month = now()->format('Y-m');
        $bestSellers = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.category', 'products.id', 'products.name', 'products.image_url', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->where('orders.order_date', 'like', "$month%")
            ->groupBy('products.category', 'products.id', 'products.name', 'products.image_url')
            ->orderBy('products.category')
            ->orderByDesc('total_sold')
            ->get()
            ->groupBy('category')
            ->map(function($group) {
                return $group->first(); // Top seller per category
            });

        return view('shop.index', compact('products', 'categories', 'bestSellers'));
    }

    // Quick view product details (AJAX)
    public function show(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => $product->category,
            'image_url' => $product->image_url ? $product->image_url : asset('placeholder.svg'),
        ]);
    }

    public function submitReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        $user = Auth::user();
        // Only allow review if user purchased the product
        $hasPurchased = \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user->id)
            ->where('order_items.product_id', $product->id)
            ->exists();
        if (!$hasPurchased) {
            return response()->json(['error' => 'You can only review products you have purchased.'], 403);
        }
        $review = Review::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'review_date' => now(),
            ]
        );
        return response()->json(['success' => true, 'review' => $review]);
    }

    public function getReviews(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
            ->with('user:id,first_name,last_name')
            ->orderByDesc('review_date')
            ->get();
        return response()->json(['reviews' => $reviews]);
    }
}
