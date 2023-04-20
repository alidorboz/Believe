<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" />
    <title>Invoice</title>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{ asset('images/front_images/LOGO1.jpeg') }}">
        </div>
        <h1>Order # {{ $orderDetails['id'] }}</h1>
        <br>
        <span class="pull-right">
            <?php echo DNS1D::getBarcodeHTML( $orderDetails['id'],'C39'); ?>
        </span>
        <div id="company" class="clearfix">
            <div>Believe</div>

            <div><a href="mailto:contact@believe.com">contact@believe.com</a></div>
        </div>
        <div id="project">
            <div><span>CLIENT</span>{{ $userDetails['name'] }}</div>
            <div><span>ADDRESS</span>{{ $userDetails['address'] }} </div>
            
            <div><span>PINCODE</span>{{ $userDetails['pincode'] }} </div>
            <div><span>MOBILE</span>{{ $userDetails['mobile'] }} </div>
            <div><span>ORDER DATE</span>{{ $orderDetails['created_at'] }} </div>


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
            <tbody>
                @php $subTotal=0; @endphp
                @foreach ($orderDetails['orders_products'] as $product)
                    <tr>
                        <td>Name: {{$product['product_name']}}
                            Code: {{$product['product_code']}}
                            Size: {{$product['product_size']}}
                            Color: {{$product['product_color']}}
                            <?php echo DNS1D::getBarcodeHTML( $product['product_code'],'C39'); ?>

                        </td>
                        <td class="unit"> {{$product['product_price']}} TND</td>
                        <td class="qty"> {{$product['product_qty']}}</td>
                        <td class="total"> {{$product['product_price']*$product['product_qty'] }} TND</td>
                    </tr>
                    @php $subTotal = $subTotal + ($product['product_price']*$product['product_qty']) @endphp
                @endforeach
                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total">{{$subTotal}} TND</td>
                  </tr>
                  @if ($orderDetails['coupon_amount']>0)
                  <tr>
                    <td colspan="4">DISCOUNT</td>
                    <td class="total">{{$orderDetails['coupon_amount']}} TND</td>
                  </tr>
                  @endif
                  <tr>
                    <td colspan="4">DELIVERY</td>
                    <td class="total">7 TND</td>
                  </tr>
                  <tr>
                    <td colspan="4" class="grand total">GRAND TOTAL</td>
                    <td class="grand total">{{$orderDetails['grand_total']}} TND</td>
                  </tr>

            </tbody>
        </table>
        
        <div id="notices">

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
                    width: 21cm;
                    height: 29.7cm;
                    margin: 0 auto;
                    color: #001028;
                    background: #FFFFFF;
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    font-family: Arial;
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
