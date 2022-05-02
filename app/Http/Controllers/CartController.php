<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::select('carts.*', 'products.name', 'products.price', 'products.image')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->where('user_id', Auth::user()->id)
            ->get();

        if(isset($carts)) {
            return view('cart.index', compact('carts'));
        } else {
            'No products in cart';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = Product::findOrFail($request->get('item'));
        $user = $request->user();
        $paymentMethod = $request->paymentMethod;
        $user->CreateOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
            $user->newSubscription('default', $product->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);
        
        Subscription::where('user_id', $user->id)->update(['status' => 0]);
        return redirect()->route('home')->with(session()->flash('status', 'Your order has been placed!'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $id = Auth::user()->id;
        // $carts = Cart::where('user_id', $id)
        // ->leftJoin('products', 'products.id', '=', 'carts.product_id')
        // ->leftJoin('users', 'users.id', '=', 'carts.user_id');
        // dd(vsprintf(str_replace(['?'], ['\'%s\''], $carts->toSql()), $carts->getBindings()));

            


        return view('cart.show', ['carts']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $delete = Cart::where('id', $request->id)->delete();
        if($delete) {
            return response()->json(['success' => 'Product deleted from cart successfully.']);
        } else {
            return response()->json(['error' => 'Product could not be deleted.']);
        }
    }
}
