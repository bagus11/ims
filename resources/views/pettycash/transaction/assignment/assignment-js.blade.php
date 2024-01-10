<script>
    getCallback('getAssignmentPC',null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    // Operation
        $("#amount_assign").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() { 
            formatCurrency($(this), "blur");
            }
        });
            $(document).ready(function(){
                $('#start_date').datetimepicker({
                    format:'Y-MM-DD',
                });
            })
          
        $('#assignment_table').on('click', '.edit', function(){
           
            var id =$(this).data('id')
                    data ={
                        'id':id
                    }
                    getCallback('detailPettyCashRequest',data,function(response){
                        response.count == response.detail.step ? $('#detail_transaction_card').prop('hidden', false) : $('#detail_transaction_card').prop('hidden', true)
                        swal.close()
                        var status =''
                      
                    if(response.detail.status ==0){
                        status ='NEW'
                    }else if(response.detail.status == 1){
                        status ='Partially Approved'
                    }else if(response.detail.status == 2){
                        status = 'On Progress'
                    }else if(response.detail.status == 3){
                        status = 'Checking'
                    }else if(response.detail.status == 4){
                        status = 'DONE'
                    }else{
                        status = 'Reject'
                    }             
                        if(response.detail.approval_id ==0){
                            $('#ca_label').prop('hidden', true)
                            $('#current_approval_label').prop('hidden', true)
                        }else{
                            $('#ca_label').prop('hidden', false)
                            $('#current_approval_label').prop('hidden', false)

                        }
                        var output = response.detail.attachment.split('/').pop();
                        $('#pc_code_id').val(response.detail.pc_code)
                       $('#pc_code_label').html(': ' + response.detail.pc_code)
                       $('#status_label').html(': ' + status)
                       $('#request_label').html(': ' + response.detail.requester_relation.name)
                       $('#pic_label').html(': ' + response.detail.pic_relation.name)
                       $('#category_label').html(': ' + response.detail.category_relation.name)
                       $('#attachment_label').html(`:  <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                            ${output}
                                        </a>`)
                        $('#remark_label').html(': ' +  response.detail.remark)
                        $('#current_approval_label').html(': ' +  response.detail.approval_relation? response.detail.approval_relation.name : '')
                        $('#location_label').html(': ' +  response.detail.location_relation.name)

                        mappingArrayTable('detail_req_table',response.data)
                    })
        })
        
        $('#btn_history_remark').on('click', function(){
            $('#loading').prop('hidden', false)
            var data ={
                'pc_code' : $('#pc_code_id').val()
            }
            getCallbackNoSwal('getHistoryRemark',data, function(response){
                $('#loading').prop('hidden', true)
                $('#logMessage').empty()
                var data =''
               for(i = 0; i < response.data.length; i++){
                const d = new Date(response.data[i].created_at)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                data +=`
                        <div class="direct-chat-msg ${response.data[i].creator_relation.id == $('#authId').val() ?'right':''}">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name ${response.data[i].creator_relation.id == $('#authId').val() ?'float-right':'float-left'}">${response.data[i].creator_relation == null ?'':response.data[i].creator_relation.name}</span>
                                <span class="direct-chat-timestamp ${response.data[i].creator_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                            </div>
                            
                                <img class="direct-chat-img" src="{{URL::asset('profile.png')}}" alt="message user image">
                        
                            <div class="direct-chat-text">
                                ${response.data[i].remark}
                            </div>
                        
                        </div>
                `;
            }
          
               $('#logMessage').append(data)
                
            })
        })

        $('#btn_save_assignment').on('click', function(){
            var amount = $('#amount_assign').val()
            var amount_string = parseFloat(amount.replace(/,/g, ''));
            var data ={
                'pc_code' : $('#pc_code_id').val(),
                'approval_id': $('#approval_id').val(),
                'remark': $('#remark').val(),
                'amount_assign': amount_string,
                'start_date_input': $('#start_date_input').val(),
            }

            postCallback('updateApprovalPC',data,function(response){
                swal.close()
                $('.message_error').html('')
                toastr['success'](response.meta.message);
                $('#detailPettycashRequst').modal('hide')
                getCallback('getAssignmentPC',null,function(response){
                    swal.close()
                    mappingTable(response.data)
                })
            })
        })
        onChange('select_approval','approval_id')
        $('#start_date').on('change', function(){
            var start_date = $('#start_date').val();
            var date 
            start_date.setDate(start_date.getDate() + 7);
            console.log(start_date)
            $('#end_date').val(start_date);
        })
    // Operation
    // Function
        function mappingTable(response){
            var data =''
                $('#assignment_table').DataTable().clear();
                $('#assignment_table').DataTable().destroy();

                var data=''
           
                for(i = 0; i < response.length; i++ )
                {
                            var status =''
                            var color =''
                            if(response[i].status ==0){
                                status ='NEW'
                                color = 'info'
                            }else if(response[i].status == 1){
                                status ='Partially Approved'
                                color = 'warning'
                            }else if(response[i].status == 2){
                                color = 'primary'
                                status = 'On Progress'
                            }else if(response[i].status == 3){
                                color = 'secondary'
                                status = 'Checking'
                            }else if(response[i].status == 4){
                                color = 'success'
                                status = 'DONE'
                            }else{
                                status = 'Reject'
                                color = 'danger'
                            }                 
                            data += `<tr style="text-align: center;">
                                    
                                        <td style="text-align:center;">${response[i].pc_code}</td>
                                        <td style="text-align:left;">${response[i].category_relation.name}</td>
                                        <td style="text-align:left;">${response[i].pic_relation.name}</td>
                                        <td style="text-align:left;">${response[i].location_relation.name}</td>
                                        <td style="text-align:center;"><b style ="font-size:12px"><span class="badge badge-${color}">${status}</span></b></td>
                                        <td style="width:25%;text-align:center">
                                        
                                        <button title="Update Approval" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailPettycashRequst">
                                            <i class="fas fa-solid fa-edit"></i>
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
                    searching :true,
                    pagingType: "simple",
                    scrollY:320
                    
                }).columns.adjust()
        }
    // Function
</script>