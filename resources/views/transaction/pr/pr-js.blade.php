<script>
    // Initialing
        var array_item =[];
    // Initialing
    // Call Function
        getCallback('getPurchase',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operational
        $('#btn_refresh').on('click', function(){
                getCallback('getPurchase',null,function(response){
                    swal.close()
                    mappingTable(response.data)
                }) 
        })
        // Add PR
            $('#btn_add_pr').on('click', function(){
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
                // getActiveItems('getLocation',null,'select_des_location','Location')
            })
            $('#select_category').on('change', function(){
                var data ={
                    'id':$('#select_location').val(),
                    'category_id':$('#select_category').val(),
                }
                getProductItems('getActiveProduct',data,'select_product','Product')
            })
            $('#select_product').on('change', function(){
                var data ={ 'id':$('#select_product').val()}
                getCallbackNoSwal('detailProduct', data, function(response){
                    $('#quantity_product').val(response.detail == null ? '': response.detail.quantity)
                    $('#quantity_product').prop('disabled',true)
                })
            })
            onChange('select_transaction_type','transaction_id')
            onChange('select_product','product_id')
            onChange('select_category','category_id')
            onChange('select_location','location_id')
            $('#quantity_request').on('change', function(){
                var max = $("#select_product").select2().find(":selected").data("max");
                var quantity_product = $('#quantity_product').val()
                var quantity_request = $('#quantity_request').val()
                var total =  parseInt(quantity_product) + parseInt(quantity_request)
                
                if(total > max){
                        toastr['warning']('quantity request is more than max quantity, max quantity is' + max);  
                        $('#quantity_request').val('')
                        return false
                }
            })
            $('#btn_add_array_item').on('click', function(){
                var item_name = $("#select_product").select2().find(":selected").data("name");
                var uom = $("#select_product").select2().find(":selected").data("uom");
                var quantity_product = $('#quantity_product').val()
                $('#btn_edit_array_item').prop('hidden', true)
                var product_id= $('#product_id').val()
                var quantity_request= $('#quantity_request').val()
               
                if(product_id =='' || quantity_request == ''){
                    toastr['error']('item and quantity cannot be null');
                    return false
                }else{
                    var test = array_item.some(el => el.item_name == item_name)
                   
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

            // Save Purchase Request
                $('#btn_save_transaction').on('click', function(){
                    if(array_item.length > 0){
                        var data ={
                            'array_item':array_item,
                            'transaction_id':$('#transaction_id').val(),
                            'location_id':$('#location_id').val(),
                            'comment':$('#comment').val(),
                            'category_id':$('#category_id').val(),
                        }
                        postCallback('savePurchase',data, function(response){
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
            // Save Purchase Request
        // Add PR

          // Detail Transaction
             $('#pr_table').on('click','.stepApproval', function(){
                    var data = {
                        'id':$(this).data('tc') ,
                        'des':$(this).data('des') ,
                    }
                   
                    getCallback('detailPurchaseTransaction',data,function(response){
                        swal.close()
                        var fileName = response.detail.attachment.split('/')
                        var attachment = ''
                        if(fileName[2] == ''){
                            attachment ='-'
                        }else{
                            attachment =` <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" style="color:blue;font-size:9.5px">
                                            <i class="far fa-file" style="color: red;font-size: 10px;"></i>
                                            ${fileName[2]} </a>`
                        }
                       
                        var status ='';
                        if(response.detail.status == 1){
                            status ='NEW'
                        }else if(response.detail.status == 2){
                            status ='On Queue'
                        }else if( response.detail.status == 3){
                            status ='On Progress'
                        }else if( response.detail.status == 4){
                            status ='DONE'
                        }else if(response.detail.status == 5){
                            status ='Reject'
                        }
                        var approverName = response.detail.approval_id == 0 ?' - ': response.detail.approval_relation.name
                        $('#detail_transaction_code').html(': '+ response.detail.request_code)
                        $('#detail_location_id').html(': '+response.detail.location_relation.name)
                        $('#detail_des_location').html(': '+response.detail.des_location_relation.name)
                        $('#detail_user_id').html(': ' + response.detail.user_relation.name)
                        $('#detail_approval_id').html(': ' + approverName )
                        $('#detail_status').html(': ' + status)
                        $('#detail_attachment').empty()
                        $('#detail_attachment').append(`: ${attachment}`)
                        $('#detail_comment').summernote('code',response.detail.remark)
                        mappingTableLog(response.log,response.count)
                        mappingTableItem(response.log_item,'detail_item_table')
                    })
            })
        // Detail Transaction

        // Update Progress
            $('#pr_table').on('click','.updateProgress', function(){
                    var data = {
                        'id':$(this).data('tc') ,
                        'des':$(this).data('des') ,
                    }
                   
                    getCallback('detailPurchaseTransaction',data,function(response){
                        swal.close()
                        var fileName = response.detail.attachment.split('/')
                        var attachment = ''
                        if(fileName[2] == ''){
                            attachment ='-'
                        }else{
                            attachment =` <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" style="color:blue;font-size:9.5px">
                                            <i class="far fa-file" style="color: red;font-size: 10px;"></i>
                                            ${fileName[2]} </a>`
                        }
                       
                        var status ='';
                        if(response.detail.status == 1){
                            status ='NEW'
                        }else if(response.detail.status == 2){
                            status ='On Queue'
                        }else if( response.detail.status == 3){
                            status ='On Progress'
                        }else if( response.detail.status == 4){
                            status ='DONE'
                        }else if(response.detail.status == 5){
                            status ='Reject'
                        }
                        var approverName = response.detail.approval_id == 0 ?' - ': response.detail.approval_relation.name
                        $('#update_transaction_code').html(': '+ response.detail.request_code)
                        $('#update_location_id').html(': '+response.detail.location_relation.name)
                        $('#update_des_location').html(': '+response.detail.des_location_relation.name)
                        $('#update_user_id').html(': ' + response.detail.user_relation.name)
                        $('#update_approval_id').html(': ' + approverName )
                        $('#update_status').html(': ' + status)
                        $('#update_attachment').empty()
                        $('#update_attachment').append(`: ${attachment}`)
                        $('#update_comment').summernote('code',response.detail.remark)
                        $('#update_transaction_id').val(response.detail.request_code)
                        mappingTableItem(response.log_item,'update_item_table')
                    })
            })
            onChange('select_update_approval_id','update_approvalId')
            $('#btn_update_progress').on('click', function(){
                var data ={
                    'id'                    : $('#update_transaction_id').val(),
                    'update_approvalId'     : $('#update_approvalId').val(),
                    'update_comment'        : $('#update_comment').val(),
                }
                postCallback('updateProgressPurchase',data,function(response){
                    swal.close();
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#updateTransacrionModal').modal('hide')
                    getCallbackNoSwal('getItemRequest',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Update Progress
        // Report
            $('#pr_table').on('click','.export',function(){
                var request_code = $(this).data('tc').replace(/\//g, "&*.")
                window.open(`print_pr/${request_code}`,'_blank');
            })
        // Report
    // Operational

    // Function
        function mappingTable(response){
            var data =''
                $('#pr_table').DataTable().clear();
                $('#pr_table').DataTable().destroy();
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
                            console.log(response[i].status)
                            if(response[i].status == 3 || response[i].status == 5){
                                if(response[i].approval_id == authId){
                                    buttonChecking = `
                                                <button title="Update Progress" class="updateProgress btn btn-sm btn-warning rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#updateTransacrionModal">
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
                            data += `<tr style="text-align: center;">
                                  
                                    <td style="text-align:center;">${response[i].request_code}</td>
                                    <td style="text-align:left;">${response[i].location_relation.name}</td>
                                    <td style="text-align:left;">${response[i].user_relation.name}</td>
                                    <td style="text-align:center;">${status}</td>
                                    <td style="">
                                            <button title="Detail" class="stepApproval btn btn-sm btn-info rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#detailTransacrionModal">
                                                <i class="fas fa-solid fa-user"></i>
                                            </button>
                                            @can('get-only_staff-item_request')
                                                ${buttonChecking}
                                                ${buttonReport}
                                            @endcan
                                    </td>
                                </tr>
                                `;
                        }
                $('#pr_table > tbody:first').html(data);
                $('#pr_table').DataTable({
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
        function mappingTableLog(response,count){
                var last_comment=''
                var data =''
                $('#ir_detail_table').DataTable().clear();
                $('#ir_detail_table').DataTable().destroy();
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
                            var status_approval =''
                            if(response[i].approval_status == 1 ){
                                status_approval = 'Approve'
                            }else if(response[i].approval_status == 2){
                                status_approval = 'Reject'
                            }else{
                                status_approval = '-'
                            }
                            const d = new Date(response[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            data += `<tr style="text-align: center;">
                                        <td style="width:5%">${date} ${time}</td>
                                        <td style="text-align:left;">${response[i].creator_relation.name}</td>
                                        <td style="text-align:left;">${status}</td>
                                        <td style="text-align:center;">${status_approval}</td>
                                    </tr>
                                `;
                            last_comment = response[i].comment
                        }
                $('#ir_detail_table > tbody:first').html(data);
                $('#ir_detail_table').DataTable({
                    scrollX  : true,
                }).columns.adjust()
             
               
        }
       
    // Function
</script>