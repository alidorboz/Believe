<?php use App\Models\Cart;
use App\Models\Product;
?>
@php
    $delivery_tax = 7;
@endphp



<table class="table">
    <thead class="thead-primary">
        <tr class="text-center">
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>Product</th>
            <th>Price</th>
            <th>Category/Product <br> Discount</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_price = 0; 
        foreach ($userCartItems as $item) {
            $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']); 
            $item_total = $attrPrice['final_price'] * $item['quantity']; 
            $total_price += $item_total;
        ?>
        <tr class="text-center">
            <td class="product-remove">
                <button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $item['id'] }}"
                    style="background-color: #dc3545; color: #fff; border-color: #dc3545; border-radius: .25rem; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; text-align: center; text-decoration: none; display: inline-block; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; vertical-align: middle; -webkit-appearance: none; -moz-appearance: none; appearance: none;">
                    <i></i>
                </button>
            </td>
            <td class="image-prod">
                <img src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}" width="100%">
            </td>
            <td class="product-name">
                <h3>{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})</h3>
                <p>Color : {{ $item['product']['product_color'] }}</p>
                <p>Size : {{ $item['size'] }}</p>
            </td>
            <td class="price">{{ $attrPrice['product_price']*$item['quantity'] }} TND</td>
            <td class="price">{{ $attrPrice['discount']*$item['quantity'] }} TND</td>
            <td class="quantity">
                <span class="input-group-btn mr-2">
                    <button type="button" class="quantity-left-minus btn" data-cartid="{{ $item['id'] }}"
                        onclick="updateQuantity(-1, this)">
                        <i class="ion-ios-remove">-</i>
                    </button>
                </span>
                <input type="text" id="quantity_{{ $item['id'] }}" name="quantity"
                    class="form-control input-number" value="{{ $item['quantity'] }}" min="1" max="100">
                <span class="input-group-btn ml-2">
                    <button type="button" class="quantity-right-plus btn" data-cartid="{{ $item['id'] }}"
                        onclick="updateQuantity(1, this)">
                        <i class="ion-ios-add">+</i>
                    </button>
                </span>
            </td>
            <script>
                function updateQuantity(delta, button) {
                    let quantityInput = document.getElementById(`quantity_${button.dataset.cartid}`);
                    let quantity = parseInt(quantityInput.value);
                    quantity += delta;
                    if (quantity < 1) quantity = 1;
                    if (quantity > 100) quantity = 100;
                    quantityInput.value = quantity;
                    let cartid = button.dataset.cartid;
                    $.ajax({
                        data: {
                            "cartid": cartid,
                            "qty": quantity
                        },
                        url: '/update-cart-item-qty',
                        type: 'post',
                        success: function(resp) {
                            $("#AppendCartItems").html(resp.view);
                            $(".totalCartItems").html(resp.totalCartItems); // update total number of items
                        },
                        error: function() {
                            alert("Error");
                        }
                    }).done(function() {
                        // Refresh the cart after updating the quantity
                        location.reload();
                    });
                }
            </script>
            



            <td class="total">{{ $item_total }} TND</td>
        </tr><!-- END TR-->
        <?php } ?>



    </tbody>
</table>
@if (Session::has('success_message'))
    <div class='alert alert-success' role='alert'>
        {{ Session::get('success_message') }}
        <button type="button" class="close"data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    <?php Session::forget('success_message'); ?>
@endif
@if (Session::has('error_message'))
    <div class='alert alert-danger' role='alert'>
        {{ Session::get('error_message') }}
        <button type="button" class="close"data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    <?php Session::forget('error_message'); ?>

@endif
</div>
</div>
</div>
<div class="row justify-content-center">
    <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
            <h3>Cart Totals</h3>
            <p class="d-flex">
                <span>Subtotal</span>
                <span>{{ $total_price }} TND</span>
            </p>
            <p class="d-flex">
                <span>Delivery</span>
                <span>{{ $delivery_tax }} TND</span>
            </p>

            <p class="d-flex">
                <span>Coupon Discount</span>
                <span class="couponAmount">
                    @if (Session::has('couponAmount'))
                        {{ Session::get('couponAmount') }} TND
                    @else
                        0 TND
                    @endif

                </span>
            </p>
            <hr>
            <p class="d-flex total-price">
                <span>Total</span>
                <span
                    class="grand_total">{{ $total_price + $delivery_tax - (Session::has('couponAmount') ? Session::get('couponAmount') : 0) }}
                    TND</span>
            </p>


        </div>

    </div>
</div>