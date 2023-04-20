$(document).ready(function () {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#sort").on('change', function () {
        this.form.submit();
    });
    /* $("#sort").on('change',function(){
        var sort = $(this).val();
        var url = $("#url").val();
        $.ajax({
            url:url,
            method:"post",
            data:{sort:sort,url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    }); */
    $("#getPrice").change(function () {
        var size = $(this).val();
        if (size == "") {
            alert("Please select Size");
            return false;
        }
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: '/get-product-price',
            data: {
                size: size,
                product_id: product_id
            },
            type: 'post',
            success: function (resp) {

                if (resp['discount'] > 0) {
                    $(".getAttrPrice").html("<del>" + resp['product_price'] + " TND</del>" + " " + resp['final_price'] + " TND");
                } else {
                    $(".getAttrPrice").html(resp['product_price'] + " TND");

                }
            },
            error: function () {
                alert("Error");
            }
        })
    });

    $(document).ready(function () { // Delete Cart Items
        $(document).on('click', '.btnItemDelete', function () {
            var cartid = $(this).data('cartid');
            var result = confirm("Want to delete this cart Item");
            if (result) {
                $.ajax({
                    data: {
                        "cartid": cartid
                    },
                    url: '/delete-cart-item',
                    type: 'post',
                    success: function (resp) {
                        $("#AppendCartItems").html(resp.view);
                    },
                    error: function () {
                        alert("Error");
                    }
                });
            }

        });
    });
    
    $().ready(function () { // validate the comment form when it is submitted
        $("#commentForm").validate();

        // validate signup form on keyup and submit
        $("#registerForm").validate({
            rules: {
                name: "required",
                mobile: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                    digits: true
                },


                email: {
                    required: true,
                    email: true,
                    remote: "check-email"
                },
                password: {
                    required: true,
                    minlength: 6
                }


            },
            messages: {
                name: "Please enter your name",
                mobile: {
                    required: "Please enter your Mobile",
                    minlength: "Your mobile must consist  8 digits",
                    maxlength: "Your mobile must consist 15 digits",
                    digits: "Please enter a valid phone number"

                },
                email: {
                    required: "Please enter your Email",
                    email: "Please enter a valid Email",
                    remote: "Email already exists"

                },
                password: {
                    required: "Please Choose a password",
                    minlength: "Your password must be at least 5 characters long"
                }


            }
        });
        $("#loginForm").validate({
            rules: {


                email: {
                    required: true,
                    email: true,
                    // remote:"check-email"
                },
                password: {
                    required: true,
                    minlength: 6
                }


            },
            messages: {
                name: "Please enter your name",

                email: {
                    required: "Please enter your Email",
                    email: "Please enter a valid Email"


                },
                password: {
                    required: "Please Choose a password",
                    minlength: "Your password must be at least 5 characters long"
                }


            }
        });


    });
    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                accept: "[a-zA-Z]"
            },
            mobile: {
                required: true,
                minlength: 8,
                maxlength: 15,
                digits: true
            }


        },
        messages: {
            name: {
                required: "Please enter your name",
                accept: "Please enter a valid name"
            },
            mobile: {
                required: "Please enter your Mobile",
                minlength: "Your mobile must consist  8 digits",
                maxlength: "Your mobile must consist 15 digits",
                digits: "Please enter a valid phone number"

            }


        }
    });

    $("#current_password").keyup(function () {
        var current_password = $(this).val();
        $.ajax({
            type: 'post',
            url: '/check-user-pwd',
            data: {
                current_password: current_password
            },
            success: function (resp) { // alert(resp);
                if (resp == "false") {
                    $("#chkPwd").html("<font color ='red'>Current Password is Incorrect</font>");
                } else if (resp == "true") {
                    $("#chkPwd").html("<font color ='green'>Current Password is Correct</font>");
                }
            },
            error: function () {
                alert("Error");
            }
        })
    });

    $("#passwordForm").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: "#new_password"
            }


        }

    });
    $("#ApplyCoupon").submit(function () {
        var user = $(this).attr("user");
        if (user == 1) {} else {
            alert("Please login to apply coupon");
            return false;
        }
        var code = $("#code").val();

        $.ajax({
            type: "post",
            data: {
                code: code
            },
            url: '/apply-coupon',
            success: function (resp) {
                if (resp.message != "") {
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#AppendCartItems").html(resp.view);
                if (resp.couponAmount >= 0) {
                    $(".couponAmount").text(resp.couponAmount + " TND");

                } else {
                    $(".couponAmount").text("0 TND");
                }
                if (resp.couponAmount >= 0) {
                    $(".grand_total").text(resp.grand_total + " TND");
                } 

            },
            error: function () {
                alert("Error");
            }

        })
    });  

    $(document).on('click','.addressDelete',function(){
        var result= confirm("Want to delete this address");
        if($result){
            return false;
        }
    });

});
function addSubscriber(){
    var subscriber_email = $("#subscriber_email").val();
    $.ajax({
        type:'post',
        url:'/add-subscriber-email',
        data:{subscriber_email:subscriber_email},
        success:function(resp){
            if(resp=="exists"){
                alert("Subscriber email already exists");
            }else if(resp=="inserted"){
                alert("Thanks for subscribing");
            }
        },error:function(){
            alert("Error");
        }
    });
}
