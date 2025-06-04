<script>
    //Call Function
    var data_first ={
        'location+id' : $('#select_location_filter').val()
    }
        getCallback('getProductDashboard',data_first,function(response){
            swal.close()
            mappingTable(response.data)
        })
        getCallback('getAssignment',null,function(response){
            swal.close()
            mappingTableAssignment(response.data)
        })
        var dataDashboard = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
        getCallback('getHistoryProductDashboard',dataDashboard,function(response){
            swal.close()
            mappingTableStock(response.data)
        })
        getCallbackNoSwal('getFinalizeItem', null, function(response){
            mappingTableFinal(response.data)
        })
        $('#select_location_filter').on('change', function(){
            var data = {
                'location_id' : $('#select_location_filter').val()
            }
            getCallback('getProductDashboard',data,function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    //Call Function

    // Operation
        $('#from').on('change', function(){
            var data = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
            getCallbackNoSwal('getHistoryProductDashboard',data,function(response){
                swal.close()
                mappingTableStock(response.data)
            })
        })
        $('#to').on('change', function(){
            var data = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
            getCallbackNoSwal('getHistoryProductDashboard',data,function(response){
                swal.close()
                mappingTableStock(response.data)
            })
        })

        // FInalized
        $('#finalize_table').on('click', '.stepApproval', function(){
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
                        mappingTableLog(response.log,response.count)
                        if(response.detail.item_relation == null){
                            mappingTableItem(response.log_item,'detail_item_table')
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
                               'quantity' : response.detail.item_relation.quantity,
                               'quantity_request' : response.detail.quantity_request,
                               'quantity_result' : result,
                               'uom' : response.detail.item_relation.uom,
                           }
                           array_push.push(data)
                           mappingTableItem(array_push,'detail_item_table')
                           
                        }
                    })
            })
        $('#finalize_table').on('click','.updateProgress', function(){
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
                    getCallbackNoSwal('getFinalizeItem', null, function(response){
                        mappingTableFinal(response.data)
                    })
                    $('#btn_update_progress').prop('disabled', false)
                })
            })
        // FInalized

        // Assignment
        onChange('select_approval','approval_id')
        $('#assignment_table').on('click','.approvalTransaction', function(){
            $('#approve_comment').summernote('reset');
            $('#select_approval').val('').trigger('change')
            var data = {
                        'id':$(this).data('tc') ,
                        'des':$(this).data('des') ,
                    }
                   
                    getCallback('detailPurchaseTransaction',data,function(response){
                        console.log(response)
                        swal.close()
                        var status ='';
                        if(response.detail.status == 1){
                            status ='NEW'
                        }else if(response.detail.status == 2){
                            status ='On Queue'
                        }else if( response.detail.status == 3){
                            status ='On Progress'
                        }else if( response.detail.status == 4){
                            status ='Checking'
                        }else if(response.detail.status == 5){
                            status ='Revision'
                        }else if(response.detail.status == 6){
                            status ='Done'
                        }else{
                            status ='Reject'

                        }
                        if(response.detail.item_relation == null){
                            mappingTableItem(response.log_item,'assignment_item_table')
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
                               'quantity' : response.detail.item_relation.quantity,
                               'quantity_request' : response.detail.quantity_request,
                               'quantity_result' : result,
                               'uom' : response.detail.item_relation.uom,
                           }
                           array_push.push(data)
                           mappingTableItem(array_push,'assignment_item_table')
                        }
                        // if(response.detail.request_type == 4 ){
                        // }else{
                       
                        // }
                        $('#transaction_code').val(response.detail.request_code)
                        $('#assignment_transaction_code').html(': '+ response.detail.request_code)
                        $('#assignment_location_id').html(': '+response.detail.location_relation.name)
                        $('#assignment_des_location').html(': '+response.detail.des_location_relation.name)
                        $('#assignment_remark').summernote('code',response.detail.remark)
                        $('#assignment_user_id').html(': ' + response.detail.user_relation.name)
                        $('#assignment_approval_id').html(': ' + response.detail.approval_relation.name)
                        $('#assignment_status').html(': ' + status)

                    })
        })

        $('#btn_save_approval').on('click', function(){
            $('.message_error').html('')
            var data ={
                'id' : $('#transaction_code').val(),
                'approval_id' : $('#approval_id').val(),
                'approve_comment' : $('#approve_comment').val(),
            }
            postCallback('updateAssignment',data, function(response){
                swal.close()
                $('#approvalTransactionModal').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getAssignment',null,function(res){
                        mappingTableAssignment(res.data)
                    })
            })
        })
        // Assignment
    // Operation
        getActiveItems('getLocation', null, 'select_location_filter', 'Location')
    // Function
    function mappingTable(response) {
        var data = '';
        $('#product_table').DataTable().clear();
        $('#product_table').DataTable().destroy();

        for (i = 0; i < response.length; i++) {
            var css = '';
            if (response[i].quantity <= response[i].min_quantity) {
                css = 'color : red; font-weight:bold';
            }

            // var editBuffer = `
            //     <button title="Edit Buffer" class="editBufferProduct btn btn-sm btn-secondary rounded" 
            //         data-code="${response[i]['product_code']}" 
            //         data-id="${response[i]['id']}" 
            //         data-toggle="modal" 
            //         data-target="#editBufferProductModal">
            //         <i class="fas fa-solid fa-gears"></i>
            //     </button>
            // `;

            data += `
                <tr style="text-align: center;">
                    <td style="width:25%;text-align:left;${css}">${response[i].location_relation.name}</td>
                    <td style="width:35%;text-align:left;${css}">${response[i].name}</td>
                    <td style="width:15%;text-align:center;${css}">${response[i].quantity}</td>
                    <td style="width:15%;text-align:center;${css}">${response[i].uom}</td>
                </tr>
            `;
        }

        $('#product_table > tbody:first').html(data);
        $('#product_table').DataTable({
            dom: 'rtip',
            scrollX: true,
            language: {
                'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                }
            },
            searching: true,
            pagingType: "simple",
            iDisplayLength: 10,
            scrollY: 300,
            order: [[1, 'asc']] // Column index 1 (quantity) ordered ascending
        }).columns.adjust();
    }


        function mappingTableAssignment(response){
            var data =''
            $('#assignment_table').DataTable().clear();
            $('#assignment_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        var editBuffer =` <button title="Edit Buffer" class="editBufferProduct btn btn-sm btn-secondary rounded" data-code="${response[i]['product_code']}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBufferProductModal">
                                            <i class="fas fa-solid fa-gears"></i>
                                        </button>`
                        
                        data += `<tr style="text-align: center;">
                                    <td style="width:25%;text-align:center">${date} ${time}</td>
                                    <td style="width:25%;text-align:left">${response[i].request_code}</td>
                                    <td style="text-align:left;widht:35%">${response[i].user_relation.name}</td>
                                    <td style="width:15%;text-align:center">
                                           <button title="Detail" class="approvalTransaction btn btn-sm btn-info rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#approvalTransactionModal">
                                                <i class="fa-solid fa-tag"></i>
                                            </button>
                                       
                                    </td>
                                </tr>
                            `;
                    }
            $('#assignment_table > tbody:first').html(data);
            $('#assignment_table').DataTable({
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:300
                
            }).columns.adjust()
        
        }
        function mappingTableFinal(response){
            var data =''
            $('#finalize_table').DataTable().clear();
            $('#finalize_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var btnChecking = ``
                        if(response[i].approval_id == authId){
                            btnChecking = ` <button title="Update Progress" class="updateProgress btn btn-sm btn-warning rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#updateProgressModal">
                                                                           <i class="fas fa-solid fa-edit"></i>
                                                                       </button>     `
                        }else{
                            var btnChecking = `
                          <button title="Detail" class="stepApproval btn btn-sm btn-info rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#detailTransacrionModal">
                                                        <i class="fas fa-solid fa-user"></i>
                        `
                        }
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                                        if(response[i].status == 3){
                                            data += `<tr style="text-align: center;">
                                                        <td style="width:25%;text-align:center">${date} ${time}</td>
                                                        <td style="width:25%;text-align:left">${response[i].request_code}</td>
                                                        <td style="text-align:left;widht:35%">${response[i].user_relation.name}</td>
                                                        <td style="width:15%;text-align:center">
                                                        ${btnChecking}                               
                                                        </td>
                                                    </tr>
                                                `;
                                        }
                    }
            $('#finalize_table > tbody:first').html(data);
            $('#finalize_table').DataTable({
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:300
                
            }).columns.adjust()
        
        }
        function mappingTableStock(response){
            var data =''
            $('#stock_move_table').DataTable().clear();
            $('#stock_move_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {    
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        data += `<tr style="text-align: center;">
                                    <td style="text-align:center;width: 50px">${date} ${time}</td>
                                    <td style="text-align:center;width: 50px">${response[i].transaction_relation.request_code}</td>
                                    <td style="text-align:left;width: 100px">${response[i].item_relation.name}</td>
                                    <td style="text-align:center;width: 50px">${response[i].quantity_request} ${response[i].item_relation.uom}</td>

                                  
                                </tr>
                            `;
                    }
            $('#stock_move_table > tbody:first').html(data);
            $('#stock_move_table').DataTable({
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:260,
                order: [[0, 'desc']]
            }).columns.adjust()
        
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