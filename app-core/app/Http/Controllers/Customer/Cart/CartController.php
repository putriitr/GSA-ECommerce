<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Http\Controllers\Controller;
use App\Models\BigSale;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    // Validate input
    $request->validate([
        'product_id' => 'required|integer|exists:t_product,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Get product data
    $product = Product::findOrFail($productId);

    // Debugging: Check if we are getting the correct product ID
    Log::info("Adding Product to Cart", ['product_id' => $productId, 'quantity' => $quantity]);

    // Check if the product is out of stock
    if ($product->stock <= 0) {
        return response()->json(['error' => 'Product is out of stock.'], 400);
    }

    // Check if the requested quantity is available in stock
    if ($product->stock < $quantity) {
        return response()->json(['error' => 'Not enough stock available.'], 400);
    }

    $bigSalePrice = $product->price; // Default to the regular price

    // Check if the product is in an active Big Sale
    $activeBigSale = BigSale::where('status', true)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->whereHas('products', function ($query) use ($product) {
            $query->where('t_product.id', $product->id);
        })
        ->first();

    // Debugging: Check if Big Sale is applied
    if ($activeBigSale) {
        Log::info("Product in Big Sale", ['product_id' => $productId, 'big_sale_id' => $activeBigSale->id]);

        // Apply Big Sale discount
        if ($activeBigSale->discount_amount) {
            $bigSalePrice = $product->price - $activeBigSale->discount_amount;
        } elseif ($activeBigSale->discount_percentage) {
            $bigSalePrice = $product->price - ($activeBigSale->discount_percentage / 100) * $product->price;
        }
    } elseif ($product->discount_price) {
        // If no Big Sale, apply the product-specific discount price
        $bigSalePrice = $product->discount_price;
    }

    // Calculate total price based on quantity
    $totalPrice = $bigSalePrice * $quantity;

    // Check if the product is already in the cart
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

    // Handle adding or updating cart item
    if ($cartItem) {
        // Update quantity and total price if the product is already in the cart
        $cartItem->quantity += $quantity;
        $cartItem->total_price += $totalPrice;
        $cartItem->save();
    } else {
        // Add new item to the cart
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ]);
    }

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
    // Find the cart item by ID
    $cartItem = Cart::findOrFail($id);
    $newQuantity = $request->input('quantity');

    // Get product data
    $product = $cartItem->product;

    // Check if the product has enough stock
    if ($product->stock < $newQuantity) {
        return response()->json(['error' => 'Not enough stock available.'], 400);
    }

    // Get active Big Sale for the product
    $activeBigSale = BigSale::where('status', true)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->whereHas('products', function ($query) use ($product) {
            $query->where('t_product.id', $product->id);
        })
        ->first();

    // Determine the price based on Big Sale or regular discount
    if ($activeBigSale) {
        if ($activeBigSale->discount_amount) {
            $productPrice = $product->price - $activeBigSale->discount_amount; // Apply flat discount
        } elseif ($activeBigSale->discount_percentage) {
            $productPrice = $product->price - ($activeBigSale->discount_percentage / 100) * $product->price; // Apply percentage discount
        }
    } else {
        // If no Big Sale, use the discount_price or regular price
        $productPrice = $product->discount_price ?? $product->price;
    }

    // Calculate new total price for the cart item
    $newProductTotal = $productPrice * $newQuantity;

    // Update cart item with new quantity and total price
    $cartItem->quantity = $newQuantity;
    $cartItem->total_price = $newProductTotal;
    $cartItem->save();

    // Calculate the new total cart value
    $cartTotal = Cart::where('user_id', Auth::id())->sum('total_price');

    // Return the response with updated total price and cart total
    return response()->json([
        'success' => true,
        'newProductTotal' => $newProductTotal,
        'newCartTotal' => $cartTotal,
    ]);
}



    


}
