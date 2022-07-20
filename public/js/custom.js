$(document).ready(function(){
    // Dev:Ashish Mehra
    // get Store name by vendor id
    $("#vendorName").on('change', function(){
        let userId = $(this).val();
        let baseUrl = $("#url").val();
        // alert(baseUrl);
        $.ajax({
            url:baseUrl+'admin/view/store/by/id',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            data:{'id':userId},
            success:function(data){
                console.log(data);
                if($.isEmptyObject(data)){
                    $('#storeName').html("<option value=''>Store not found</option>");    
                }else{
                    $.each(data, function( index, value ) {
                        $('#storeName').append("<option value="+value.id+">"+value.name+"</option>");    
                    });
                }
                
            }
            
        });
        
    });

    // close

    // get subcategories by categoryId

    $("#categories").on('change', function(){
        let categoryId = $(this).val();
        let baseUrl = $("#url").val();
        // alert(baseUrl);
        $.ajax({
            url:baseUrl+'admin/view/subcategories/by/id',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            data:{'id':categoryId},
            success:function(data){
                console.log(data);
                if($.isEmptyObject(data)){
                    $('#subCategory').html("");    
                }else{
                    $.each(data, function( index, value ) {
                       
                        const newLocal = "<option>Select Sub-category</option><option value=" + value.id + ">" + value.title + "</option>";
                        $('#subCategory').append(newLocal);    
                    });
                }
                
            }
            
        });
        
    });


});