<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(9);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename . '.' . $extension;
        
        // Upload Image
        $path = $request->file('file')->storeAs('public/storage/images', $fileNameToStore);

         $insertProduct = Product::insert([
            "name" => $request->name,
            "price" => $request->price,
            "image" => "storage/images/" . $fileNameToStore,
            "availability" => $request->availability ?? 'null',
            "product_qty" => $request->product_qty,
            "description" => $request->description ?? 'null',
            "stripe_plan" => $request->stripe_plan ?? 'null',
            "condition" => $request->condition ?? 'null',
        ]);

        if($insertProduct) {
            return redirect()->back()->with('success', 'Product added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    
    public function show(Request $request)
    {
        $product = Product::where('id', $request->id)->get();
        return view('product.show', compact('product'));
    }

    public function addToCart(Request $request) {
        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->product_id= $request->id;
        $cart->quantity= $request->quantity;
        $cart->price = $request->price;
        $cart->subtotal = $request->subtotal;
        $cart->save();

        return redirect()->back()->with(session()->flash('status', 'Product added to cart!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $products = Product::paginate(5);
        return view('product.edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename . '.' . $extension;
        
        // Upload Image
        $path = $request->file('file')->storeAs('public/storage/images', $fileNameToStore);

        $productsUpdate = Product::where('id', '=', $request->id)->update([
            'name' => $request->name, 
            'price' => $request->price, 
            'image' => "storage/images/" . $fileNameToStore,
            'availability' => $request->availability,
            'product_qty' => $request->product_qty,
            'condition' => $request->condition,
            'stripe_plan' => $request->stripe_plan,
            'description' => $request->description
        ]);
        
        if($productsUpdate) {
            return redirect()->back()->with('success', 'Product added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $productsDelete = Product::where('id', '=', $request->id)->delete();

        if($productsDelete) {
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Product deletion failed']);
        }
    }

    public function purchase(Request $request) {
        
        $product = Product::find($request->id);
        $paymentMethods = $request->user()->paymentMethods();
        $intent = $request->user()->createSetupIntent();
        
        return view('product.purchase', compact('product', 'intent'));
    }

    public function groupPurchase(Request $request) {
        $carts = Cart::find($request->id);
        $paymentMethods = $request->user()->paymentMethods();
        $intent = $request->user()->createSetupIntent();
        
        return view('product.groupPurchase', compact('products', 'intent'));
    }

    public function exportCsv() {
        $fileName = "products.csv";
        $products = Product::all();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre",
            "Expires" => "0"
        );

        $columns = array('id', 'name', 'description', 'price', 'image', 'availability', 'product_qty', 'condition', 'stripe_plan');

        $callback = function() use ($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($products as $product) {
                fputcsv($file, array(
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->image,
                    $product->availability,
                    $product->product_qty,
                    $product->condition,
                    $product->stripe_plan,
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
