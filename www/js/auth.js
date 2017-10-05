  

$(document).ready(function(e) {
   
    var mbaseUrl=$('#baseUrl').attr('value');
   // alert(baseUrl);
    $('#myModal').on('show.bs.modal', function (event) {
        
  var button = $(event.relatedTarget); // Button that triggered the modal
  var recipient = button.data('whatever');
  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content.
  //  We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this); 
  modal.find('.modal-title').text('New message to ' + recipient);
  modal.find('.modal-body input').val(recipient);

});

});

 
$(function() {
    
    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

    $("form").submit(function () {
        switch(this.id) {
            
            case "login-form":
                var $lg_username=$('#login_username').val();
                var $lg_password=$('#login_password').val();
                 var formData = {
                    'email'             : $lg_username,
                    'password'          : $lg_password
			
                 };
            if ($lg_username == "ERROR") {
                msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "Login error");
            } else {
                 
                var mbaseUrl=$('#baseUrl').attr('value');
                $.ajax({
                  type        : 'POST',
                  url         : mbaseUrl+'/index/login',
                  data        : formData,
                  dataType    : 'json',
                  encode          : true
                }).done(function(data) {
//                   alert(data.message);
            if (data.success==true) 
            {
             msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", data.message);
            
              if (typeof $.cookie('user_cart') == 'undefined') {

                } else {
                     var arr =  $.parseJSON( $.cookie('user_cart'));
                   
                    var arr2 =  $.parseJSON( $.cookie('cart_data'));
                  
                    $.each(arr2,function(key,value){
                         addToCart(value.product_id,true);
                    });

                    var cookies = $.cookie();
                    for(var cookie in cookies) { 
                        if(cookie == 'user_cart' || cookie == 'cart_data') {
                             $.cookie(cookie, '', { path: '/' });
                             $.removeCookie(cookie);
                        }
                       console.log('d',cookie);
                    }
                    // $.cookie('user_cart', '', { path: '/' });
                    // $.cookie('cart_data', '', { path: '/' });

                }
             location.reload();
            }
            else if(data.success==false)
            {
              msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", data.message);
            }
            }).fail(function(data)
            {
//                alert('fail'+data);
                console.log(data);
            });

                    
                }
                return false;
                break;
            case "lost-form":
                var $ls_email=$('#lost_email').val();
                if ($ls_email == "ERROR") {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "error", "glyphicon-remove", "Send error");
                } else {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "success", "glyphicon-ok", "Send OK");
                }
                return false;
                break;
                
            case "register-form":
                
                var register_name=$('#register_name').val();
                var rg_phone=$('#register_phone').val();
                var rg_email=$('#register_email').val();
                var rg_password=$('#register_password').val();
                
                  var formData = {
                    'name'           : register_name,
                    'email'          : rg_email,
                    'password'       : rg_password,
                    'phone'          : rg_phone
			
                    };
                    
                    var mbaseUrl=$('#baseUrl').attr('value');
                    $.ajax({
                    type        : 'POST',
                    url         : mbaseUrl+'/index/register',
                    data        : formData,
                    dataType    : 'json',
                    encode          : true
                    }).done(function(data) {
                if (data.success==true) 
                    {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  data.message);                   
                    location.reload();

                    }
                else if(data.success==false)
                    {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  data.message);
                    }
                }).fail(function(data)
                    {
                    console.log(data);
                    });
                
                
                return false;
                break;
                
        }
        
    });
    
    $('#login_register_btn').click( function () { modalAnimate($formLogin, $formRegister) });
    $('#register_login_btn').click( function () { modalAnimate($formRegister, $formLogin); });
    $('#login_lost_btn').click( function () { modalAnimate($formLogin, $formLost); });
    $('#lost_login_btn').click( function () { modalAnimate($formLost, $formLogin); });
    $('#lost_register_btn').click( function () { modalAnimate($formLost, $formRegister); });
    $('#register_lost_btn').click( function () { modalAnimate($formRegister, $formLost); });
    
    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
    
    function msgFade ($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function() {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }
    
    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function() {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
  		}, $msgShowTime);
    }
});

var count=1;
var min_length = 1;
var start=0;
function emailcheck() {
	var email=$('#register_email').val();
       
        if(!(email.indexOf('@')==-1))
            {
                start=1;
            }
        if(start==1){
           
	var keyword = $('#register_email').val();
	if (keyword.length >= min_length) {
             var mbaseUrl=$('#baseUrl').attr('value');
		$.ajax({
			url: mbaseUrl+'/index/emailcheck',
			type: 'POST',
			data: {keyword:keyword },
			success:function(data)
                      {
			count=data;
			if(count==1)
			{
//                        msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  "email already exists");
                       $('#s_email').html("email not available");
                       $("#s_email").focus().css({ "color": "#FF1F2E"});
                       $('#submit').prop('disabled', true);
				
			}if(count==0){
//                      msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  "email available");
                        $("#s_email").focus().css({ "color": "#rgb(19, 183, 8)"});
                        $('#s_email').html("email available");
                        $('#submit').prop('disabled', false);
			}
                    }
		});
	} else {
		$('#s_email').hide();
	}
        }
}
 //=========================================phone verification
 
 
var pcount=1;
var pmin_length = 9;
var pstart=0;
function phonecheck() {
	
	var keyword = $('#register_phone').val();
        
	if (keyword.length >= pmin_length) {
             var mbaseUrl=$('#baseUrl').attr('value');
		$.ajax({
			url: mbaseUrl+'/index/phonecheck',
			type: 'POST',
			data: {keyword:keyword },
			success:function(data)
                      {
			pcount=data;
			if(pcount==1)
			{
//                        msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  "email already exists");
                        $('#s_mobile').html("Number already registered");
                       $("#s_mobile").focus().css({ "color": "#FF1F2E"});
                       $('#submit').prop('disabled', true);
				
			}if(pcount==0){
//                      msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok",  "email available");
                        $("#s_mobile").focus().css({ "color": "#rgb(19, 183, 8)"});
//                        $('#s_mobile').html("number available");
                        $('#submit').prop('disabled', false);
			}
                    }
		});
	} else {
		$('#s_phone').hide();
	}
        
}

$('.social-strip .dropdown').hover(function() {
  
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});

//function to add prduct to cart 

function addToCart(productId, showAlert) {
     var formData = {
                    'productId'      : productId
                     }  
                     

                     var mbaseUrl=$('#baseUrl').attr('value');

                    $.ajax({
                    type        : 'POST',
                    url         : mbaseUrl+'/ajax/add-to-cart',
                    data        : formData,
                    dataType    : 'json',
                    encode          : true
                    }).done(function(data) {
                if (data.success==true) 
                    {
                    if(showAlert) {

                    }
                    else {
                          alert('Product added to cart')
                     location.reload();
                    }
                   
                    }
                else if(data.success==false)
                    {
                    alert('Error !! please login to continue..')
                    }
                }).fail(function(data)
                    {
                    console.log(data);
                    });
}
function addToCookieCart(productId) {

    var formData = {'productId' : productId };

    var mbaseUrl=$('#baseUrl').attr('value');
    // var productData;

    $.ajax({
        type        : 'POST',
        url         : mbaseUrl+'/ajax/get-product-detail',
        data        : formData,
        dataType    : 'json',
        encode          : true
        }).done(function(data) {
           var  productData = {
            product_id   :data.id,
            product_name : data.product_name,
            image : data.image,
            quantity : 1,
            unit_price : data.unit_price,
            discount : data.discount
           };
             if (typeof $.cookie('user_cart') == 'undefined' || !$.cookie('user_cart')) {
                var arr = [productData];
                var arr2 = [productId];
                // arr[productId] = productData;
                $.cookie('user_cart',  JSON.stringify(arr2), { expires: 365, path: '/' });
                $.cookie('cart_data', JSON.stringify(arr), { expires: 365, path: '/' })
                console.log(arr,arr2);
                $('.count_alert').html('1');
            } else {
                var arr =  $.parseJSON( $.cookie('user_cart'));
                 var arr2 =  $.parseJSON( $.cookie('cart_data'));
                if (($.inArray(productId, arr) == -1)) {
                    arr.push(productId);
                    arr2.push(productData);
                    $.cookie('user_cart', JSON.stringify(arr), { expires: 365, path: '/' });
                     $.cookie('cart_data', JSON.stringify(arr2), { expires: 365, path: '/' });
                     $('.count_alert').html(arr.length);
                     console.log(arr,arr2);
                }
            }
        });

}

function removeCookieCart(key) {

     // $scope.selectedTaxes.splice(key,1);

     if (typeof $.cookie('user_cart') == 'undefined' || !$.cookie('user_cart')) {
           
            } else {
                var arr =  $.parseJSON( $.cookie('user_cart'));
                 var arr2 =  $.parseJSON( $.cookie('cart_data'));

              
                    arr.splice(key,1);
                    arr2.splice(key,1);
                    $.cookie('user_cart', JSON.stringify(arr));
                     $.cookie('cart_data', JSON.stringify(arr2));
                     $('.count_alert').html(arr.length);
                     // console.log(arr,arr2);
                      location.reload();
            }
}

function setDefaultImage(){
    alert();
}
