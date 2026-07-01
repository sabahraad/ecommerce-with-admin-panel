<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        $total = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'] ?? 1;
            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        $stripeEnabled = ! empty(config('services.stripe.secret'));

        return view('checkout.index', compact('items', 'total', 'stripeEnabled'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $isGuest = ! Auth::check();

        $rules = [
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:stripe,cod'],
        ];

        if ($isGuest) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $request->validate($rules);

        // Handle user account for guests
        if ($isGuest) {
            $existingUser = User::where('email', $validated['shipping_email'])->first();

            if ($existingUser) {
                return redirect()->route('login')
                    ->withInput($request->except('password'))
                    ->with('error', 'An account with this email already exists. Please log in to continue.');
            }

            $user = User::create([
                'name' => $validated['shipping_name'],
                'email' => $validated['shipping_email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('customer');

            Auth::login($user);
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $items = [];
        $total = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'] ?? 1;

            if ($quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', "Not enough stock for {$product->name}.");
            }

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => $total,
            'shipping_name' => $validated['shipping_name'],
            'shipping_email' => $validated['shipping_email'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_phone' => $validated['shipping_phone'],
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
            ]);

            $item['product']->decrement('stock', $item['quantity']);
        }

        if ($validated['payment_method'] === 'cod') {
            session()->forget('cart');

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully. You will pay on delivery.');
        }

        if (empty(config('services.stripe.secret'))) {
            $order->update(['status' => 'cancelled']);

            return redirect()->route('cart.index')
                ->with('error', 'Stripe is not configured. Please choose Cash on Delivery.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['product']->name,
                    ],
                    'unit_amount' => (int) ($item['product']->price * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id, 'session_id' => '{CHECKOUT_SESSION_ID}']),
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
            'customer_email' => $validated['shipping_email'],
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        $order->update([
            'payment_intent_id' => $session->id,
        ]);

        session()->forget('cart');

        return redirect($session->url);
    }

    public function success(Request $request, Order $order): View
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                ]);
            }
        }

        return view('checkout.success', compact('order'));
    }

    public function cancel(Order $order): View
    {
        $order->update(['status' => 'cancelled']);

        return view('checkout.cancel', compact('order'));
    }
}
