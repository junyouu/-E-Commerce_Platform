<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Seller_Request;
use App\Models\Seller;
use App\Models\Label;
use App\Models\Customer;
use App\Models\User;

use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index(){
        $customers = Customer::all(); 
        $sellers = Seller::all();
        return view('admin.index', ['sellers' => $sellers, 'customers' => $customers]);
    }

    public function add_category(Request $request){
        $data = $request->validate([
            'category_name' => 'required|string|max:255'
        ]);
        Category::create($data);
        return view('admin.index');
    }

    public function show_seller_request(){
        $requests = Seller_Request::where('status', 'Pending')->get();
        foreach ($requests as $request) {
            $request->seller_name = Seller::where('seller_id', $request->seller_id)->pluck('shop_name')->first();
            $request->category = Category::where('category_id', $request->category_id)->pluck('category_name')->first();
        }
        return view('admin.handle_seller_request', ['requests'=>$requests]);
    }

    public function approve_seller_request($request_id){
        $record = Seller_Request::find($request_id);
        $record->status = "Approved";
        $record->save();
        $data = [];
        $data['category_id'] = $record->category_id;
        $data['label_name'] = $record->label_name;

        $newLabel = Label::create($data);
        if($newLabel){
            return redirect(route('admin.show_seller_request'));
        }
    }

    public function reject_seller_request($request_id){
        $record = Seller_Request::find($request_id);
        $record->status = "Rejected";
        $record->save();
        return redirect(route('admin.show_seller_request'));
    }

    public function suspend_user($user_id){
        $user = User::find($user_id);
        $user->is_suspended = true;
        $user->save();
        return redirect()->back()->with('success', 'Account has been suspended.');
    }

}
