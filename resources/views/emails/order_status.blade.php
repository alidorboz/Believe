<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>

<body>
    <table style="width:700px; margin: 0 auto;">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><img src="{{ $message->embed(public_path() . '/images/front_images/LOGO1.jpeg') }}"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Hello {{ $name }},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Thank you for joining us.</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Your Order is {{$order_status}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Order no: {{ $order_id }}</td>
        </tr>
    </table>
    <table style="width:700px; margin: 0 auto; border-collapse: collapse;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 8px; text-align: left;">Product Name</th>
                <th style="padding: 8px; text-align: left;">Product Code</th>
                <th style="padding: 8px; text-align: left;">Product Size</th>
                <th style="padding: 8px; text-align: left;">Product Color</th>
                <th style="padding: 8px; text-align: left;">Product Quantity</th>
                <th style="padding: 8px; text-align: left;">Product Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails['orders_products'] as $product)
                <tr>
                    <td style="padding: 8px;">{{ $product['product_name'] }}</td>
                    <td style="padding: 8px;">{{ $product['product_code'] }}</td>
                    <td style="padding: 8px;">{{ $product['product_size'] }}</td>
                    <td style="padding: 8px;">{{ $product['product_color'] }}</td>
                    <td style="padding: 8px;">{{ $product['product_qty'] }}</td>
                    <td style="padding: 8px;">{{ $product['product_price'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="padding: 8px; text-align: right;">Shipping Charges</td>
                <td style="padding: 8px;">7 TND</td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 8px; text-align: right;">Coupon Discount</td>
                <td style="padding: 8px;">
                    @if ($orderDetails['coupon_amount'] > 0)
                        {{ $orderDetails['coupon_amount'] }}
                    @else
                        0
                    @endif TND
                </td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 8px; text-align: right;">Grand Total </td>
                <td style="padding: 8px;">{{ $orderDetails['grand_total'] }} TND</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Believe E-Commerce Website</td>
            </tr>
    </table>
</body>

</html>
