<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Product_Attribute;
use App\Models\Attribute_Value;
use App\Models\VariationMapping;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\Label;
use App\Models\SearchHistory;
use App\Models\ViewRecord;
use App\Models\Review;
use App\Models\User;
use App\Models\Message;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Carbon\Carbon;
use Stripe\Checkout\Session as StripeSession;
use App\Events\PusherBroadcast;

class CustomerController extends Controller
{
    public function index(){
        $user_id = Auth::id();
        $customer = Customer::where('user_id', $user_id)->first();
        if ($customer) {
            session(['customer_id' => $customer->customer_id]);
            session()->forget('variation');
        } else {
            // Handle the case where the customer is not found
            return redirect()->route('user.show_login_form')->withErrors(['login' => 'Your sesssion has expired.']);;
        }
        
        // Recommended Product

        // from search history
        $recommended_products = collect();

        // Get unique result labels from search history
        $search_result_labels = SearchHistory::where('customer_id', $customer->customer_id)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->pluck('result_label')
            ->unique();

        foreach ($search_result_labels as $label_id) {
            $products = Product::where('label_id', $label_id)
                ->orderBy('label_id', 'desc') // latest product
                ->take(2)
                ->get();

            // Merge products into the collection
            $recommended_products = $recommended_products->concat($products);
        }

        // Process product prices
        $recommended_products->each(function ($product) {
            $variation_prices = Variation::where('product_id', $product->product_id)->pluck('price')->toArray();

            if (!empty($variation_prices)) {
                $min = min($variation_prices);
                $max = max($variation_prices);
                $product->price = ($min == $max)
                    ? 'RM' . number_format($min, 2)
                    : 'RM' . number_format($min, 2) . ' - RM' . number_format($max, 2);
            }
        });

        // From purchase history
        $order_variation_ids = Order::where('customer_id', $customer->customer_id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->pluck('variation_id');

        foreach ($order_variation_ids as $id) {
            $product_id = Variation::where('variation_id', $id)->pluck('product_id')->first();
            $product = Product::where('product_id', $product_id)->first();

            if ($product) {
                $recommned_product = Product::where('label_id', $product->label_id)
                    ->orderBy('label_id', 'desc')
                    ->take(1)
                    ->first();

                // Add the recommended product to the collection
                if ($recommned_product) {
                    $recommended_products = $recommended_products->concat([$recommned_product]);
                }
            }
        }

        // Recently View
        $view_records_id = ViewRecord::where('customer_id', $customer->customer_id)
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->pluck('product_id');
        $recently_view_products = Product::whereIn('product_id', $view_records_id)->get();

        foreach($recently_view_products as $product){
            $variation_prices = Variation::where('product_id', $product->product_id)->pluck('price') ->toArray();
            if(!empty($variation_prices)){
                $min = min($variation_prices);
                $max = max($variation_prices);
            }
            if($min == $max){
                $product->price = 'RM'.number_format($min, 2);
            }else{
                $product->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
            }
        }

        // Top Seller
        $products = Product::all();
        $revenue_per_product = [];
        foreach ($products as $product) {
            $variations = $product->variations;
            $totalRevenue = 0;

            foreach ($variations as $variation) {
                $orders = $variation->orders;
                foreach ($orders as $order) {
                    $totalRevenue += $order->total_price;
                }
            }
            $revenue_per_product[$product->product_id] = $totalRevenue;
        }

        $highest_revenue_product_ids = collect($revenue_per_product)
        ->sortDesc() 
        ->take(4)    
        ->keys(); 

        $top_seller_products = Product::whereIn('product_id', $highest_revenue_product_ids)->get();
        foreach($top_seller_products as $product){
            $variation_prices = Variation::where('product_id', $product->product_id)->pluck('price') ->toArray();
            if(!empty($variation_prices)){
                $min = min($variation_prices);
                $max = max($variation_prices);
            }
            if($min == $max){
                $product->price = 'RM'.number_format($min, 2);
            }else{
                $product->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
            }
        }

        $categories = Category::all();
        return view('customer.index',
        ['recommended_products' => $recommended_products, 
        'recently_view_products' => $recently_view_products,
        'top_seller_products' => $top_seller_products,
        'categories' => $categories]);
    }

    public function complete_profile_form(){
        return view('customer.complete_profile');
    }

    public function complete_profile(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required',
        ]);

        $data['user_id'] = Auth::id();
        $newCustomer = Customer::create($data);

        if($newCustomer){
            return redirect(route('customer.index'));
        }else {
            return redirect()->back()->withErrors(['error' => 'Failed to complete profile.']);
        }
    }

    public function show_profile(){
        $user_id = Auth::id();
        $customer = Customer::where('user_id', $user_id)->first();

        $dateOfBirth = new \DateTime($customer->date_of_birth);
        $today = new \DateTime();
        $age = $today->diff($dateOfBirth)->y;

        $customer->age = $age;
        return view('customer.show_profile', ['customer' => $customer]);
    }

    public function view_product($product_id){
        $product = Product::find($product_id);
        $variation_prices = Variation::where('product_id', $product_id)->pluck('price') ->toArray();
        $product->stock = Variation::where('product_id', $product_id)->sum('stock');
        if(!empty($variation_prices)){
            $min = min($variation_prices);
            $max = max($variation_prices);
        }
        if($min == $max){
            $product->price = 'RM'.number_format($min, 2);
        }else{
            $product->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
        }

        $reviews = Review::where('product_id', $product_id)->get();
        if ($reviews->count() > 0) {
            foreach($reviews as $review){
                $customer_name = Customer::where('customer_id', $review->customer_id)->pluck('name')->first();
                $review->customer_name = $customer_name;
            }
        }

        $record_exist = Review::where('customer_id', session('customer_id'))->where('product_id', $product_id)->exists();
        // create view record
        $data = [
            'customer_id' => session('customer_id'),
            'product_id' => $product->product_id
        ];
        $newRecord = ViewRecord::create($data);

        $shop_recommendations = Product::where('seller_id', $product->seller_id)
        ->where('product_id', '!=', $product->product_id)
        ->take(6)
        ->get();
        foreach($shop_recommendations as $recommendation){
            $variation_prices = Variation::where('product_id', $recommendation->product_id)->pluck('price') ->toArray();
            if(!empty($variation_prices)){
                $min = min($variation_prices);
                $max = max($variation_prices);
            }
            if($min == $max){
                $recommendation->price = 'RM'.number_format($min, 2);
            }else{
                $recommendation->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
            }
        }
        $seller = Seller::find($product->seller_id);

        $attributes = Product_Attribute::where('product_id', $product_id)->get();
        
        $attribute_names = $attributes->pluck('attribute_name')->toArray();
        $attribute_values_list = $attributes->map(function ($attribute) {
            return Attribute_value::where('attribute_id', $attribute->attribute_id)->get(['attribute_value', 'attribute_value_id']);
        });
        return  view('customer.view_product', [
            'product' => $product, 
            'reviews' => $reviews, 
            'record_exist' => $record_exist, 
            'seller' => $seller, 
            'shop_recommendations' => $shop_recommendations,
            'attribute_names' => $attribute_names,
            'attribute_values_list' => $attribute_values_list,
        ]); 
    }

    // public function add_to_cart_form($product_id){
    //     $attributes = Product_Attribute::where('product_id', $product_id)->get();
    //     // dd($attributes);
    //     $attribute_values_list = [];
    //     foreach($attributes as $attribute){
    //         $attribute_values_list[] = Attribute_value::where('attribute_id', $attribute->attribute_id)->pluck('attribute_value');
    //         // $attribute->value1 = 
    //     }
    //     dd($attribute_values_list);
    //     return view('customer.add_to_cart_form', ['attribute_names' => $attributes->attribute_name, 'attibute_values' => $attribute_values_list]);
    // }

    public function add_to_cart_form($product_id){
        $attributes = Product_Attribute::where('product_id', $product_id)->get();
        
        $attribute_names = $attributes->pluck('attribute_name')->toArray();
        $attribute_values_list = $attributes->map(function ($attribute) {
            return Attribute_value::where('attribute_id', $attribute->attribute_id)->get(['attribute_value', 'attribute_value_id']);
        });

        return view('customer.add_to_cart_form', [
            'attribute_names' => $attribute_names,
            'attribute_values_list' => $attribute_values_list,
            'product_id' => $product_id
        ]);
    }

    public function get_variation_details(Request $request, $product_id){
        $variations_1 = VariationMapping::where('attribute_value_id', $request->attribute_1)->pluck('variation_id');
        if(isset($request->attribute_2)){
            $variations_2 = VariationMapping::where('attribute_value_id', $request->attribute_2)->pluck('variation_id');
            $variation_id = $variations_1->intersect($variations_2);
        }else{
            $variation_id = $variations_1;
        }
        $variation = Variation::find($variation_id)->first();
        session()->put('variation', $variation);
        return redirect()->back()->withInput()->with('success', 'success');
    }

    public function add_to_cart(Request $request){
        $data = $request->validate([
            'variation_id' => 'required',
            'quantity' => 'required|integer',
        ]);
        $customer_id = session('customer_id');
        $data['customer_id'] = $customer_id;

        $newCart = Cart::create($data);
        if($newCart){
            return redirect(route('customer.index'));
        }
    }

    public function shopping_cart(){
        $customer_id = session('customer_id');
        $carts = Cart::where('customer_id', $customer_id)->get();
        foreach($carts as $cart){
            // get price and image
            $variation_id = $cart->variation_id;
            $variation = Variation::find($variation_id);
            $cart->price = $variation->price;
            $cart->image_url = $variation->image_url;

            // get variation name
            $attribute_value_ids = VariationMapping::where('variation_id', $variation_id)->pluck('attribute_value_id');
            $variation_name_list = [];
            foreach($attribute_value_ids as $id){
                $attribute_value = Attribute_Value::where('attribute_value_id', $id)->pluck('attribute_value')->toArray();
                $variation_name_list = array_merge($variation_name_list, $attribute_value);
            }
            $variation_name = '';
            foreach($variation_name_list as $name){
                $variation_name .= $name.', ';
            }
            $variation_name = rtrim($variation_name, ', ');
            $cart->variation_name =  $variation_name;

            // get product name
            $product_name = Product::where('product_id' , $variation->product_id)->pluck('product_name');
            $cart->product_name = $product_name[0];
        }
        return view('customer.shopping_cart', ['carts' => $carts]);
    }

    public function check_out_page(Request $request){
        $cart_ids = $request->input('cart_ids', []); 
        $carts = Cart::whereIn('cart_id', $cart_ids)->get();
        foreach($carts as $cart){
            // get price and image
            $variation_id = $cart->variation_id;
            $variation = Variation::find($variation_id);
            $cart->price = $variation->price;
            $cart->image_url = $variation->image_url;

            // get variation name
            $attribute_value_ids = VariationMapping::where('variation_id', $variation_id)->pluck('attribute_value_id');
            $variation_name_list = [];
            foreach($attribute_value_ids as $id){
                $attribute_value = Attribute_Value::where('attribute_value_id', $id)->pluck('attribute_value')->toArray();
                $variation_name_list = array_merge($variation_name_list, $attribute_value);
            }
            $variation_name = '';
            foreach($variation_name_list as $name){
                $variation_name .= $name.', ';
            }
            $variation_name = rtrim($variation_name, ', ');
            $cart->variation_name =  $variation_name;

            // get product name
            $product_name = Product::where('product_id' , $variation->product_id)->pluck('product_name');
            $cart->product_name = $product_name[0];

            //get seller_id
            $seller_id = Product::where('product_id' , $variation->product_id)->pluck('seller_id');
            $cart->voucher = Voucher::whereIn('seller_id', $seller_id)->get();
        }

        $total_price = 0;
        foreach ($carts as $cart) {
            $total_price += $cart->price * $cart->quantity;
        }
        session()->flash('total_price', $total_price);
        return view('customer.check_out_page', ['carts' => $carts]);
    }

    public function voucher_application(Request $request){
        $cart_ids = $request->input('all_cart_ids', []);
        $carts = Cart::whereIn('cart_id', $cart_ids)->get();
        $update_cart_id = $request->input('cart_id');
        $currentDate = Carbon::now();
        $prices = $request->input('all_prices', []);

        foreach($carts as $index => $cart){
            // get price and image
            $variation_id = $cart->variation_id;
            $variation = Variation::find($variation_id);
            $cart->image_url = $variation->image_url;

            // get variation name
            $attribute_value_ids = VariationMapping::where('variation_id', $variation_id)->pluck('attribute_value_id');
            $variation_name_list = [];
            foreach($attribute_value_ids as $id){
                $attribute_value = Attribute_Value::where('attribute_value_id', $id)->pluck('attribute_value')->toArray();
                $variation_name_list = array_merge($variation_name_list, $attribute_value);
            }
            $variation_name = '';
            foreach($variation_name_list as $name){
                $variation_name .= $name.', ';
            }
            $variation_name = rtrim($variation_name, ', ');
            $cart->variation_name =  $variation_name;

            // get product name
            $product_name = Product::where('product_id' , $variation->product_id)->pluck('product_name');
            $cart->product_name = $product_name[0];

            //get seller_id
            $seller_id = Product::where('product_id' , $variation->product_id)->pluck('seller_id');
            $cart->voucher = Voucher::whereIn('seller_id', $seller_id)->get();

            // update price
            if($cart->cart_id == $update_cart_id){
                $voucher_id = $request->input('voucher_id');
                $voucher = Voucher::find($voucher_id);

                if($currentDate->between(Carbon::parse($voucher->start_date), Carbon::parse($voucher->end_date))){
                    if ($voucher->discount_type == 'percentage'){
                        $new_price = $variation->price * ((100 - $voucher->discount_value) / 100);
                    } elseif ($voucher->discount_type == 'fixed_amount') {
                        $new_price = $variation->price - $voucher->discount_value;
                    }
                    $cart->price = $new_price;
                }else {
                    $cart->price = $variation->price;
                }
            }else{
                $cart->price = $prices[$index];
            }

            // default_price
            $cart->default_price = $variation->price;
        }

        session()->flash('carts', $carts);
        session()->flash('updated_cart_id', $update_cart_id);
        $total_price = 0;
        foreach ($carts as $cart) {
            $total_price += $cart->price * $cart->quantity;
        }
        session()->flash('total_price', $total_price);

        return redirect()->route('customer.updated_check_out_page')->with('success', 'successful');
    }

    public function updated_check_out_page(){
        $carts = session('carts', []);
        return view('customer.check_out_page', ['carts' => $carts]);
    }

    public function check_out(Request $request){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $cart_ids = $request->input('all_cart_ids', []);
        $carts = Cart::whereIn('cart_id', $cart_ids)->get();
        $prices = $request->input('all_prices', []);

        foreach($carts as $index => $cart){
            $variation_id = $cart->variation_id;
            $variation = Variation::find($variation_id);
            $product_name = Product::where('product_id' , $variation->product_id)->pluck('product_name');
            $cart->product_name = $product_name[0];
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $cart->product_name,
                    ],
                    'unit_amount' => $prices[$index] * 100,
                ],
                'quantity' => $cart->quantity,
            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('customer.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            // 'cancel_url' => route('customer.failure', [], true),
            'metadata' => [
                'cart_ids' => json_encode($cart_ids),
            ],
        ]);
        return redirect($session->url);
    }

    public function success(Request $request){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->query('session_id');
    
        $session = StripeSession::retrieve($sessionId);
        $cart_ids_encoded =$session->metadata->cart_ids;
        $cart_ids = json_decode($cart_ids_encoded, true);

        $lineItems = \Stripe\Checkout\Session::allLineItems($sessionId, ['limit' => 100]);
        $unit_amounts = [];
        foreach ($lineItems as $lineItem) {
            if (isset($lineItem->price->unit_amount)) {
                $unit_amounts[] = $lineItem->price->unit_amount;
            }
        }
        $carts = Cart::whereIn('cart_id', $cart_ids)->get();

        foreach($carts as $index => $cart){
            $orderData = [
                'customer_id' => session('customer_id'),
                'variation_id' => $cart->variation_id,
                'quantity' => $cart->quantity,
                'total_price' => ($unit_amounts[$index] / 100) * $cart->quantity,
                'order_status' => 'Preparing',
            ];
            $newOrder = Order::create($orderData);
            if($newOrder){
                Cart::destroy($cart->cart_id);
                $variation_id = $cart->variation_id;
                $variation = Variation::find($variation_id);
                $variation->stock -= $cart->quantity;
                $variation->save();
            }
        }
        return redirect(route('customer.order_page'));
    }

    public function remove_from_cart($cart_id){
        Cart::destroy($cart_id);
        return redirect(route('customer.shopping_cart'));
    }

    public function order_page(){
        $customer_id = session('customer_id');
        $orders = Order::where('customer_id',  $customer_id)->get();
        foreach($orders as $order){
            // get price and image
            $variation_id = $order->variation_id;
            $variation = Variation::find($variation_id);

            // get variation name
            $attribute_value_ids = VariationMapping::where('variation_id', $variation_id)->pluck('attribute_value_id');
            $variation_name_list = [];
            foreach($attribute_value_ids as $id){
                $attribute_value = Attribute_Value::where('attribute_value_id', $id)->pluck('attribute_value')->toArray();
                $variation_name_list = array_merge($variation_name_list, $attribute_value);
            }
            $variation_name = '';
            foreach($variation_name_list as $name){
                $variation_name .= $name.', ';
            }
            $variation_name = rtrim($variation_name, ', ');
            $order->variation_name =  $variation_name;

            // get product name
            $product_name = Product::where('product_id' , $variation->product_id)->pluck('product_name');
            $order->product_name = $product_name[0];

            // get order date
            $created_at = $order->created_at;
            $formatted_date = $created_at->format('Y-m-d');
            $order->date = $formatted_date;
        }
        return view('customer.order_page', ['orders' => $orders]);
    }

    public function update_order_status($order_id){
        $order = Order::find($order_id);
        $order->order_status = 'Received';
        $order->save();
        return redirect(route('customer.order_page'));
    }

    public function search(Request $request){
        $search_query = $request->search_query;
        $results = Product::where('product_name', 'like', "%$search_query%")->get();
        if($results->count() > 0){
            $label_id = Product::where('product_name', 'like', "%$search_query%")->pluck('label_id')->first();
            $data = [
                'customer_id' => session('customer_id'),
                'search_query' => $search_query,
                'result_label' => $label_id 
            ];
            $newSearch = SearchHistory::create($data);
            
            foreach($results as $result){
                $variation_prices = Variation::where('product_id', $result->product_id)->pluck('price') ->toArray();
                if(!empty($variation_prices)){
                    $min = min($variation_prices);
                    $max = max($variation_prices);
                }
                if($min == $max){
                    $result->price = 'RM'.number_format($min, 2);
                }else{
                    $result->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
                }
            }

        }
        return view('customer.search_result', ['results' => $results]);
    }

    public function add_review(Request $request){
        $data = $request->validate([
            'rating_star' => 'required|integer',
            'review_text' => 'string|max:255',
            'product_id' => 'required',
        ]);
        
        $data['customer_id'] = session('customer_id');
        
        $newReview = Review::create($data);
        if($newReview){
            return redirect()->back();
        }
    }

    public function update_profile_form($customer_id){
        $customer = Customer::find($customer_id);
        $user = User::find($customer->user_id);
        $customer->username = $user->username;
        $customer->password = $user->password;
       
        return view('customer.update_profile_form', ['customer' => $customer]);
    }

    public function update_profile(Request $request){
        $data = $request->validate([
            'new_password' => 'nullable|string|min:8|max:16|regex:/[a-zA-Z]/|regex:/[0-9]/',
            'name' => 'required|string|max:255', 
            'phone_number' => 'required|string|max:20',
        ]);
        $customer = Customer::find(session('customer_id'));
        $user = User::find($customer->user_id);

        if(!empty($request->new_password)){
            if(!Hash::check($request->old_password, $user->password)){
                return redirect()->back()->with('error', 'The old password you entered is incorrect.');
            }
            $user->password = Hash::make($data['new_password']);
        }

        if($request->username != $user->username){
            $request->validate([
                'username' => 'required|string|max:16|unique:users,username', 
            ]);
            $user->username = $request->username;
        }

        if($request->email != $customer->email){
            $request->validate([
                'email' => 'required|string|email|max:255|unique:customers,email', 
            ]);
            $customer->email = $request->email;
        }
        
        $customer->name = $data['name'];
        $customer->phone_number = $data['phone_number'];

        $user->save();
        $customer->save();

        return redirect(route('customer.update_profile_form', ['customer_id' => $customer->customer_id]))->with('success', 'Update successfully');
    }

    public function customer_chat_list(){
        $customer_id = session('customer_id');
        $messages = Message::where('customer_id', $customer_id)
        ->orderBy('created_at', 'desc')
        ->get();
        $chat_list = $messages->unique('seller_id')->values();
        foreach ($chat_list as $list_item){
            $list_item->shop_name = Seller::where('seller_id', $list_item->seller_id)->value('shop_name');
        }

        return view('customer.chat_list', ['chat_list' => $chat_list]);
    }

    public function send_message(Request $request, $seller_id){
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $customer_id = session('customer_id');
    
        $message = Message::create([
            'customer_id' => $customer_id,
            'seller_id' => $seller_id,
            'message_text' => $request->message,
            'sender' => 'customer'
        ]);

        broadcast(new PusherBroadcast($message, $seller_id, $customer_id));

        return response()->json(['message' => $request->message]);
    }

    public function chat_with_seller($seller_id){
        $seller = Seller::find($seller_id);
        $customer_id = session('customer_id');
        $messages = Message::where('seller_id', $seller_id)
        ->where('customer_id', $customer_id)
        ->orderBy('created_at', 'asc')
        ->get();
 
        return view('customer.conversation', ['seller' => $seller, 'messages' => $messages]);
    }

    public function category_page($category_id){
        $products = Product::where('category_id', $category_id)->get();
        foreach($products as $product){
            $variation_prices = Variation::where('product_id', $product->product_id)->pluck('price') ->toArray();
            if(!empty($variation_prices)){
                $min = min($variation_prices);
                $max = max($variation_prices);
            }
            if($min == $max){
                $product->price = 'RM'.number_format($min, 2);
            }else{
                $product->price = 'RM'.number_format($min, 2).' - RM'.number_format($max, 2);
            }
        }
        return view('customer.category', ['products' => $products]);
    }


}
