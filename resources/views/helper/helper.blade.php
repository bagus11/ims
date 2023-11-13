<script>
    
    function saveHelper(url,data,route){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "post",
            dataType: 'json',
            async: true,
            data: data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('.message_error').html('')
                toastr['success'](response.meta.message);
                window.location = route;
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact Developer');
                }
            }
        });
    }
    function onChange(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function onChangeSelect(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function getActiveItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    function getProductItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-uom="'+data.uom+'" data-min="'+ data.min_quantity +'" data-max="'+ data.max_quantity +'"  data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    
    function postCallback(route,data,callback){
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function postCallbackNoSwal(route,data,callback){
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function getCallback(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        beforeSend: function() {
            SwalLoading('Please wait ...');
        },
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function getCallbackNoSwal(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function selectName(route, id, name){
            $.ajax({
            url: route,
            type: "get",
            dataType: 'json',
            async: true,
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function postAttachment(route,data,withFile,callback){
        $.ajax({
                url: route,
                type: 'POST',
                type: "post",
                dataType: 'json',
                async: true,
                processData: withFile,
                contentType: withFile,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success:callback,
                error: function(response) {
                    $('.message_error').html('')
                    swal.close();
                    if(response.status == 500){
                        console.log(response)
                        toastr['error'](response.responseJSON.meta.message);
                        return false
                    }
                    if(response.status === 422){
                        $.each(response.responseJSON.errors, (key, val) => 
                            {
                                $('span.'+key+'_error').text(val)
                            });
                    }else{
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }
        });
    }



    // Case Mapping Table Item 
    function mappingTableItem(response,id){
            var data =''
                $('#'+id).DataTable().clear();
                $('#'+id).DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                            var result =response[i].item_relation == null ? response[i].quantity_result :response[i].item_relation.quantity + response[i].quantity_request
                           
                            data += `<tr style="text-align: center;">
                                        <td style="width:5%">${i + 1}</td>
                                        <td style="text-align:left; width:60%;">${response[i].item_relation == null ?response[i].item_name : response[i].item_relation.name}</td>
                                        <td style="text-align:right; width:10%;">${response[i].item_relation == null ? response[i].quantity : response[i].item_relation.quantity}</td>
                                        <td style="text-align:right; width:10%;">${response[i].quantity_request}</td>
                                        <td style="text-align:right; width:10%;">${result}</td>
                                        <td style="text-align:center; width:5%;">${response[i].item_relation == null ? response[i].uom : response[i].item_relation.uom}</td>
                                        
                                    </tr>
                                `;
                        }
                $('#'+ id +' > tbody:first').html(data);
                $('#'+id).DataTable({
                    scrollX  : true,
                }).columns.adjust()
        }
    // Case Mapping Table Item 
</script>