$(document).ready(function(){
    // Check Admin Password is correct or not
    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        
        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                
                if(resp=='false'){
                    $("#chkCurrentPwd").html("<font color=red>Current Password is incorrect </font>");
                }else if(resp =='true'){
                    $("#chkCurrentPwd").html("<font color=green>Current Password is correct </font>");
                }
            },error:function(){
                alert("Error");
            }
        })
    });
    

    $(".updateSectionStatus").click(function(){
        var status=$(this).text();
        var section_id=$(this).attr("section_id");
        $.ajax({
            type:'post',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#section-"+section_id).html("<a class ='updateSectionStatus' href='javascript:void(0)'>Inactive</a>");
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<a class ='updateSectionStatus' href='javascript:void(0)'>Active</a>");
                }
            },error:function(){
                alert("Error");
            }
        })
    });
   
    $(document).on('click', '.updateCouponStatus', function(){
        var status = $(this).text();
        var coupon_id = $(this).attr("coupon_id");
        $.ajax({
            type: 'POST',
            url: '/admin/update-coupon-status',
            data: { status: status, coupon_id: coupon_id },
            success: function(resp){
                if(resp['status'] == 0){
                    $("#coupon-"+coupon_id).html("<a class='updateCouponStatus' id='coupon-"+coupon_id+"' coupon_id='"+coupon_id+"' href='javascript:void(0)'>Inactive</a>");
                } else if(resp['status'] == 1){
                    $("#coupon-"+coupon_id).html("<a class='updateCouponStatus' id='coupon-"+coupon_id+"' coupon_id='"+coupon_id+"' href='javascript:void(0)'>Active</a>");
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log("Error: " + textStatus + " - " + errorThrown);
            }
        });
    });
    
     
    $(".updatecategoryStatus").click(function(){
        var status=$(this).text();
        var c_id=$(this).attr("c_id");
        $.ajax({
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,c_id:c_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#c-"+c_id).html("<a class ='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>");
                }else if(resp['status']==1){
                    $("#c-"+c_id).html("<a class ='updateCategoryStatus' href='javascript:void(0)'>Active</a>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
    //Append Categories Level
// Append Categories Level
$('#sid').change(function(){
    var sid = $(this).val();
    $.ajax({
        type:'post',
        url:'/admin/append-categories-level',
        data:{sid:sid},
        success:function(resp){
            $("#appendCategoriesLevel").html(resp);
        },error:function(){
            alert("Error");
        }
    });
});

$(document).on("click", ".confirmDelete", function() {
    var record = $(this).data("record");
    var recordid = $(this).data("recordid");
    if (confirm("Are you sure you want to delete this " + record + "?")) {
        window.location.href = "/admin/delete-" + record + "/" + recordid;
    }
});


 


$(".updateProductStatus").click(function(){
    var status=$(this).text();
    var product_id=$(this).attr("product_id");
    $.ajax({
        type:'post',
        url:'/admin/update-product-status',
        data:{status:status,product_id:product_id},
        success:function(resp){
            if(resp['status']==0){
                $("#product-"+product_id).html("<a class ='updateProductStatus' href='javascript:void(0)'>Inactive</a>");
            }else if(resp['status']==1){
                $("#product-"+product_id).html("<a class ='updateProductStatus' href='javascript:void(0)'>Active</a>");
            }
        },error:function(){
            alert("Error");
        }
    })
});
$(".updateAttributeStatus").click(function(){
    var status=$(this).text();
    var attribute_id=$(this).attr("attribute_id");
    $.ajax({
        type:'post',
        url:'/admin/update-attribute-status',
        data:{status:status,attribute_id:attribute_id},
        success:function(resp){
            if(resp['status']==0){
                $("#attribute-"+attribute_id).html("Inactive");
            }else if(resp['status']==1){
                $("#attribute-"+attribute_id).html("Active");
            }
        },error:function(){
            alert("Error");
        }
    })
});
$(document).on('click', '.updateSubscriberStatus', function () {
    var status = $(this).text();
    var subscriber_id = $(this).attr('subscriber_id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/update-subscriber-status',
        data: {status: status, subscriber_id: subscriber_id},
        success: function (resp) {
            if (resp.status == 0) {
                $('#subscriber-' + subscriber_id).html('InActive');
            } else if (resp.status == 1) {
                $('#subscriber-' + subscriber_id).html('Active');
            }
        },
        error: function () {
            alert('Error');
        }
    });
});
    //products attributes add/remove script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div style="height:10px;"><input type="text" name="size[]" placeholder="Size" style="width:120px"  /><input type="text" name="sku[]" style="width:120px" placeholder="SKU"/><input type="text" name="price[]" style="width:120px" placeholder="Price"/><input type="text" name="stock[]" style="width:120px" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    $(document).on("click", ".updateBannerStatus", function () {
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
          type: "post",
          url: "/admin/update-banner-status",
          data: { status: status, banner_id: banner_id },
          success: function (resp) {
            if (resp["status"] == 0) {
              $("#banner-" + banner_id).html(
                "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
              );
            } else if (resp["status"] == 1) {
              $("#banner-" + banner_id).html(
                "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
              );
            }
          },
          error: function () {
            alert("Error");
          },
        });
      });
      $(document).on('click', '.updateUserStatus', function () {
        var status = $(this).text();
        var user_id = $(this).attr('user_id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-user-status',
            data: {status: status, user_id: user_id},
            success: function (resp) {
                if (resp.status == 0) {
                    $('#user-' + user_id).html('InActive');
                } else if (resp.status == 1) {
                    $('#user-' + user_id).html('Active');
                }
            },
            error: function () {
                alert('Error');
            }
        });
    });
    
    

      // Show Hide Coupon Field for Manual/Automatic
      $("#ManualCoupon").click(function(){
        $("#couponField").show();
      });
      $("#AutomaticCoupon").click(function(){
        $("#couponField").hide();
      });
      $('#datamask').inputmask('dd/mm/yyyy',{'placeholder':'dd/mm/yyyy'})
      $('#datamask2').inputmask('mm/dd/yyyy',{'placeholder':'mm/dd/yyyy'})
      $('[data-mask]').inputmask()


     
});


