<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Seller_Request;
use App\Models\Label;
use App\Models\Product_Attribute;
use App\Models\Attribute_Value;
use App\Models\VariationMapping;
use App\Models\Variation;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\ViewRecord;
use App\Models\Message;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\PusherBroadcast;



class SellerController extends Controller
{
    public function index(){
        $user_id = Auth::id();
        $seller = Seller::where('user_id', $user_id)->first();
        if ($seller) {
            session(['seller_id' => $seller->seller_id]);
            return view('seller.index', ['seller' => $seller]);
        } else {
            return redirect()->route('user.show_login_form')->withErrors(['login' => 'Your sesssion has expired.']);
        }
    }
    
    public function complete_profile_form(){
        return view('seller.complete_profile_form');
    }

    public function complete_profile(Request $request){
        $data = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'required|string|max:2000',
            'email' => 'required|email',
            'phone_number' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        if($request -> hasFile('image')){
            $image = $request->file('image');
            $image_path = $image->store('images', 'public');
            $image_url = Storage::url($image_path);
        }

        $data['user_id'] = Auth::id();
        $data['image_url'] = $image_url;

        $newSeller = Seller::create($data);

        if($newSeller){
            return redirect(route('seller.index'));
        }else {
            return redirect()->back()->withErrors(['error' => 'Failed to complete profile.']);
        }
    }

    public function show_upload_product_form(){
        $categories = Category::all();
        return view('seller.upload_product', ['categories' => $categories]);
    }

    public function upload_product(Request $request){
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string|max:2000',
            'category_id' => 'required',
            'label_id' => 'required',
            'product_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        if($request -> hasFile('product_image')){
            $image = $request->file('product_image');
            $image_path = $image->store('images', 'public');
            $image_url = Storage::url($image_path);
        }

        $data['image_url'] = $image_url;
        $data['seller_id'] = Session::get('seller_id');

        $newProduct = Product::create($data);

        if($newProduct){
            return redirect(route('seller.attribute', ['product' => $newProduct]));
        }else{
            return redirect()->back()->withErrors(['error' => 'Failed to upload product.']);
        }
    }

    public function get_product_label(Request $request){
        $selected_category_id = $request->query('category');
        $labels = Label::where('category_id', $selected_category_id)->get();

        // Generate HTML for labels 
        $html = '<label for="label_id">Label:</label>';
        $html .= '<select id="label" name="label_id">';
        $html .= '<option value="">Please Select</option>';
        foreach ($labels as $label) {
            $html .= '<option value="' . $label->label_id . '">' . $label->label_name . '</option>';
        }
        $html .= '</select>';

        return response()->json(['html' => $html]);
    }

    public function request_new_product_label(Request $request){
        $data = $request->validate([
            'label_name' => 'required|string|max:255|unique:seller_requests,label_name',
            'seller_id' => 'required',
            'category_id' => 'required'
        ]);
        $data['status'] = 'Pending';
        $new_request = Seller_Request::create($data);
        if($new_request){
            return redirect()->back()->with('request_success', 'Request was successful!');
        }
        
    }

    public function attribute(Product $product){
        $attributes = Product_Attribute::where('product_id', $product->product_id)->with('values')->get();
        return view('seller.attribute', ['product' => $product, 'attributes'=>$attributes]);
    }

    public function add_attribute(Request $request){
        $data = $request->validate([
            'product_id' => 'required',
            'attribute_name' => 'required|string|max:255',
            'attribute_value_1' => 'required|string|max:255',
            'attribute_value_2' => 'nullable|string|max:255',
            'attribute_value_3' => 'nullable|string|max:255',
        ]);

        $attribute_values = [
            $data['attribute_value_1'],
            $data['attribute_value_2'],
            $data['attribute_value_3'],
        ];

        $attribute = new Product_Attribute();
        $attribute->attribute_name = $data['attribute_name'];
        $attribute->product_id = $data['product_id'];
        $attribute->save();

        $value_data = [];
        $value_data['attribute_id'] = $attribute->attribute_id;
        foreach ($attribute_values as $value) {
            if (!empty($value)) {
                $value_data['attribute_value'] = $value;
                Attribute_Value::create($value_data);
            }
        }

        return redirect()->back();
    }
    
    public function generate_variation($product_id){
        $product = Product::find($product_id);
        $attribute_id = Product_Attribute::where('product_id', $product_id)->pluck('attribute_id')->toArray();
        
        $attribute_value_list1 = Attribute_Value::where('attribute_id', $attribute_id[0])->pluck('attribute_value_id')->toArray();
        if(count($attribute_id) > 1){
            $attribute_value_list2 = Attribute_Value::where('attribute_id', $attribute_id[1])->pluck('attribute_value_id')->toArray();
        }else{
            $attribute_value_list2 = [];
        }
       
        
        $has_list1 = !empty($attribute_value_list1);
        $has_list2 = !empty($attribute_value_list2);

        if($has_list1 && $has_list2){
            foreach($attribute_value_list1 as $value1){
                foreach($attribute_value_list2 as $value2){
                    // $variation_data = [];
                    $variation_data = ([
                        'product_id' => $product_id,
                        'price' => 0.00,
                        'stock' => 0,
                        'image_url' => $product->image_irl,
                    ]);
                    $new_variation = Variation::create($variation_data);
                    $variation_id = $new_variation->variation_id;
                    $mapping_data1 = [];
                    $mapping_data1['attribute_value_id'] = $value1;
                    $mapping_data1['variation_id'] =$variation_id;
                    VariationMapping::create($mapping_data1);
                    $mapping_data2 = [];
                    $mapping_data2['attribute_value_id'] = $value2;
                    $mapping_data2['variation_id'] =$variation_id;
                    VariationMapping::create($mapping_data2);
                }
            }
        }elseif(!$has_list2){        //list2 is empty
            foreach($attribute_value_list1 as $value1){
                // $variation_data = [];
                $variation_data = ([
                    'product_id' => $product_id,
                    'price' => 0.00,
                    'stock' => 0,
                    'image_url' => $product->image_url,
                ]);
                $new_variation = Variation::create($variation_data);
                $variation_id = $new_variation->variation_id;
                $mapping_data1 = [];
                $mapping_data1['attribute_value_id'] = $value1;
                $mapping_data1['variation_id'] =$variation_id;
                VariationMapping::create($mapping_data1);
            }
        }


        return redirect(route('seller.show_variation', ['product_id' => $product_id]));
    }

    public function show_variation($product_id){
        $attributes = Product_Attribute::where('product_id', $product_id)->with('values')->get();
        $variations = Variation::where('product_id', $product_id)->get();
        foreach($variations as $variation){
            $attribute_value_ids = VariationMapping::where('variation_id', $variation->variation_id)->pluck('attribute_value_id');
            $attribute_value = [];
            foreach($attribute_value_ids as $id){
                $attribute_value[] = Attribute_Value::where('attribute_value_id', $id)->pluck('attribute_value');
            }
            $variation->attribute1 = $attribute_value[0][0];
            if (count($attribute_value) > 1){
                $variation->attribute2 = $attribute_value[1][0];
            }else{
                $variation->attribute2 = '-';
            }
        }

        return view('seller.show_variation', ['attributes' => $attributes, 'variations' => $variations ]);
    }

    public function update_variation(Request $request, $variation_id){
        $data = $request->validate([
            'price' => 'required|min:0', 
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', 
        ]);
        $variation = Variation::find($variation_id);
        if($request -> hasFile('image')){
            $image = $request->file('image');
            $image_path = $image->store('images', 'public');
            $image_url = Storage::url($image_path);
            $variation->image_url =  $image_url;
        }
        
        $variation->price = $data['price'];
        $variation->stock = $data['stock'];
        $variation->save();

        return redirect(route('seller.show_variation', ['product_id' =>  $variation->product_id]))->with('success', 'Update Successfully!');
    }

    public function create_voucher_form(){
        return view('seller.create_voucher_form');
    }

    public function create_voucher(Request $request){
        $data = $request->validate([
            'voucher_description' => 'required|string|max:255',
            'discount_type' => 'required',
            'discount_value' => 'required|integer',  
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'required|integer'
        ]);

        $data['seller_id'] = session('seller_id');
        $data['usage_count'] = 0;
        $newVoucher = Voucher::create($data);
        if($newVoucher){
            return redirect(route('seller.create_voucher_form'))->with('success', 'Voucher Created Successfully.');
        }
    }

    public function manage_order_page(){
        $seller_id = session('seller_id');
        $products = Product::where('seller_id' , $seller_id)->get();
        $variation_ids = [];
        foreach($products as $product){
            $variation_ids = array_merge($variation_ids, Variation::where('product_id' , $product->product_id)->pluck('variation_id')->toArray());
        }
        $variation_ids = array_unique($variation_ids);
        $orders = Order::whereIn('variation_id', $variation_ids)->get();
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

        return view('seller.manage_order_page', ['orders' => $orders]);
    }

    public function update_shipped_order_status($order_id){
        $order = Order::find($order_id);
        $order->order_status = 'Shipped';
        $order->save();
        return redirect(route('seller.manage_order_page'));
    }  
    
    public function sales_analysis(){
        $seller_id = session('seller_id');
        $products = Product::where('seller_id' , $seller_id)->get();
        $variation_ids = [];
        foreach($products as $product){
            $variation_ids = array_merge($variation_ids, Variation::where('product_id' , $product->product_id)->pluck('variation_id')->toArray());
        }
        $variation_ids = array_unique($variation_ids);
        $orders = Order::whereIn('variation_id', $variation_ids)->get();
        
        $product_ids = Product::where('seller_id' , $seller_id)->pluck('product_id')->toArray();
        $visitors = ViewRecord::whereIn('product_id', $product_ids)->count();

        $total_orders = count($orders);
        $total_revenue = 0;
        $product_name = [];
        foreach($orders as $order){
            $total_revenue += $order->total_price;
        }
        $sales = [
            'visitors' =>  $visitors,
            'total_revenue' => number_format($total_revenue, 2),
            'total_orders' => $total_orders,
            'sales_per_order' => $total_orders > 0 ? number_format($total_revenue / $total_orders, 2) : 0,
            'conversion_rate' => $visitors > 0 ? number_format($total_orders / $visitors * 100, 2) : 0,
        ];

        $products = Product::where('seller_id' , $seller_id)->get();
        $revenuePerProduct = [];
        foreach ($products as $product) {
            $variations = $product->variations;
            $totalRevenue = 0;

            foreach ($variations as $variation) {
                $orders = $variation->orders;
                foreach ($orders as $order) {
                    $totalRevenue += $order->total_price;
                }
            }
            $revenuePerProduct[$product->product_name] = $totalRevenue;
        }

        $product_name = array_keys($revenuePerProduct);
        $revenue = array_values($revenuePerProduct);
 
        return view('seller.sales_analysis', ['sales' => $sales, 'product_name' => $product_name, 'revenue' => $revenue]);
    }

    public function seller_chat_list(){
        $seller_id = session('seller_id');
        $messages = Message::where('seller_id', $seller_id)
        ->orderBy('created_at', 'desc')
        ->get();
        $chat_list = $messages->unique('customer_id')->values();
        foreach ($chat_list as $list_item){
            $list_item->name = Customer::where('customer_id', $list_item->customer_id)->value('name');
        }

        return view('seller.chat_list', ['chat_list' => $chat_list]);
    }

    public function send_message(Request $request, $customer_id){
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $seller_id = session('seller_id');
    
        $message = Message::create([
            'customer_id' => $customer_id,
            'seller_id' => $seller_id,
            'message_text' => $request->message,
            'sender' => 'seller'
        ]);

        broadcast(new PusherBroadcast($message, $seller_id, $customer_id));

        return response()->json(['message' => $request->message]);
    }

    public function chat_with_customer($customer_id){
        $customer = Customer::find($customer_id);
        $seller_id = session('seller_id');
        $messages = Message::where('seller_id', $seller_id)
        ->where('customer_id', $customer_id)
        ->orderBy('created_at', 'asc')
        ->get();
 
        return view('seller.conversation', ['customer' => $customer, 'messages' => $messages]);
    }
}
