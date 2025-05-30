<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variations;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Giỏ hàng';
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)
            ->with('product', 'variation')
            ->get();

        $total = $carts->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart', compact('carts', 'title', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variations_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $productId = $request->input('product_id');
        $variationId = $request->input('product_variations_id');
        $quantity = $request->input('quantity');

        $product = Product::findOrFail($productId);
        $variation = $variationId ? Variations::find($variationId) : null;

        $price = $variation ? $variation->price : $product->price;
        $stock = $variation ? $variation->stock : $product->stock;

        if ($quantity > $stock) {
            return redirect()->back()->with('error', 'Số lượng yêu cầu vượt quá số lượng tồn kho!');
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('product_variations_id', $variationId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            if ($cartItem->quantity > $stock) {
                return redirect()->back()->with('error', 'Tổng số lượng trong giỏ hàng vượt quá số lượng tồn kho!');
            }
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'product_variations_id' => $variationId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Update the quantity of a cart item (for + and - buttons).
     */
    public function update(Request $request, $id, $change)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $newQuantity = $cart->quantity + $change;

        if ($newQuantity < 1) {
            return redirect()->route('cart.index')->with('error', 'Số lượng không thể nhỏ hơn 1!');
        }

        $stock = $cart->variation ? $cart->variation->stock : $cart->product->stock;
        if ($newQuantity > $stock) {
            return redirect()->route('cart.index')->with('error', 'Số lượng vượt quá tồn kho! Số lượng tối đa là ' . $stock . '.');
        }

        $cart->quantity = $newQuantity;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    /**
     * Update the quantity of a cart item (for direct input).
     */
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $newQuantity = $request->input('quantity');

        $stock = $cart->variation ? $cart->variation->stock : $cart->product->stock;
        if ($newQuantity > $stock) {
            return redirect()->route('cart.index')->with('error', 'Số lượng vượt quá tồn kho! Số lượng tối đa là ' . $stock . '.');
        }

        $cart->quantity = $newQuantity;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    /**
     * Delete multiple selected items from the cart.
     */
    public function deleteSelected(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để xóa!');
        }

        Cart::whereIn('id', $selectedItems)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa các sản phẩm được chọn!');
    }

    /**
     * Handle checkout (placeholder for now).
     */
    public function checkout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
        }

        return redirect()->route('cart.index')->with('success', 'Chức năng thanh toán đang được phát triển!');
    }
}
