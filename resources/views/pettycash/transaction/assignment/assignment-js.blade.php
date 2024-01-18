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
        $('#amount_assign').on('change', function(){
            var amount_total_detail = $('#amount_total_detail').val()
            var amount_assign = $('#amount_assign').val()
            var amount_final = parseFloat(amount_assign.replace(/,/g, ''));
            if(amount_final > amount_total_detail){
                toastr['warning']('amount assign cannot bigger than amount request');
                $('#amount_assign').val(amount_total_detail)
                document.getElementById("amount_assign").style.color = "red";
            }
        })
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
                        if(response.detail.step > 0){
                            alert('test')
                            if(response.detail.status >= 3){
                                $('#detail_transaction_card').prop('hidden', false)
                                $('#detail_transaction_card_after').prop('hidden', true)
                            }else{
                                $('#detail_transaction_card').prop('hidden', true)
                                $('#detail_transaction_card_after').prop('hidden', false)
                            }
                        }else{
                            $('#detail_transaction_card').prop('hidden', true)
                            $('#detail_transaction_card_after').prop('hidden', false)
                        }
                       
                        swal.close()
                        var status =''
                      
                    if(response.detail.status ==0){
                        status ='NEW'
                    }else if(response.detail.status == 1){
                        status ='Partially Approved'
                    }else if(response.detail.status == 2){
                        status = 'On Progress'
                    }else if(response.detail.status == 3){
                        status = 'On Review'
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
                        $('#amount_total_detail').val(response.detail.amount)
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

                            if(response.detail.status >= 3){
                                $('#detail_req_table_pi_container').prop('hidden', false)
                                $('#detail_req_table_container').prop('hidden', true)
                                mappingArrayTablePIChecking('detail_req_table_pi',response.data)
                                // console.log(response.data)
                            }else{
                                $('#detail_req_table_container').prop('hidden', false)
                                $('#detail_req_table_pi_container').prop('hidden', true)
                                mappingArrayTable('detail_req_table',response.data)
                            }
                        
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
                var name_img = response.data[i].creator_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                data +=`
                        <div class="direct-chat-msg ${response.data[i].creator_relation.id == $('#authId').val() ?'right':''}">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name ${response.data[i].creator_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.data[i].creator_relation == null ?'':response.data[i].creator_relation.name}</span>
                                <span style='font-size:9px;' class="direct-chat-timestamp ${response.data[i].creator_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                            </div>
                            
                                <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                        
                            <div class="direct-chat-text" style='font-size:9px;'>
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
                                color = 'secondary'
                            }else if(response[i].status == 1){
                                status ='Partially Approved'
                                color = 'warning'
                            }else if(response[i].status == 2){
                                color = 'primary'
                                status = 'On Progress'
                            }else if(response[i].status == 3){
                                color = 'purple'
                                status = 'On Review'
                            }else if(response[i].status == 4){
                                color = 'orange'
                                status = 'Finalization'
                            }else if(response[i].status == 5){
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
        function mappingArrayTablePIChecking(name,response){
            var data =''
            var total = 0
            var total_payment = 0
                $('#'+ name).DataTable().clear();
                $('#'+ name).DataTable().destroy();
                var data_total='';
                        for(i = 0; i < response.length; i++ )
                        {
                            var output = response[i].attachment.split('/').pop();
                            total += response[i].subcategory_amount
                            total_payment += response[i].payment
                                data += `<tr style="text-align: center;">
                                  
                                  <td style="text-align:center;">${i + 1}</td>
                                  <td style="text-align:left;width:30%">${response[i].subcategory_name}</td>
                                  <td style="text-align:left;width:20%">${formatRupiah(response[i].subcategory_amount)}</td>
                                  <td style="text-align:left;width:20%">${formatRupiah(response[i].payment)}</td>
                                  <td style="text-align:left;width:20%">
                                    <a target="_blank" href="{{URL::asset('${response[i].attachment}')}}" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                            ${output}
                                        </a>
                                    </td>
                                
                              </tr>
                              `;
                        }
                        data_total= ` <tr style="text-align:center;background-color:yellow">
                                    <td></td>
                                    <td style="font-weight:bold"> Total </td>
                                    <td style="font-weight:bold !important;text-align:left">${formatRupiah(total)} </td>
                                    <td style="font-weight:bold !important;text-align:left">${formatRupiah(total_payment)} </td>
                                    <td></td>
                                    
                                </tr>`
                        data += data_total
                              
                $('#total_array').val(total)
                $('#'+ name +' > tbody:first').html(data);
                $('#'+ name).DataTable({
                    scrollX  : false,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                    ordering : false
                }).columns.adjust()
         
        }
    // Function
</script>