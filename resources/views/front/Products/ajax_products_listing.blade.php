
<?php use App\Models\Product ;?>

<div class="row">
    @foreach ($categoryProducts as $product)
        <div class="col-sm-6 col-md-6 col-lg-4 ftco-animate">
            <div class="product">
                @if (isset($product['main_image']))
                    <?php $product_image_path = 'images/product_images/small/' . $product['main_image']; ?>
                @else
                    <?php $product_image_path = ''; ?>
                @endif
                @if (!empty($product['main_image']) && file_exists($product_image_path))
                    <a href="{{url('product/'.$product['id'])}}"><img src="{{ asset('images/product_images/small/' . $product['main_image']) }}" alt="" style="display: block; margin: 0 auto;"></a>
                @endif

                <div class="overlay"></div>
                <div class="text py-3 px-3">
                    <a href="{{url('product/'.$product['id'])}}"><h3>{{ $product['product_name'] }}</h3></a>
                    <?php $discounted_price = Product::getDiscountedPrice($product->id); // assign a value
                    ?>
                    <div class="d-flex">
                        <div class="pricing" style="display: inline-block;">
                            <p class="price">
                                @if($discounted_price > 0)
                                    <span class="mr-2 price-dc">{{ $product['product_price'] }} TND</span>
                                    <span class="price-sale">{{ $discounted_price }} TND</span>
                                @else
                                    <span class="price-sale">{{ $product['product_price'] }} TND</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <p class="bottom-area d-flex px-3">
                        <a href="{{url('product/'.$product['id'])}}" class="add-to-cart text-center py-2 mr-1"><span><i class="fas fa-eye"></i> View</span></a>

                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
