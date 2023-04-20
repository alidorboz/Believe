<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ordersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersLog;
use App\Models\OrderStatus;
use App\Models\SMS;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
class OrdersController extends Controller
{
    public function orders(){
        Session::put('page','orders');
        $orders=Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.orders')->with(compact('orders'));
    }
    public function orderDetails($id){
        $orderDetails=Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails= User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses=OrderStatus::where('status',1)->get()->toArray();
        $orderLog=OrdersLog::where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }
    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            //Update Order Status
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Order Status has been updated successfully');
            
            $deliveryDetails= Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
           
            $message="Dear Customer your order".$data['order_id']." is shipped ";
            $mobile =$deliveryDetails['mobile'];
            SMS::sendSms($message,$mobile);
            $message="Dear Customerm, your order".$data['order_id']."has been successfully
            placed with Believe.";
            $email=$deliveryDetails['email'];
            SMS::sendSms($message,$mobile);
            $orderDetails= Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            //Send Order E-Mail
            $email=$deliveryDetails['email'];
            $messageData=[
                'email'=>$email,
                'name'=>$deliveryDetails['name'],
                'order_id'=>$data['order_id'],
                'order_status'=>$data['order_status'],
                'orderDetails'=>$orderDetails,
            ];
            Mail::send('emails.order_status',$messageData,function($message) use ($email){
                $message->to($email)->subject('Order Status Updated -- Believe');
            });
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();
            return redirect()->back();
        }
    }
    public function viewOrderInvoice($id){
        $orderDetails=Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails=User::where('id',$orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));

    }
    public function printPDFInvoice($id) {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        
        $output = '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" media="all">
            <title>Invoice</title>
        </head>
        
        <body>
            <header class="clearfix">
                
                <h1>Order # ' . $orderDetails['id'] . '</h1>
                <br>
              
                <div id="company" class="clearfix">
                    <div>Believe</div>
    
                    <div><a href="mailto:contact@believe.com">contact@believe.com</a></div>
                </div>
                <div id="project">
                    <div><span>CLIENT</span>' . $userDetails['name'] . '</div>
                    <div><span>ADDRESS</span>' . $userDetails['address'] . ' </div>
                    
                    <div><span>PINCODE</span>' . $userDetails['pincode'] . ' </div>
                    <div><span>MOBILE</span>' . $userDetails['mobile'] . '</div>
                    <div><span>ORDER DATE</span>' . $orderDetails['created_at'] . ' </div>
    
    
                </div>
            </header>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
                    $subTotal = 0;
                    foreach ($orderDetails['orders_products'] as $product) {
                        $output .= '<tr>
                            <td>Name: ' . $product['product_name'] . '
                                Code: ' . $product['product_code'] . '
                                Size: ' . $product['product_size'] . '
                                Color: ' . $product['product_color'] . '
    
                            </td>
                            <td class="unit">' . $product['product_price'] . ' TND</td>
                            <td class="qty">' . $product['product_qty'] . '</td>
                            <td class="total">' . ($product['product_price'] * $product['product_qty']) . ' TND</td>
                        </tr>';
                        
                        $subTotal += $product['product_price'] * $product['product_qty'];
                    }
                    
                    $output .= '<tr>
                        <td colspan="3">SUBTOTAL</td>
                        <td class="total">' . $subTotal . ' TND</td>
                    </tr>';
                    
                    if ($orderDetails['coupon_amount'] > 0) {
                        $output .= '<tr>
                            <td colspan="3">DISCOUNT</td>
                            <td class="total">' . $orderDetails['coupon_amount'] . ' TND</td>
                        </tr>';
                        $subTotal -= $orderDetails['coupon_amount'];
                    }
                    
                    $output .= '<tr>
                        <td colspan="3">DELIVERY</td>
                        <td class="total">7 TND</td>
    
                          </tr>';
                    $output.='      <tr>
                            <td colspan="4" class="grand total">GRAND TOTAL</td>
                            <td class="grand total">'.$orderDetails['grand_total'].' TND</td>
                          </tr>
        
                    </tbody>
                </table>';
                
                $output.='<div id="notices">
        
                    <style>
                    .clearfix:after {
                        content: "";
                        display: table;
                        clear: both;
                    }
        
                    a {
                        color: #5D6975;
                        text-decoration: underline;
                    }
        
                    body {
                        position: relative;
                        width: 19cm;
                        height: 27cm;
                        margin: 0 auto;
                        color: #001028;
                        background: #FFFFFF;
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                    }
        
                    header {
                        padding: 10px 0;
                        margin-bottom: 30px;
                    }
        
                    #logo {
                        text-align: center;
                        margin-bottom: 10px;
                    }
        
                    #logo img {
                        width: 90px;
                    }
        
                    h1 {
                        border-top: 1px solid #5D6975;
                        border-bottom: 1px solid #5D6975;
                        color: #5D6975;
                        font-size: 2.4em;
                        line-height: 1.4em;
                        font-weight: normal;
                        text-align: center;
                        margin: 0 0 20px 0;
                        background: url(dimension.png);
                    }
        
                    #project {
                        float: left;
                    }
        
                    #project span {
                        color: #5D6975;
                        text-align: right;
                        width: 52px;
                        margin-right: 10px;
                        display: inline-block;
                        font-size: 0.8em;
                    }
        
                    #company {
                        float: right;
                        text-align: right;
                    }
        
                    #project div,
                    #company div {
                        white-space: nowrap;
                    }
        
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        border-spacing: 0;
                        margin-bottom: 20px;
                    }
        
                    table tr:nth-child(2n-1) td {
                        background: #F5F5F5;
                    }
        
                    table th,
                    table td {
                        text-align: center;
                    }
        
                    table th {
                        padding: 5px 20px;
                        color: #5D6975;
                        border-bottom: 1px solid #C1CED9;
                        white-space: nowrap;
                        font-weight: normal;
                    }
        
                    table .unit {
                        background-color: #DDD;
                    }
        
                    table .total {
                        background-color: #DDD;
                        font-weight: bold;
                    }
        
                    .center {
                        text-align: center;
                    }
        
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            border-spacing: 0;
                            margin-bottom: 20px;
                        }
        
                        table tr:nth-child(2n-1) td {
                            background: #F5F5F5;
                        }
        
                        table th,
                        table td {
                            text-align: center;
                        }
        
                        table th {
                            padding: 5px 20px;
                            color: #5D6975;
                            border-bottom: 1px solid #C1CED9;
                            white-space: nowrap;
                            font-weight: normal;
                        }
        
                        table .service,
                        table .desc {
                            text-align: left;
                        }
        
                        table td {
                            padding: 20px;
                            text-align: right;
                        }
        
                        table td.service,
                        table td.desc {
                            vertical-align: top;
                        }
        
                        table td.unit,
                        table td.qty,
                        table td.total {
                            font-size: 1.2em;
                        }
        
                        table td.grand {
                            border-top: 1px solid #5D6975;
                            ;
                        }
        
                        #notices .notice {
                            color: #5D6975;
                            font-size: 1.2em;
                        }
        
                        footer {
                            color: #5D6975;
                            width: 100%;
                            height: 30px;
                            position: absolute;
                            bottom: 0;
                            border-top: 1px solid #C1CED9;
                            padding: 8px 0;
                            text-align: center;
                        }
                    </style>
        </body>
        
        </html>
        ';
        
        
        $dompdf= new Dompdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('landscape');
        $dompdf->render();
        $dompdf->stream();





        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));

    }
    public function exportOrders(){
        return Excel::download(new ordersExport,'orders.xlsx');
    }
}
