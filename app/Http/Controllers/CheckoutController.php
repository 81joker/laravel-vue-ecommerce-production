<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.token'));

        [$products, $cartItems] = CartItem::getProductsAndCartItems();

        // /**  @var \App\Models\User $user */
        // $user = $request->user();
        $user = auth()->user();

        if (! $user->customer->shippingAddress || ! $user->customer->billingAddress) {
            return redirect()->route('profile')->with('error', 'Please provide your Addresse');
        }
        if ($user && $user->stripe_customer_id) {
            $customer_id = $user->stripe_customer_id;
        } else {
            // 2. Create a new Stripe Customer
            $customer = \Stripe\Customer::create([
                'name' => $user ? $user->name : null,
                'email' => $user ? $user->email : null,
            ]);

            $customer_id = $customer->id;
            // 3. Store the customer ID
            if ($user) {
                $user->stripe_customer_id = $customer_id;
                $user->save();
            }
        }

        // Create a Stripe Checkout Session

        $orderItems = [];
        $line_items = [];
        $totalPrice = 0;
        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];

            $totalPrice += $product->price * $quantity;
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => $product->image ? [$product->image] : [],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $quantity,
            ];
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'customer' => $customer_id, // Crucial: Associate the customer with the session
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);

        // Order the line items
        $orderDate = [
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        $order = Order::create($orderDate);

        // Create Order Items
        foreach ($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }

        $paymentDate = [
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'status' => PaymentStatus::Pending,
            'type' => 'cc',
            // 'type' => 'stripe',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id,
        ];
        $payment = Payment::create($paymentDate);

        return redirect($session->url, 303);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.token'));

        $stripe = new \Stripe\StripeClient(config('services.stripe.token'));

        try {
            $session = $stripe->checkout->sessions->retrieve(id: $_GET['session_id']);
            if (! $session or $session->payment_status !== 'paid') {
                return view('checkout.failure', ['error' => 'Payment Session not successful']);
            }

            // First Payment to Status paid
            $payment = Payment::query()->where(['session_id' => $session->id])->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])->first();

            // if (!$payment) {
            //     throw new NotFoundHttpException();
            // }

            if (! $payment) {
                // if (!$payment OR $payment->status !== PaymentStatus::Paid) {
                return view('checkout.failure', ['error' => 'Payment record not found']);
            }
            $payment->status = PaymentStatus::Paid;
            $payment->update();
            // $payment->save();

            // Second Order to Status paid
            $order = $payment->order;
            if (! $order) {
                return view('checkout.failure', ['error' => 'Order not found']);
            }
            $order->status = OrderStatus::Paid;
            $order->update();

            $user = auth()->user();

            // Third Remove from Cart
            CartItem::where('user_id', $user->id)->delete();

            // $customer = $stripe->customers->retrieve($session->customer);
            $customerName = $session->customer_details->name;

            return view('checkout.success', compact('customerName'));
        } catch (Error $e) {

            return view('checkout.failure', ['error' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        return view('checkout.cancel', ['error' => 'Order not found']);
    }

    public function checkoutOrder(Order $order, Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->title,
                        //                        'images' => [$product->image]
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);
        $order->payment->session_id = $session->id;
        $order->payment->save();

        return redirect($session->url);
    }

    // private function  getProductsAndCartItems()
    // {
    //     $cartItems = Cart::getCartItems();
    //     $ids = Arr::pluck($cartItems, 'product_id');
    //     $products = Product::query()->whereIn('id', $ids)->get();
    //     $cartItems = Arr::keyBy($cartItems, 'product_id');
    //     return [$products , $cartItems];
    // }
}
