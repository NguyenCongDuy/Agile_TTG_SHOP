<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
        $categories  = Category::where('is_featured', true)->take(3)->get();
        $products = Products::where('is_featured', true)->take(8)->get();
        
        return view('client.home', compact('categories', 'products'));
    }

    /**
     * Display all products
     */
    public function products()
    {
        $products = Products::paginate(12);
        return view('client.products', compact('products'));
    }

    /**
     * Display a single product
     */
    public function product($slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        $relatedProducts = Products::where('category_id', $product->category_id)
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
        $products = Products::where('category_id', $category->id)->paginate(12);
        
        return view('client.category', compact('category', 'products'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Products::where('name', 'like', "%{$query}%")
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
        $product = Products::findOrFail($request->product_id);
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
        $id = $request->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            // Calculate new total
            $total = 0;
            foreach ($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
                'cart_count' => count($cart),
                'total' => number_format($total) . 'đ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
        ], 404);
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
    public function orders(Request $request)
    {
        $query = auth()->user()->orders()->with('payment');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('status', $request->payment_status);
            });
        }

        // Sort
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('total_amount', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('total_amount', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);

        return view('client.orders', compact('orders'));
    }

    /**
     * Display order details
     */
    public function orderDetails($id)
    {
        $order = Order::with(['orderDetails.product', 'payment'])->findOrFail($id);
        
        // Check if the order belongs to the authenticated user
        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        return view('client.order-detail', compact('order'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('client.contact');
    }

    /**
     * Handle contact form submission
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Here you would typically:
        // 1. Save the contact message to the database
        // 2. Send an email notification
        // 3. Or integrate with a CRM system

        // For now, we'll just return a success message
        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }

    /**
     * Display change password form
     */
    public function showChangePasswordForm()
    {
        return view('client.change-password');
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công');
    }

    public function checkout()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $total = 0;
        foreach (session('cart') as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('client.checkout', compact('total'));
    }

    public function storeOrder(Request $request)
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Calculate total amount
        $total_amount = 0;
        foreach (session('cart') as $details) {
            $total_amount += $details['price'] * $details['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'shipping_address' => $request->address,
            'billing_address' => $request->address,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'pending',
            'total_amount' => $total_amount
        ]);

        // Create order details
        foreach (session('cart') as $id => $details) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // Create payment
        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => $request->payment_method == 'cod' ? 'pending' : 'unpaid',
            'amount' => $total_amount
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('client.orders')->with('success', 'Đặt hàng thành công!');
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        return view('client.order-detail', compact('order'));
    }

    public function cancelOrder(Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy đơn hàng này'
            ], 403);
        }

        // Check if order can be cancelled (only pending orders)
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể hủy đơn hàng đang chờ xử lý'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng'
            ], 500);
        }
    }
} 