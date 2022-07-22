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


    // Dev: Ashish Mehra
    let attrName, optName;
    let allOption = [];
    let attributeCombination=[];
    let variants = [];

    $("#addOption").click(function(){

        optName = $("#optionName").val();
        allOption.push(optName);
        console.log(allOption);
    });
   

    $("#createVariant").click( function(){
        
        attrName = $("#attributeName").val();
        if(attrName !== ''){
            variants.push({
                attr_name: attrName,
                attr_option:allOption
            });
            console.log(variants);
            allOption=[];
          console.log(variants);
            $.each(variants , function(index, value){
                let html = "<tr> <td><label class='ms-checkbox-wrap'><input type='checkbox' value=''><i class='ms-checkbox-check'></i></label></td><td>"+value.attr_name+"</td></tr>";
                $("#combination").append(html);
                  
                // $.each(value.attr_option, function(key, val){
                   
                //    const abc=`<tr><div class='size_small position-relative'>${val}<span class='close_white'><a href=''><img src='' alt=''></a></span></div></tr>`;
                //    console.log(abc);
                //     $("#combination").append(abc);
                // });

            });
            variants=[];
        }else{
            $("#attrError").text("Please select Attribute first");
        }
        
    
    
    });
    





});