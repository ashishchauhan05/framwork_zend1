 $(document).ready(function(){
        
    });
    
    
function setDefaultImage(id,productId) {
//     alert(productId+' ,'+id);    
     
    var formData = {
                    'product_id'      : productId,
                    'id'              :id
                     }                   
                    var mbaseUrl=$('#baseUrl').attr('value');
//                    alert(mbaseUrl);
                    $.ajax({
                    type        : 'POST',
                    url         : mbaseUrl+'/ajax/change-product',
                    data        : formData,
                    dataType    : 'json',
                    encode          : true
                    }).done(function(data) {
//                        alert(data);
                if (data.success==true) 
                    {
//                     alert('success')
//                     location.reload();
                    }
                else if(data.success==false)
                    {
                    alert('Error 402!! Network error.. please try again after some time')
                    }
                }).fail(function(data)
                    {
                    console.log(data);
                    });

}

   
function deleteImage(id,productId) {
//    alert(productId+' ,'+id);    
     
    var formData = {
                    'product_id'      : productId,
                    'id'              :id
                     }                   
                    var mbaseUrl=$('#baseUrl').attr('value');
//                    alert(mbaseUrl);
                    $.ajax({
                    type        : 'POST',
                    url         : mbaseUrl+'/ajax/delete-image',
                    data        : formData,
                    dataType    : 'json',
                    encode          : true
                    }).done(function(data) {
//                        alert(data);
                if (data.success==true) 
                    {
//                     alert('success')
//                     location.reload();
                    }
                else if(data.success==false)
                    {
                    alert('Error 402!! Network error.. please try again after some time')
                    }
                }).fail(function(data)
                    {
                    console.log(data);
                    });

}
