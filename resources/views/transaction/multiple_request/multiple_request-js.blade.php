<script>
        getCallback('getItemRequest', null, function(response){
            swal.close()        
            mappingTable(response.data)
        })
        $('#btn_refresh').on('click', function(){
            getCallback('getPurchase',null,function(response){
                swal.close()
                mappingTable(response.data)
            }) 
        })
        var array_item =[];
        $('#btn_add_request').on('click',function(){
            var array_item =[];
            $('#btn_edit_array_item').prop('hidden', true)
            $('#itemListContainer').prop('hidden',true)
            $('#select_category').prop('disabled', false)
            $('#select_location').prop('disabled', false)
            $('.message_error').html('')
            $('#quantity_product').val('')
            $('#transaction_id').val('')
            $('#select_transaction_type').val('').trigger('change')
            $('#select_product').empty()
            $('#select_product').append('<option value="">Choose Source Location First</option>')
            $('#product_id').val('')
            $('#location_id').val('')
            $('#quantity_request').val('')
            $('#des_location_id').val('')
            getActiveItems('getLocation',null,'select_location','Location')
            getActiveItems('getActiveCategory',null,'select_category','Category')
        })
        onChange('select_transaction_type','transaction_id')
        onChange('select_location','location_id')
        onChange('select_category','category_id')
        onChange('select_product','product_id')
        $('#select_category').on('change', function(){
            var data ={
                'id':$('#select_location').val(),
                'category_id':$('#select_category').val(),
            }
            getProductItems('getActiveProduct',data,'select_product','Product')
        })
        $('#select_product').on('change', function(){
            var data ={ 'id':$('#select_product').val()}
            // var uom = $("#select_product").select2().find(":selected").data("uom");
            // $('.label_uom').html(uom)
            getCallbackNoSwal('detailProduct', data, function(response){
                $('#quantity_product').val(response.detail == null ? '': response.detail.quantity)
                $('#quantity_product').prop('disabled',true)
            })
        })
        $('#quantity_request').on('change', function(){
            var min = $("#select_product").select2().find(":selected").data("min");
            var quantity_product = $('#quantity_product').val()
            var quantity_request = $('#quantity_request').val()
            var total =  parseInt(quantity_product) + parseInt(quantity_request)
            console.log(total + ' == ' + min + ' == ' +quantity_product + ' == ' + quantity_request)
            if(total <= min){
                if(total <=  min){
                    if(total < 0){
                        $('#quantity_request').val('')
                        toastr['error']('quantity is not enough, please contact admin');  
                        return false
                    }else{
                        toastr['warning']('quantity is low, please review your item balances');  
                    }
                }
                
            }
        })
        $('#btn_add_array_item').on('click', function(){
                $('#btn_add_array_item').prop('disabled', true)
                var item_name = $("#select_product").select2().find(":selected").data("name");
                var uom = $("#select_product").select2().find(":selected").data("uom");
                var quantity_product = $('#quantity_product').val()
                $('#btn_edit_array_item').prop('hidden', true)
                var product_id= $('#product_id').val()
                var quantity_request= $('#quantity_request').val()
                console.log(product_id + '==' + quantity_request)
                if(product_id =='' || quantity_request == ''){
                    toastr['error']('item and quantity cannot be null');
                    $('#btn_add_array_item').prop('disabled', false)
                    return false

                }else{
                    var test = array_item.some(el => el.item_name == item_name)
                    $('#btn_add_array_item').prop('disabled', false)
                    if(test == true){
                        toastr['error']('item is already exist');
                        return false
                    }else{
                        var post_array ={
                            'item_name'         : item_name,
                            'quantity_request'  : quantity_request,
                            'product_id'        : product_id,
                            'uom'               : uom,
                            'current_quantity'  : quantity_product
                        }
                        array_item.push(post_array)
                        mappingArrayTable(array_item)
                    }
                }
            })
         // Edit Array Table
         $('#itemListTable').on('click', '.editListItem', function(){
                $('#btn_edit_array_item').prop('hidden', false)
                $('#btn_add_array_item').prop('hidden', true)
                var id = $(this).data("id");
                $('#itemArrayId').val(id)
                $('#select_product').val(array_item[id].product_id)
                $('#select_product').select2().trigger('change')
                $('#quantity_request').val(array_item[id].quantity_request)
                $('#quantity_product').val(array_item[id].current_quantity)
               
            });
            $('#btn_edit_array_item').on('click', function(){
                $('#btn_edit_array_item').prop('hidden', true)
                $('#btn_add_array_item').prop('hidden', false)
                var id = $('#itemArrayId').val()
                var item_name = $("#select_product").select2().find(":selected").data("name");
                var uom = $("#select_product").select2().find(":selected").data("uom");
                array_item[id].item_name = item_name
                array_item[id].uom = uom
                array_item[id].product_id = $('#product_id').val()
                array_item[id].quantity_request = $('#quantity_request').val()
                array_item[id].quantity_product = $('#quantity_product').val()
                mappingArrayTable(array_item)

            })
            // Edit Array Table

            // Delete Array Table
                $('#itemListTable').on('click','.deleteListItem', function(){
                    var id = $(this).data("id");
                    $('#btn_edit_array_item').prop('hidden', true)
                    $('#btn_add_array_item').prop('hidden', false)
                    array_item.splice(id,1)
                    mappingArrayTable(array_item)
                })
            // Delete Array Table

            $('#btn_save_transaction').on('click', function(){
                    if(array_item.length > 0){
                        var data ={
                            'array_item':array_item,
                            'transaction_id':$('#transaction_id').val(),
                            'location_id':$('#location_id').val(),
                            'comment':$('#comment').val(),
                            'category_id':$('#category_id').val(),
                        }
                        postCallback('addMultipleTransaction',data, function(response){
                            swal.close()
                            $('.message_error').html('');
                            $('#addPrModal').modal('hide')
                            toastr['success'](response.meta.message);
                            getCallback('getPurchase',null,function(res){
                                swal.close()
                                mappingTable(res.data)
                            })
                        })
                    }else{
                        toastr['error']('item and quantity cannot be null');
                        return false;
                    }
                
                })
    // Function
        function mappingTable(response){
            var data =''
                $('#request_table').DataTable().clear();
                $('#request_table').DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                            var status ='';
                            if(response[i].status == 1){
                                status ='NEW'
                            }else if(response[i].status == 2){
                                if(response[i].step == 1){
                                    status = 'On Queue 1'
                                }else if(response[i].step == 2){
                                    status = 'On Queue 2'
                                }else if(response[i].step == 3){
                                    status = 'On Queue 3'
                                }
                            }else if( response[i].status == 3){
                                status ='On Progress'
                            }else if( response[i].status == 4){
                                status ='Checking'
                            }else if(response[i].status == 5){
                                status ='Revision'
                            }else if(response[i].status == 6){
                               if(response[i].checking == 1){
                                    status ='Checking'
                               }else{
                                    status ='DONE'
                               }
                            }else if(response[i].status == 7){
                                status ='Reject'
                            }
                            var buttonChecking = ''
                            if(response[i].status == 3 || response[i].status == 5){
                                var authId = $('#authId').val()
                                if(response[i].approval_id == authId){
                                    buttonChecking = `
                                                <button title="Update Progress" class="updateProgress btn btn-sm btn-warning rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#updateProgressModal">
                                                    <i class="fas fa-solid fa-edit"></i>
                                                </button>
                                    `;
                                }
                            }
                            buttonReport = `
                            <button title="Export PDF" class="export btn btn-sm btn-success rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}">
                                                <i class="fas fa-solid fa-file"></i>
                                            </button>
                                `;
                                if(response[i].request_type != 4){
                                    data += `<tr style="text-align: center;">
                                          
                                            <td style="text-align:center;">${response[i].request_code}</td>
                                            <td style="text-align:left;">${response[i].user_relation.name}</td>
                                            <td style="text-align:left;">${response[i].location_relation.name}</td>
                                            <td style="text-align:center;">${status}</td>
                                            <td style="">
                                                    <button title="Detail" class="stepApproval btn btn-sm btn-info rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#detailTransacrionModal">
                                                        <i class="fas fa-solid fa-user"></i>
                                                    </button>
                                                    @can('get-only_staff-item_request')
                                                        ${buttonChecking}
                                                    @endcan
                                                    ${buttonReport}
                                            </td>
                                        </tr>
                                        `;
                                }
                        }
                $('#request_table > tbody:first').html(data);
                $('#request_table').DataTable({
                    scrollX  : true,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                    ordering : false
                }).columns.adjust()
        }
        function mappingArrayTable(response){
            var data =''
                $('#itemListTable').DataTable().clear();
                $('#itemListTable').DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                           
                            data += `<tr style="text-align: center;">
                                  
                                    <td style="text-align:center;">${i + 1}</td>
                                    <td style="text-align:left;width:50%">${response[i].item_name}</td>
                                    <td style="text-align:center;">${response[i].current_quantity}</td>
                                    <td style="text-align:center;">${response[i].quantity_request}</td>
                                    <td style="text-align:center;">${response[i].uom}</td>
                                    <td style ="text-align:center">
                                        <button class="btn btn-sm btn-info editListItem" data-id ="${i}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteListItem" data-id ="${i}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                     
                                    </td>
                                </tr>
                                `;
                        }
                $('#itemListTable > tbody:first').html(data);
                $('#itemListTable').DataTable({
                    scrollX  : false,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                    ordering : false
                }).columns.adjust()
              
                $('#quantity_product').val('')
                $('#quantity_request').val('')
                $('#select_product').val('')
                $('#select_product').select2().trigger('change')
                $('#select_category').prop('disabled', true)
                $('#select_location').prop('disabled', true)
                $('#itemListContainer').prop('hidden',false)
        }
    // Function
</script>