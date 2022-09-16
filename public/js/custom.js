$(document).ready(function(){
    // Dev:Ashish Mehra
    // get Store name by vendor id
    let baseUrl = $("#url").val();
    $("#vendorName").on('change', function(){
        let userId = $(this).val();
       
       
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
    let selectedOptions = [];
    let obj = {};
    $("#addOption").click(function(){
       
        optName = $("#optionName").val();
       if(optName !== ''){
        allOption.push(optName);
        selectedOptions.push(optName);
        $.each(selectedOptions , function(index, value){     
            $('.optionSpan').append(value);
        });
        selectedOptions=[];
        console.log(allOption);
        $("#optionError").text("");  
        
       }else{
        $("#optionError").text("Please select option first!");   
       }
        
    });
   

    $("#createVariant").click( function(){
        
        attrName = $("#attributeName").val();
        optionName = $("#optionName").val();
        if(attrName !== '' && optionName !== ''){
            variants.push({
                attr_name: attrName,
                attr_option:allOption
            });
           
            obj[attrName] = allOption;  
            console.log(JSON.stringify(obj));
          
            
          
            allOption=[];
     
            $("#variantsValue").val(JSON.stringify(obj));
            $.each(variants , function(index, value){
            
               
                 let html = "<tr> <td><label class='ms-checkbox-wrap'><input type='checkbox' value=''><i class='ms-checkbox-check'></i></label></td><td>"+value.attr_name+"</td><td><div class='size_small position-relative'>"+value.attr_option+"<span class='close_white'><a href=''><img src='"+baseUrl+"public/assets/img/close_white_cross.svg' alt=''></a></span></div></td></tr>";
                $("#combination").append(html);
                

            });
            variants=[];
        }else{
            if(attrName === "")
            {
                $("#attrError").text("Please select Attribute first");
            }
            if(optionName === "")
            {
                $("#optionError").text("Please select Option first");
            }
            
        }
        

        
    
    
});

$(".advance_btn").click( function(){
  
    let isVariant = $("#variant_product").val();
    (isVariant==='1')? $("#variant_product").val("2"): $("#variant_product").val("1");
});

// multiple photo preview
// Dev:Ashish Mehra
            const newLocal = "image-input";
            let inputLocalFont = document.getElementById(newLocal);

            inputLocalFont.addEventListener("change",previewImages,false); //bind the function to the input

            function previewImages(){
                var fileList = this.files;
            
                var anyWindow = window.URL || window.webkitURL;

                    for(var i = 0; i < fileList.length; i++){
                    //get a blob to play with
                    var objectUrl = anyWindow.createObjectURL(fileList[i]);
                    // for the next line to work, you need something class="preview-area" in your html
                    $('.preview-area').append(' <li><div class="more_infromation position-relative"><img src="' + objectUrl + '" width="50px" height="50px"/><span></span> </div></li>');
                    // get rid of the blob
                    window.URL.revokeObjectURL(fileList[i]);
                    }

            }



});

    // eNTER ONLY NUMERIC VALUE
    // Dev:Ashish Mehra
    function AllowOnlyNumbers(e) {
        e = (e) ? e : window.event;
        var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
        var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
        var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);
        
        return (/^\d+$/.test(str));
        }

// cODE for accept vendor request
// Dev: Ashish Mehra

    $(document).ready(function(){
        $(".vendor-status").click(function(){
            let vendorId = $(this).attr('data-id');
            let vendorStatus = $(this).attr('data-status');
            let baseUrl = $('meta[name="baseUrl"]').attr('content');
            
          
            $.ajax({

                url:baseUrl+'admin/vendor/vendor-account',
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            
                data:{'vendor_id':vendorId, 'vendor_status':vendorStatus },
                success:function(data){
                    location.reload();
                }
               
            });

        });

    });

// cODE for accept and reject vendor product
// Dev: Ashish Mehra

$(document).ready(function(){



    $(".product-status").click(function(){
        let productId = $(this).attr('data-product-id');
        let productStatus = $(this).attr('data-product-status');
        let baseUrl = $('meta[name="baseUrl"]').attr('content');
        const newLocal = 'admin/product/status';
        $.ajax({
            url:baseUrl+newLocal,
            type:'POST',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{'product_id': productId, 'product_status': productStatus},
            success:function(data){
                location.reload();
            }
        });

    });

// delete product image
// Dev: aSHISH mEHRA

$(".delete-image").click(function(){
    let productId = $(this).parent().attr('data-image-id');
    let imageKey = $(this).parent().attr('data-image-key');
    // alert(productId+' '+ imageKey);
});


// Code: Edit product advance and normal product hide & show button


  $("#edit-advance_btn").click(function(){
    $(".advice_block").toggle();
  });







});



