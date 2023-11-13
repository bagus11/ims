<script>
    // Call Function
        getCallback('getItemRequest',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
        $('#detail_comment').summernote({
                    toolbar: false,
        })
        $('#update_last_remark').summernote({
                    toolbar: false,
        })
    // Call Function

    // Operation
    $('#btn_refresh').on('click', function(){
        getCallback('getItemRequest',null,function(response){
            swal.close()
            mappingTable(response.data)
        }) 
    })
        // Add Request 
            $('#btn_add_ir').on('click', function(){
                $('.message_error').html('')
                $('#quantity_product').val('')
                $('#transaction_id').val('')
                $('#select_transaction_type').val('').trigger('change')
                $('#select_product').empty()
                $('#select_product').append('<option value="">Choose Source Location First</option>')
                $('#select_category').empty()
                $('#select_category').append('<option value="">Choose Type First</option>')
                $('#product_id').val('')
                $('#location_id').val('')
                $('#quantity_request').val('')
                $('#des_location_id').val('')
                getActiveItems('getLocation',null,'select_location','Location')
                getActiveItems('getLocation',null,'select_des_location','Location')
                // getActiveItems('getActiveDepartment',null,'select_department','Department')
                // getActiveItems('getActiveType',null,'select_type','Type')
            })
            $('#select_location').on('change', function(){
                var data ={
                    'id':$('#select_location').val()
                }
                getProductItems('getActiveProduct',data,'select_product','Product')
            })
            $('#select_product').on('change', function(){
                var data ={ 'id':$('#select_product').val()}
                getCallbackNoSwal('detailProduct', data, function(response){
                    $('#quantity_product').val(response.detail.quantity)
                    $('#quantity_product').prop('disabled',true)
                })
            })
            $('#quantity_request').on('change', function(){
                var min = $("#select_product").select2().find(":selected").data("min");
                var quantity = $('#quantity_request').val()
                var quantity_product = $('#quantity_product').val()
                var type = $('#transaction_id').val()
                var total = parseInt(quantity_product) - parseInt(quantity)
                if(type == 1 ){
                    if(total <=  min){
                        toastr['warning']('quantity is not enough, please contact accounting staff');  
                        $('#quantity_request').val('')
                        return false
                    }
                }
            })
            onChange('select_transaction_type','transaction_id')
            onChange('select_product','product_id')
            onChange('select_location','location_id')
            // onChange('select_des_location','des_location_id')
         

            $('#btn_save_transaction').on('click', function(e){
                e.preventDefault()
                var data = new FormData();
                data.append('transaction_id',$('#transaction_id').val())
                data.append('location_id',$('#location_id').val())
                data.append('product_id',$('#product_id').val())
                data.append('des_location_id',$('#des_location_id').val())
                data.append('quantity_request',$('#quantity_request').val())
                data.append('comment',$('#comment').val())
                // data.append('attachment_req',$('#attachment_req')[0].files[0]);
                postAttachment('addTransaction',data,false,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    $('#addIrModal').modal('hide')
                    getCallback('getItemRequest',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })

            })
        // Add Request 
        
        // Detail Transaction
            $('#ir_table').on('click','.stepApproval', function(){
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
                        $('#detail_product').html(': '+response.detail.item_relation.name)
                        $('#detail_quantity_request').html(': '+response.detail.quantity_request+ ' ' + response.detail.item_relation.uom)
                        $('#detail_user_id').html(': ' + response.detail.user_relation.name)
                        $('#detail_approval_id').html(': ' + approverName )
                        $('#detail_status').html(': ' + status)
                        $('#detail_attachment').empty()
                        $('#detail_attachment').append(`: ${attachment}`)
                    
                        mappingTableLog(response.log,response.count)
                    })
            })
        // Detail Transaction

        // Update Transaction
            $('#ir_table').on('click', '.updateProgress',function(){
                $('#update_comment').summernote('reset');
                $('#update_last_remark').summernote('reset');
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
                            status ='On Queue'
                        }else if( response.detail.status == 3){
                            status ='On Progress'
                        }else if( response.detail.status == 4){
                            status ='DONE'
                        }else if(response.detail.status == 5){
                            status ='Reject'
                        }
                        var quantity_final = response.detail.item_relation.quantity -  response.detail.quantity_request ;
                        var approverName = response.detail.approval_id == 0 ?' - ': response.detail.approval_relation.name
                        $('#update_transaction_code').html(': '+ response.detail.request_code)
                        $('#update_transaction_id').val(response.detail.request_code)
                        $('#update_location_id').html(': '+response.detail.location_relation.name)
                        $('#update_des_location').html(': '+response.detail.des_location_relation.name)
                        $('#update_product').html(': '+response.detail.item_relation.name)
                        $('#update_quantity_request').html(': '+response.detail.quantity_request+ ' ' + response.detail.item_relation.uom)
                        $('#update_user_id').html(': ' + response.detail.user_relation.name)
                        $('#update_approval_id').html(': ' + approverName )
                        $('#update_status').html(': ' + status)
                        $('#update_quantity_after_transaction').html(': ' + quantity_final + ' ' + response.detail.item_relation.uom)
                        $('#update_current_quantity').html(': ' + response.detail.item_relation.quantity + ' ' + response.detail.item_relation.uom)
                        var getLastRow = response.log.slice(-1) 
                        $('#update_last_remark').summernote('code',getLastRow[0].comment)
                        $('#update_attachment').empty()
                        $('#update_attachment').append(`: ${attachment}`)
                    })
            })
            onChange('select_update_approval_id','update_approvalId');
            $('#btn_update_progress').on('click', function(){
                var data ={
                    'id'            : $('#update_transaction_id').val(),
                    'update_approvalId'   : $('#update_approvalId').val(),
                    'update_comment'      : $('#update_comment').val(),
                }
                postCallback('updateProgress',data,function(response){
                    swal.close();
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#updateProgressModal').modal('hide')
                    getCallback('getItemRequest',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Update Transaction

        // Report
            $('#ir_table').on('click','.export',function(){
                var request_code = $(this).data('tc').replace(/\//g, "&*.")
                window.open(`print_ir/${request_code}`,'_blank');
            })
        // Report
        
    // Operation

    // Function
        function mappingTable(response){

                var data =''
                $('#ir_table').DataTable().clear();
                $('#ir_table').DataTable().destroy();
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
                                            <td style="text-align:left;">${response[i].item_relation == null ? '' : response[i].item_relation.name}</td>
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
                $('#ir_table > tbody:first').html(data);
                $('#ir_table').DataTable({
                    scrollX  : true,
                    ordering : false
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
                                status ='On Queue '+[i]
                            }else if( response[i].status == 3){
                                status ='On Progress'
                            }else if( response[i].status == 4){
                                status ='Checking'
                            }else if(response[i].status == 5){
                                status ='Revision'
                            }else if(response[i].status == 6){
                                status ='Done'
                            }else{
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
             
                $('#detail_comment').summernote('code',last_comment)
        }
    // Function
</script>