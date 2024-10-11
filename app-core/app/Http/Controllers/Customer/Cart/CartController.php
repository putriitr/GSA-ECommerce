<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        // Calculate the subtotal
        $subtotal = $cartItems->sum('total_price'); // Sum the total prices of all cart items
        $total = $subtotal; // Add any taxes or shipping costs if needed
        
        return view('customer.cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal,  // Total is the same as the subtotal since shipping is not included
        ]);
    }
    


    public function addToCart(Request $request)
{
    // Validate request data
    $request->validate([
        'product_id' => 'required|integer|exists:t_product,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Get the product
    $product = Product::findOrFail($productId);

    // Check if the stock is available
    if ($product->stock < $quantity) {
        return response()->json(['error' => 'Not enough stock available.'], 400);
    }

    // Determine which price to use (discount or regular price)
    $price = $product->discount_price ?? $product->price; // If discount_price exists, use it, otherwise use price

    // Calculate the total price for this item
    $totalPrice = $price * $quantity;

    // Check if the product is already in the cart
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

    if ($cartItem) {
        // Update the quantity and total price if product already exists in the cart
        $cartItem->quantity += $quantity;
        $cartItem->total_price += $totalPrice;
        $cartItem->save();
    } else {
        // Add new item to the cart
        Cart::create([
            'user_id' => Auth::id(), // or session ID for guest users
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice, // Store the calculated total price
        ]);
    }

    // Update product stock
    $product->stock -= $quantity;
    $product->save();

    return response()->json(['success' => 'Product added to cart.']);
}


    /**
     * Remove an item from the cart.
     */
    public function removeFromCart($id)
{
    try {
        // Find the cart item
        $cartItem = Cart::findOrFail($id);

        // Remove the item from the cart
        $cartItem->delete();

        // Return a JSON response
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    }
}

    public function updateCartQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $newQuantity = $request->input('quantity');

        // Calculate new total price for the product
        $productPrice = $cartItem->product->discount_price ?? $cartItem->product->price; // Handle discounted price if available
        $newProductTotal = $productPrice * $newQuantity;

        // Update cart item quantity and total price
        $cartItem->quantity = $newQuantity;
        $cartItem->total_price = $newProductTotal;
        $cartItem->save();

        // Calculate the new total cart value
        $cartTotal = Cart::where('user_id', Auth::id())->sum('total_price');

        return response()->json([
            'success' => true,
            'newProductTotal' => $newProductTotal,
            'newCartTotal' => $cartTotal,
        ]);
    }

    


}
