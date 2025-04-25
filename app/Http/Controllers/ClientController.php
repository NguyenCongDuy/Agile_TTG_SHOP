<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

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
    public function products(Request $request)
    {
        // Base query
        $query = Product::query();

        // Apply category filter
        if ($request->has('categories') && !in_array('all', $request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Apply price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply availability filter
        if ($request->has('availability') && $request->availability == 'in_stock') {
            $query->where('stock', '>', 0);
        }

        // Apply sorting
        switch ($request->sort_by) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // newest by default
        }

        // Get products with pagination
        $products = $query->paginate(12);

        // Get categories for filter
        $categories = Category::all();

        // Get featured products for sidebar
        $featuredProducts = Product::where('is_featured', true)->take(5)->get();

        return view('client.products', compact('products', 'categories', 'featuredProducts'));
    }

    /**
     * Display a single product
     */
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Check if product has variants property
        if (Schema::hasTable('product_variants')) {
            $hasVariants = DB::table('product_variants')
                ->where('product_id', $product->id)
                ->exists();
            $product->setAttribute('has_variants', $hasVariants);

            if ($hasVariants) {
                // Load variants if they exist
                $variants = DB::table('product_variants')
                    ->where('product_id', $product->id)
                    ->get();
                $product->setAttribute('variants', $variants);
            }
        } else {
            $product->setAttribute('has_variants', false);
        }

        // Set is_in_stock attribute
        $product->setAttribute('is_in_stock', $product->stock > 0);

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
    public function category($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Base query
        $query = Product::where('category_id', $category->id);

        // Apply price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply availability filter
        if ($request->has('availability') && $request->availability == 'in_stock') {
            $query->where('stock', '>', 0);
        }

        // Apply sorting
        switch ($request->sort_by) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // newest by default
        }

        // Get products with pagination
        $products = $query->paginate(12);

        return view('client.category', compact('category', 'products'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Base query
        $productQuery = Product::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        });

        // Apply price filter
        if ($request->has('min_price') && $request->min_price) {
            $productQuery->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $productQuery->where('price', '<=', $request->max_price);
        }

        // Apply availability filter
        if ($request->has('availability') && $request->availability == 'in_stock') {
            $productQuery->where('stock', '>', 0);
        }

        // Apply sorting
        switch ($request->sort_by) {
            case 'price_low':
                $productQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productQuery->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $productQuery->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $productQuery->orderBy('name', 'desc');
                break;
            default:
                $productQuery->orderBy('created_at', 'desc'); // newest by default
        }

        // Get products with pagination
        $products = $productQuery->paginate(12);

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
        try {
            $updates = $request->updates;
            $cart = session()->get('cart', []);

            foreach ($updates as $update) {
                $id = $update['id'];
                $quantity = (int)$update['quantity'];

                // Validate quantity
                if ($quantity < 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Số lượng sản phẩm phải lớn hơn 0'
                    ], 400);
                }

                // Check stock
                $product = Product::find($id);
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sản phẩm không tồn tại'
                    ], 404);
                }

                if ($product->stock < $quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Sản phẩm '{$product->name}' chỉ còn {$product->stock} trong kho"
                    ], 400);
                }

                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = $quantity;
                }
            }

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Giỏ hàng đã được cập nhật'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
            ], 500);
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
    public function orderDetail(Order $order)
    {
        $order->load(['orderDetails.product', 'payment']);

        // Check if the order belongs to the authenticated user
        if ($order->user_id != auth()->id()) {
            Log::warning("Unauthorized attempt to view order #{$order->id} by user #" . auth()->id());
            abort(403, 'Unauthorized action.');
        }

        // Log the status being passed to the view
        Log::info("Passing order #{$order->id} to client.order-detail view with status: '{$order->status}'.");

        return view('client.order-detail', compact('order'));
    }

    /**
     * Display order details (alias for orderDetail)
     */
    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);
        return $this->orderDetail($order);
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'noi_dung' => 'required|string|max:5000',
        ]);

        // Store the contact message in the database (without email)
        try {
            Contact::create([
                'name' => $validatedData['name'],
                'noi_dung' => $validatedData['noi_dung'],
            ]);
        } catch (\Exception $e) {
            // Optionally log the error
            // Log::error('Failed to save contact message: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.');
        }

        return redirect()->route('client.contact')->with('success', 'Tin nhắn của bạn đã được gửi thành công và lưu trữ!');
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
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card,paypal',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $subtotal = 0;
            foreach (session('cart') as $details) {
                $subtotal += $details['price'] * $details['quantity'];
            }

            // Add tax (10%)
            $tax = $subtotal * 0.1;
            $total_amount = $subtotal + $tax;

            // Combine address information
            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'shipping_address' => $fullAddress,
                'billing_address' => $fullAddress,
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

                // Update product stock (if implemented)
                // $product = Product::find($id);
                // $product->decrement('stock', $details['quantity']);
            }

            // Create payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => $request->payment_method == 'cod' ? 'pending' : 'unpaid',
                'amount' => $total_amount
            ]);

            // Clear cart
            session()->forget('cart');

            DB::commit();

            // Load order with payment for order success page
            $order->load('payment');

            // Redirect to order success page
            return view('client.order-success', compact('order'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng: ' . $e->getMessage());
        }
    }

    public function cancelOrder(Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền hủy đơn hàng này.');
        }

        // Check if order can be cancelled (only pending orders)
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Chỉ có thể hủy đơn hàng khi ở trạng thái "Chờ xử lý".');
        }

        try {
            // Only update the status to cancelled
            $order->status = Order::STATUS_CANCELLED;
            $order->save();

            // Optional: Restore product stock if needed (check if original code did this)
            // Consider if stock should be restored here or managed differently
            // foreach ($order->orderDetails as $detail) {
            //     if ($detail->product) {
            //         $detail->product->increment('stock', $detail->quantity);
            //     }
            // }

            return redirect()->route('client.orders.detail', $order)->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            // Log::error("Error cancelling order {$order->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi hủy đơn hàng: ' . $e->getMessage());
        }
    }

    public function confirmOrder(Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xác nhận đơn hàng này.');
        }

        // Check if order is in 'delivering' status
        if ($order->status !== Order::STATUS_DELIVERING) {
            return redirect()->back()->with('error', 'Chỉ có thể xác nhận đơn hàng khi ở trạng thái "Đang giao".');
        }

        try {
            DB::beginTransaction();

            // Update order status to 'completed'
            $order->status = Order::STATUS_COMPLETED;
            // Update payment status to 'paid'
            $order->payment_status = Order::PAYMENT_PAID;
            $order->save();

            // Update associated Payment record status as well
            if ($order->payment) {
                $order->payment->status = Order::PAYMENT_PAID;
                $order->payment->save();
            }

            DB::commit();

            return redirect()->route('client.orders.detail', $order)->with('success', 'Xác nhận nhận hàng thành công. Đơn hàng đã hoàn thành!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Error confirming order {$order->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xác nhận đơn hàng: ' . $e->getMessage());
        }
    }

    /**
     * Rate an order
     */
    public function rateOrder(Request $request, Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền đánh giá đơn hàng này'
            ], 403);
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể đánh giá đơn hàng đã hoàn thành'
            ], 400);
        }

        // Check if order has already been rated
        if ($order->rating) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng này đã được đánh giá trước đó'
            ], 400);
        }

        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Create rating
            $order->rating()->create([
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã đánh giá đơn hàng!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đánh giá đơn hàng'
            ], 500);
        }
    }
}
















