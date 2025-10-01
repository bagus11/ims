<script>
        getActiveItems('getLocation',null,'location_filter','Office')
        getActiveItems('getUser',null,'reqFilter','PIC')
        var dataStart = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
            'location_filter' : $('#location_filter').val(),
            'reqFilter' : $('#reqFilter').val(),
        }
        getCallback('getItemRequest', dataStart, function(response){
            swal.close()        
            mappingTable(response.data)
        })
        $('#btn_filter').on('click', function(){
            var data = {
                'from' : $('#from').val(),
                'to' : $('#to').val(),
                'location_filter' : $('#location_filter').val(),
                'reqFilter' : $('#reqFilter').val(),
            }
            getCallback('getItemRequest',data,function(response){
                swal.close()
                mappingTable(response.data)
            }) 
        })
        $('#btn_refresh').on('click', function(){
            getCallback('getItemRequest',dataStart,function(response){
                swal.close()
                mappingTable(response.data)
            }) 
        })
        var array_item =[];
        $(document).ready(function() {
            $('#addRequestModal').on('shown.bs.modal', function () {
                $('#select_product').select2({
                    dropdownParent: $('#addRequestModal'),
                    dropdownCssClass: 'selectOption2'
                });
            });
          
           
        });
        var array_item =[];
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });
        $('#btn_add_request').on('click',function(){
            array_item = []
            array_item.length = 0
            if(array_item.length == 0){
                toastr['info']('array is clear')
            }else{
                toastr['danger']('error, please contact ICT DEV')

            }
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
            $('#category_id').val('')
            $('#location_id').val('')
            $('#quantity_request').val('')
            $('#des_location_id').val('')
            getActiveItems('getLocation',null,'select_location','Location')
            getActiveItems('getActiveCategory',null,'select_category','Category')
            $('#addRequestModal').modal({backdrop: 'static', keyboard: false})  
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
            getCallbackNoSwal('detailProduct', data, function(response){
                console.log(response)
                $('#quantity_product').val(response.detail == null ? '': response.detail.quantity)
                $('#quantity_product').prop('disabled',true)
                $('.label_uom').html(response.detail?.uom)
            })
        })
        $('#quantity_request').on('change', function(){
            var min = $("#select_product").select2().find(":selected").data("min");
            var quantity_product = $('#quantity_product').val()
            var quantity_request = $('#quantity_request').val()
            var select_transaction_type = $('#select_transaction_type').val()
            if(select_transaction_type !== 3){
                var total =  parseInt(quantity_product) - parseInt(quantity_request)
            }else{
                var total =  parseInt(quantity_product) + parseInt(quantity_request)
            }
            console.log(select_transaction_type + total + ' == ' + min + ' == ' +quantity_product + ' == ' + quantity_request)
            if(total <= min){
                if(total <=  min){
                    if(total < 0){
                        if(select_transaction_type == 2){
                            return
                        }else{
                            $('#quantity_request').val('')
                            toastr['error']('quantity is not enough, please contact admin');  
                            return false
                        }
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
                    var comment = $('#comment').val()
                    if(comment == '' || comment == null){
                        toastr['error']('Comment is required')
                    }else{
                        if(array_item.length > 0){
                            var data ={
                                'array_item':array_item,
                                'transaction_id':$('#transaction_id').val(),
                                'location_id':$('#location_id').val(),
                                'comment':$('#comment').val(),
                                'category_id':$('#category_id').val(),
                            }
                            postCallback('addMultipleTransaction',data, function(response){
                                $('.message_error').html('');
                                swal.close()
                                toastr['success'](response.meta.message);
                                $('#addRequestModal').modal('hide')
                                array_item = []
                                getCallbackNoSwal('getItemRequest',null,function(response){
                                    mappingTable(response.data)
                                })
                            })
                        }else{
                            toastr['error']('item and quantity cannot be null');
                            return false;
                        }
                    }
                
                })
            $('#request_table').on('click', '.stepApproval', function(){
                        var data = {
                        'id':$(this).data('tc') ,
                        'des':$(this).data('des') ,
                    }
                   
                    getCallback('detailTransaction',data,function(response){
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
                            status ='Partialy Approve'
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
                        // $('#detail_product').html(': '+response.detail.item_relation.name)
                        // $('#detail_quantity_request').html(': '+response.detail.quantity_request+ ' ' + response.detail.item_relation.uom)
                        $('#detail_user_id').html(': ' + response.detail.user_relation.name)
                        $('#detail_approval_id').html(': ' + approverName )
                        $('#detail_status').html(': ' + status)
                        $('#detail_attachment').empty()
                        $('#detail_attachment').append(`: ${attachment}`)
                        $('#detail_comment').summernote('code', response.detail.remark);
                        mappingTableLog(response.log,response.count)
                        if(response.detail.item_relation == null){
                            mappingTableItem(response.detail.purchase_relation,'detail_item_table')
                        }else{
                            var result = 0;
                           
                           if(response.detail.request_type != 2){
                               result = parseInt(response.detail.item_relation.quantity) - parseInt(response.detail.quantity_request)
                           }else{
                               result = parseInt(response.detail.item_relation.quantity) + parseInt(response.detail.quantity_request)
                           }
                          
                           var array_push =[]
                           var data ={
                               'item_name' : response.detail.item_relation.name,
                               'quantity' : response.detail.purchase_relation.quantity,
                               'quantity_request' : response.detail.purchase_relation.quantity_request,
                               'quantity_result' : response.detail.purchase_relation.quantity_final,
                               'uom' : response.detail.item_relation.uom,
                           }
                           array_push.push(data)
                           mappingTableItem(array_push,'detail_item_table')
                           
                        }
                    })
            })
            $('#request_table').on('click','.updateProgress', function(){
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
                            status ='Partialy Approve'
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
                $('#btn_update_progress').prop('disabled', true)
                var data ={
                    'id'                    : $('#update_transaction_id').val(),
                    'update_approvalId'     : $('#update_approvalId').val(),
                    'update_comment'        : $('#update_comment').val(),
                }
                postCallback('updateProgressMultiple',data,function(response){
                    swal.close();
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#updateProgressModal').modal('hide')
                    getCallbackNoSwal('getItemRequest',null,function(response){
                        mappingTable(response.data)
                    })
                    $('#btn_update_progress').prop('disabled', false)
                })
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
                                    status = 'Partialy Approve'
                                }else if(response[i].step == 2){
                                    status = 'Partialy Approve'
                                }else if(response[i].step == 3){
                                    status = 'Partialy Approve'
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
                                        const d = new Date(response[i].created_at);
                                        const date = d.toISOString().split('T')[0];
                                        const time = d.toTimeString().split(' ')[0];
                                        var dateTime = date + ' ' + time

                                    data += `<tr style="text-align: center;">
                                          
                                            <td style="text-align:center;">${dateTime}</td>
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
                                    status = 'Partialy Approve'
                                }else if(response[i].step == 2){
                                    status = 'Partialy Approve'
                                }else if(response[i].step == 3){
                                    status = 'Partialy Approve'
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
                var table = $('#ir_detail_table').DataTable({
                    scrollX  : false,
                }).columns.adjust()
                autoAdjustColumns(table)
               
        }

    // Function
</script>