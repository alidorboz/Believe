<?php

namespace App\Http\Controllers\Front;

use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\OrdersProduct;
use App\Models\ProductsAttributes;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Session;
use App\Models\Order;
//use App\Models\OrdersProduct;
use DB;
use App\Models\SMS;


class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                //echo "Category exists"; die;
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])->
                    where('status', 1);
                    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                        if ($_GET['sort'] == 'product_latest') {
                            $categoryProducts->orderBy('id', 'Desc');
                        } else if ($_GET['sort'] == 'product_name_a_z') {
                            $categoryProducts->orderBy('product_name', 'Asc');
                        } else if ($_GET['sort'] == 'product_name_z_a') {
                            $categoryProducts->orderBy('product_name', 'Desc');
                        } else if ($_GET['sort'] == 'price_lowest') {
                            $categoryProducts->orderBy('product_price', 'Asc');
                        } else if ($_GET['sort'] == 'price_highest') {
                            $categoryProducts->orderBy('product_price', 'Desc');
                        } else if ($_GET['sort'] == 'discounted_price') {
                            $categoryProducts->orderByRaw('(CASE WHEN product_discount > 0 THEN (product_price - (product_price * product_discount/100)) ELSE product_price END) ASC');
                        }
                    }
                    
                $categoryProducts = $categoryProducts->paginate(6);
                return view('front.Products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }
        }
    }
    public function detail($id)
    {
        $product = Product::with([
            'category',
            'attributes' => function ($query) {
                $query->where('status', 1);
            },
            'images'
        ])->find($id);

        if (!$product) {
            // product not found
            abort(404);
        }

        $productDetails = $product->toArray();
        $total_stock = ProductsAttributes::where('product_id', $id)->sum('stock');
        $relatedProducts = Product::where('category_id', '!=', $productDetails['category']['id'])
                    ->inRandomOrder()
                    ->limit(3)
                    ->get()
                    ->toArray();
        $groupProducts = [];
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id', 'main_image','product_color')
                                ->where([
                                    'group_code' => $productDetails['group_code'],
                                    'status' => 1
                                ])
                                ->where('id', '!=', $id)
                                ->get()
                                ->toArray();
        }
        return view('front.Products.detail', compact('productDetails', 'total_stock', 'relatedProducts', 'groupProducts'));
        
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            //echo "<pre>"; print_r($data);die;

            $getDiscountAttrPrice = Product::getDiscountAttrPrice($data['product_id'], $data['size']);

            return $getDiscountAttrPrice;
        }
    }
    public function addtocart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $message = '';
        
        

            // Check if size is provided
            if (empty($data['size'])) {
                $message = "Please select a size";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            // Check Product Stock is available or not 
            $getProductStock = ProductsAttributes::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first();
            if (empty($getProductStock)) {
                $message = "Selected size is not available for this product";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            if ($getProductStock['stock'] < $data['quantity']) {
                $message = "Required Quantity is not available";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            // Generate Session ID if not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            // Check product id already exists in User Cart
            if (Auth::check()) {
                // User is logged in
                $countProducts = Cart::where([
                    'product_id' => $data['product_id'],
                    'size' => $data['size'],
                    'user_id' => Auth::user()->id
                ])->count();
            } else {
                // User is not logged in 
                $countProducts = Cart::where([
                    'product_id' => $data['product_id'],
                    'size' => $data['size'],
                    'session_id' => Session::get('session_id')
                ])->count();
            }

            if ($countProducts > 0) {
                $message = "Product already exists in cart";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 0;
            }
            //Save Product in Cart
            //Cart::insert(['session_id'=>$session_id,'product_id'=>$data['product_id'],'size'=>$data['size'],'quantity'=>$data['quantity']]);


            $cart = new Cart;

            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = "Product has been added in Cart";
            session::flash('success_message', $message);
            return redirect('cart');
        }
    }

    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        //echo "<pre>";print_r($userCartItems);die;
        return view('front.Products.cart')->with(compact('userCartItems'));
    }
    public function updateCartItemQty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $cartDetails = Cart::find($data['cartid']);
            $availableStock = ProductsAttributes::select('stock')->where([
                'product_id' =>
                $cartDetails['product_id'],
                'size' => $cartDetails['size']
            ])->first()->toArray();
            if ($data['qty'] > $availableStock['stock']) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product is not available',
                    'view' => (String) View::make('front.Products.cart_items')->with(compact('
                    userCartItems'))
                ]);
            }
            $availableSize = ProductsAttributes::where([
                'product_id' => $cartDetails['product_id'],
                'size' => $cartDetails['size'],
                'status' => 1
            ])->count();
            if ($availableSize == 0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => true,
                    'view' => (String) View::make('front.Products.cart_items')->with(
                        compact(
                            'userCartItems'
                        )
                    )
                ]);
            }
            Cart::where('id', $data['cartid'])->update(['quantity' => $data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json(['status' => true, 'totalCartItems' => $totalCartItems, 'view' => (String) View::make('front.Products.cart_items')->with(compact('userCartItems'))]);
        }
    }

    public function deleteCartItem(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Cart::where('id', $data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            return response()->json(['view' => (String) View::make('front.Products.cart_items')->with(compact('userCartItems'))]);
        }
    }
    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $userCartItems = Cart::userCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                $userCartItems = Cart::userCartItems();
                $totalCartItems = totalCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon is not valid!',
                    'totalCartItems' => $totalCartItems,
                    'view' => (String) View::make('front.Products.cart_items')->with(compact('userCartItems'))
                ]);

            } else {
                //get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                //Check if coupon is expired 
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if ($expiry_date < $current_date) {
                    $message = 'This coupon is expired!';
                }
                // check if coupon is inactive
                if ($couponDetails->status == 0) {
                    $message = 'This coupon is inactive';
                }



                if ($couponDetails->coupon_type = "Single Time") {
                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();
                    if ($couponCount >= 1) {
                        $message = "This coupon code is Already used by you";
                    }
                }







                //Check if coupon is from selected categories
                //get all selected categories from coupon
                $catArr = explode(",", $couponDetails->categories);

                //Get cart items
                $userCartItems = Cart::userCartItems();

                //check if any item belong to coupon category

                //check if code belongs to logged in user
                //Get all selected users of coupon 
                if (!empty($couponDetails->users)) {
                    $userAttr = explode(",", $couponDetails->users);

                    foreach ($userAttr as $key => $user) {
                        $getUserID = User::select('id')->where('email', $user)->first()->toArray();
                        $userID[] = $getUserID['id'];
                    }
                }

                // Get cart total amount
                $total_amount = 0;
                foreach ($userCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = 'This coupon code is not for one of the selected products !';
                    }
                    if (!empty($couponDetails->users)) {
                        if (!in_array($item['user_id'], $userID)) {
                            $message = 'This coupon code is not for you!';
                        }
                    }
                    $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                if (isset($message)) {
                    $userCartItems = Cart::userCartItems();
                    $totalCartItems = totalCartItems();

                    return response()->json([
                        'status' => false,
                        'message' => $message,

                        'totalCartItems' => $totalCartItems,

                        'view' => (String) View::make('front.Products.cart_items')->with(compact('userCartItems'))
                    ]);
                } else {
                    //Check if amount type is fixed or percentage
                    if ($couponDetails->amount_type == "Fixed") {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }
                    $delivery_tax = 4;
                    $grand_total = $total_amount + $delivery_tax - $couponAmount;
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "Coupon applied successfully!";
                    $totalCartItems = totalCartItems();
                    $userCartItems = Cart::userCartItems();
                    return response()->json([
                        'status' => true,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'view' => (String) View::make('front.Products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }
        }
    }
    public function checkout(Request $request)
    {
        $userCartItems = Cart::userCartItems();
        if (count($userCartItems) == 0) {
            $message = "Shopping Cart is empty! Please add products";
            Session::put('error_message', $message);
            return redirect('cart');
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($userCartItems as $key => $cart) {
                $product_status = Product::getProductStatus($cart['product_id']);
                if ($product_status == 0) {
                    Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_code'] . " is not available so remove it from cart";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }
                $product_stock = Product::getProductStock($cart['product_id'], $cart['size']);
                if ($product_stock == 0) {
                    Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_code'] . " is not available so remove it from cart";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }

                $getAttributeCount = Product::getAttributeCount($cart['product_id'],$cart['size']);
                if ($getAttributeCount == 0) {
                    Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_code'] . " is not available so remove it from cart";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }
                $category_status=Product::getCategoryStatus($cart['product']['category_id']);
                if ($category_status == 0) {
                    Product::deleteCartProduct($cart['product_id']);
                    $message = $cart['product']['product_code'] . " is not available so remove it from cart";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }
            }


            if (empty($data['address_id'])) {
                $message = "Please select a Delivery Address";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            if (empty($data['payment_gateway'])) {
                $message = "Please select a Payement Method";
                session::flash('error_message', $message);
                return redirect()->back();

            }
            if ($data['payment_gateway'] == "CashOnDelivery") {
                $payment_method = "CashOnDelivery";
            } else {
                echo "Coming Soon";
                die;
                $payment_method = "Prepaid";

            }
            //Get delivery address from address_id
            $deliveryAddresses = DeliveryAddress::where('id', $data['address_id'])->first()
                ->toArray();
            //dd($deliveryAddresses);die;
            DB::beginTransaction();
            //insert order details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddresses['name'];
            $order->address = $deliveryAddresses['address'];
            $order->governorate = $deliveryAddresses['governorate'];
            $order->delegation = $deliveryAddresses['delegation'];
            $order->mobile = $deliveryAddresses['mobile'];
            $order->pincode = $deliveryAddresses['pincode'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = 0;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();
            //Get last order id
            $order_id = DB::getPdo()->lastInsertId();
            //get user cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach ($cartItems as $key => $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountedAttrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
                if ($data['payment_gateway'] == "CashOnDelivery") {
                    $getProductStock = ProductsAttributes::where(['product_id' => $item['product_id'], 'size' => $item['size']])->first()->toArray();
                    $newStock = $getProductStock['stock'] - $item['quantity'];
                    ProductsAttributes::where(['product_id' => $item['product_id'], 'size' => $item['size']])->update(['stock' => $newStock]);
                }

            }

            //Empty the user cart
            Cart::where('user_id', Auth::user()->id)->delete();
            //Insert order id in session variable
            Session::put('order_id', $order_id);
            DB::commit();
            if ($data['payment_gateway'] == "CashOnDelivery") {
                //Send Order SMS
                $message = "Dear Customerm, your order" . $order_id . "has been successfully
                placed with Believe.";
                $mobile = Auth::user()->mobile;
                SMS::sendSms($message, $mobile);
                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
                //Send Order E-Mail
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails,
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed -- Believe');
                });

                return redirect('/thanks');
            } else {
                echo "Prepaid Method Coming Soon";
                die;
            }
            echo "Order placed";
            die;
        }



        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        return view('front.Products.checkout')->with(compact('userCartItems', 'deliveryAddresses'));
    }
    public function thanks()
    {
        if (Session::has('order_id')) {
            //Empty the user cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.Products.thanks');
        } else {
            return redirect('/cart');
        }


    }
    public function addEditDeliveryAddress($id = null, Request $request)
    {
        if ($id == "") {
            $title = "Add Delivery Address";
            $address = new DeliveryAddress;
            $message = "Delivery Address added successfully";
        } else {
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            $message = "Deleivery Address updateted successfully";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'address' => 'required',
                'governorate' => 'required',
                'delegation' => 'required',
                'pincode' => 'required',

                'mobile' => 'required',
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'mobile.required' => 'Mobile is Required',
                'governorate.required' => 'Governorate is Required',
                'delegation.required' => 'Delegation is Required',
                'pincode.required' => 'Pincode is Required',

                'address.required' => 'Address is required',
            ];
            $this->validate($request, $rules, $customMessages);
            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->governorate = $data['governorate'];
            $address->delegation = $data['delegation'];
            $address->mobile = $data['mobile'];
            $address->pincode = $data['pincode'];
            $address->save();
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('checkout');
        }

        return view('front.Products.add_edit_delivery_address')->with(compact('title', 'address'));
    }
    public function deleteDeliveryAddress($id)
    {
        DeliveryAddress::where('id', $id)->delete();
        $message = "Delivery Address deletetd successfully";
        Session::put('success_message', $message);
        return redirect()->back();
    }
}