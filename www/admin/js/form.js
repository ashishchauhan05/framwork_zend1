

     function getSubCategory(th) {

        var mbaseUrl=$('#baseUrl').attr('value');
        var catId = $('#menuId').val();
        // console.log(catId);
        // $('#mid').val(catId);
       
        var data = {
            parent_id : catId
        }

        $.ajax({
            url: mbaseUrl+'/part-request/sub-category',
            type: 'POST',
            data: data,
            success:function(data) {
                var data = $.parseJSON(data); 
                var selectbox = '';
                if(data.status==200)
                {

                    selectbox = '<label class="col-md-3 control-label" style="color:#333;font-size:18px;">Sub Menu</label>';

                    selectbox += '<div class="col-md-9">';
                    selectbox += '<select class="form-control select"  onchange="getSubSubCategory(this)" id="subid">';
                    selectbox += '<option>choose sub menu</option>';
                    $.each(data.result, function (i, item) {

                        selectbox += '<option value="'+item.sid+'">'+item.sub_menu+'</option>';
                    });

                    selectbox += '</select><span class="help-block">Select sub category</span></div>';
                    
                }
                $('#subCat').html(selectbox);
            }
        });
          
    }
    
    function getSubSubCategory(th) {

        var mbaseUrl=$('#baseUrl').attr('value');
        var subMenuId = $('#subid').val();
        // console.log(subMenuId);
        var data = {
            parent_id : subMenuId
        }
       
        $.ajax({
            url: mbaseUrl+'/part-request/category',
            type: 'POST',
            data: data,
            success:function(data) {
                var data = $.parseJSON(data); 
                var selectbox = '';
                if(data.status==200)
                {

                    selectbox = '<label class="col-md-3 control-label" style="color:#333;font-size:18px;">Category</label>';

                    selectbox += '<div class="col-md-9">';
                    selectbox += '<select class="form-control select" id="catId">';
                    selectbox += '<option>choose category</option>';
                    $.each(data.result, function (i, item) {

                        selectbox += '<option value="'+item.cid+'">'+item.category+'</option>';
                    });

                    selectbox += '</select><span class="help-block">Select product category</span></div>';
                    
                }
                $('#subSubCat').html(selectbox);
            }
        });
          
    }   
});