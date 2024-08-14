<script>
    // Call Function
        getCallback('getAssignment',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        $('#btn_refresh').on('click', function(){
            getCallback('getAssignment',null,function(response){
                swal.close()
                mappingTable(response.data)
            }) 
        })
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
                        // if(response.detail.request_type == 4 ){
                        // }else{
                       
                        // }
                        $('#transaction_code').val(response.detail.request_code)
                        $('#detail_transaction_code').html(': '+ response.detail.request_code)
                        $('#detail_location_id').html(': '+response.detail.location_relation.name)
                        $('#detail_des_location').html(': '+response.detail.des_location_relation.name)
                        $('#detail_remark').html(': ' + response.detail.remark)
                        $('#detail_user_id').html(': ' + response.detail.user_relation.name)
                        $('#detail_approval_id').html(': ' + response.detail.approval_relation.name)
                        $('#detail_status').html(': ' + status)

                    })
        })
        onChange('select_approval','approval_id')
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
                        mappingTable(res.data)
                    })
            })
        })
    // Operation

    // FUnction
        function mappingTable(response){
            var data =''
                $('#assignment_table').DataTable().clear();
                $('#assignment_table').DataTable().destroy();
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
                            var type = ''
                            if (response[i].request_type == 1){
                                type ='Request'
                            }else if(response[i].request_type == 2){
                                type ='Return'
                            }else if(response[i].request_type == 3){
                                type ='Disposal'
                            }else{
                                type ='Purchase'
                            }
                            data += `<tr style="text-align: center;">
                                    <td style="width:5%">${i + 1}</td>
                                    <td style="text-align:center;">${response[i].request_code}</td>
                                    <td style="text-align:center;">${type}</td>
                                    <td style="text-align:center;">${response[i].user_relation.name}</td>
                                    <td style="text-align:left;">${response[i].location_relation.name}</td>
                                    <td style="text-align:center;">${status}</td>
                                    <td style="">
                                            <button title="Detail" class="approvalTransaction btn btn-sm btn-info rounded" data-tc="${response[i].request_code}"   data-des="${response[i].des_location_id}" data-toggle="modal" data-target="#approvalTransactionModal">
                                                <i class="fa-solid fa-tag"></i>
                                            </button>
                                    </td>
                                </tr>
                                `;
                        }
                $('#assignment_table > tbody:first').html(data);
                $('#assignment_table').DataTable({
                    scrollX  : true,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                }).columns.adjust()
        }
    // FUnction
</script>