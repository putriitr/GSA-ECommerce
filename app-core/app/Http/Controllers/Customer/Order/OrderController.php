<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; 

class OrderController extends Controller
{

    // Show the customer's order
    public function showOrder($orderId)
    {
        $order = Order::find($orderId);
        return view('customer.order.show', compact('order'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Get the status filter from the request
        $status = $request->input('status');
    
        // Fetch orders based on the status filter
        $orders = Order::where('user_id', auth()->id()) // Fetch only user's orders
                        ->when($status && $status !== 'semua', function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
    
            // Count orders with the 'approved' status (Menunggu Pembayaran)
        $waitingForPaymentCount = Order::where('user_id', auth()->id())
        ->where('status', 'approved')
        ->count();
        
        return view('customer.settings.order.index', compact('orders', 'status','user', 'waitingForPaymentCount'));
    }
    


    // Checkout - Create an order
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->discount_price ?? $item->product->price);
        });

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending', // default status is pending
        ]);

        // Attach items to the order
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->discount_price ?? $item->product->price,
                'total' => $item->quantity * ($item->product->discount_price ?? $item->product->price),
            ]);
        }

        // Clear cart after checkout
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('customer.order.show', $order->id)->with('success', 'Checkout completed.');
    }


    // Submit payment proof
    public function submitPaymentProof(Request $request, $orderId)
{
    // Find the order
    $order = Order::find($orderId);

    // Check if the order is cancelled
    if ($order->status === 'cancelled_by_system') {
        return back()->with('info', 'Your order has been cancelled due to non-payment.');
    }

    // Validate the payment proof
    $request->validate([
        'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Store the payment proof in public/payments
    $fileName = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
    $request->file('payment_proof')->move(public_path('payments'), $fileName);

    // Save the payment details
    Payment::create([
        'order_id' => $orderId,
        'payment_proof' => 'payments/' . $fileName,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Payment proof submitted. Awaiting verification.');
}


        // Customer marks order as complete
    public function completeOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'completed']);

        return back()->with('success', 'Order marked as completed.');
    }

    // Cancel the order
    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'You cannot cancel this order.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order has been cancelled successfully.');
    }

    public static function generateInvoiceNumber()
    {
        // Format untuk tahun dan bulan
        $yearMonth = date('Ym'); 
        
        // Ambil nomor terakhir di bulan ini dari database
        $lastOrder = DB::table('t_orders')
        ->whereRaw('YEAR(created_at) = ?', [date('Y')])
        ->whereRaw('MONTH(created_at) = ?', [date('m')])
        ->orderBy('invoice_number', 'desc')
        ->first();

        // Tentukan nomor urut baru
        if ($lastOrder) {
            // Jika sudah ada order di bulan ini, ambil angka terakhir dari nomor invoice dan tambahkan 1
            $lastInvoiceNumber = intval(substr($lastOrder->invoice_number, -4));
            $nextInvoiceNumber = str_pad($lastInvoiceNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada order di bulan ini, mulai dari 0001
            $nextInvoiceNumber = '0001';
        }

        // Gabungkan format untuk nomor invoice
        return 'INV/' . $yearMonth . '/' . $nextInvoiceNumber;
    }

    public function generateInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Check if the order is approved before generating the invoice
        if (!in_array($order->status, ['approved', 'packing', 'shipped', 'completed'])) {
            return redirect()->back()->with('error', 'Invoice can only be generated for approved, packing, shipped, or completed orders.');
        }

        // Generate invoice number if not already generated
        if (!$order->invoice_number) {
            $order->invoice_number = Order::generateInvoiceNumber();
            $order->save();
        }

        // Retrieve the e-commerce name from the parameter
        $parameter = Parameter::first(); // Assuming there's only one record

        // Sanitize invoice_number to remove any slashes or backslashes
        $invoice_number = str_replace(['/', '\\'], '-', $order->invoice_number);

        // Remove spaces from the e-commerce name
        $nama_ecommerce = str_replace(' ', '', $parameter->nama_ecommerce);

        // Set the invoice filename with the sanitized invoice number and e-commerce name
        $filename = $nama_ecommerce . '_' . $invoice_number . '.pdf';

        $pdf = PDF::loadView('customer.order.invoice', compact('order'));

        // Download the PDF file with the sanitized invoice number as the filename
        return $pdf->download($filename);
    }






}
