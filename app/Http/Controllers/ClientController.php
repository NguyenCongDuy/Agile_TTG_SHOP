<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
        $categories  = Category::where('is_featured', true)->take(3)->get();
        $products = Product::where('is_featured', true)->take(8)->get();
        
        return view('client.home', compact('categories', 'products'));
    }

    /**
     * Display all products
     */
    public function products()
    {
        $products = Product::paginate(12);
        return view('client.products', compact('products'));
    }

    /**
     * Display a single product
     */
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('client.product', compact('product', 'relatedProducts'));
    }

    /**
     * Display all categories
     */
    public function categories()
    {
        $categories = Category::all();
        return view('client.categories', compact('categories'));
    }

    /**
     * Display products in a category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(12);
        
        return view('client.category', compact('category', 'products'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12);
            
        return view('client.search', compact('products', 'query'));
    }

    /**
     * Display shopping cart
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('client.cart', compact('cart'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart
     */
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully');
        }
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Product removed successfully');
        }
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('client.profile', compact('user'));
    }

    /**
     * Display user orders
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('client.orders', compact('orders'));
    }

    /**
     * Display order details
     */
    public function orderDetails($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('client.order-details', compact('order'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('client.contact');
    }

    /**
     * Send contact message
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // Here you would typically send an email or save the message to the database
        // For now, we'll just redirect back with a success message
        
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
} 