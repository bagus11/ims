<script>
    // Call Function
        getCallback('getApproverPC',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Master Approver
        $('#btn_add_approver').on('click', function(){
                $('.message_error').html('')
                getActiveItems('getActiveDepartment',null,'select_department','Department')
                getActiveItems('getLocation',null,'select_location','Location')
                $('#step').val('')
                $('#location_id').val('')
                $('#department_id').val('')
            })
            onChange('select_department','department_id')
            onChange('select_location','location_id')
            $('#btn_save_approval').on('click', function(){
                var data ={
                    'step':$('#step').val(),
                    'location_id':$('#location_id').val(),
                    'department_id':$('#department_id').val(),
                }
                postCallback('addMasterApproverPC',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addApprover').modal('hide')
                    getCallback('getApproverPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Add Master Approver

        // Edit Master Approver
            $('#approver_table').on('click', '.detail', function(){
                var id = $(this).data('id')
                var data ={
                    'id' :id
                }
            getCallback('detailMasterApproverPC',data,function(response){
                    swal.close()
                    $('#edit_department').val(response.detail.department_relation.name)
                    $('#edit_location').val(response.detail.location_relation.name)
                    $('#edit_step').val(response.detail.step)
                    $('#masterId').val(id)
                })
            })
            $('#btn_edit_approval').on('click', function(){
                var data ={
                    'edit_step' : $('#edit_step').val(),
                    'id' : $('#masterId').val(),
                }
              
                postCallback('editMasterApproverPC',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#editApprover').modal('hide')
                    getCallback('getApproverPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })

            })
        // Edit Master Approver

        // Edit Step Approver
        $('#approver_table').on('click', '.stepApproval',function(){
                var step = $(this).data('step')
                var id = $(this).data('id')
                var approval_id = $(this).data('approvalid')
                var data ={
                    'id':id,
                    'approval_id':approval_id,
                }
                $('#step_approval_code').val(approval_id)
                getCallbackNoSwal('getStepApproverPC',data,function(response){
                        swal.close()
                        mappingStepApprover(step,response.data)
                })
                
            })
            $('#btn_set_approver').on('click', function(){
               var select_approver =document.getElementsByClassName('select_approver');
               var array_approver =[]
                for(i =0; i< select_approver.length; i++){
                    var post ={
                        'step' : i+1,
                        'user_id' :select_approver[i].value ,
                    }
                    array_approver.push(post)
                }
              
                var data ={
                    'approval_id' : $('#step_approval_code').val(),
                    'user_array'  : array_approver
                }
                console.log(data)
                if(array_approver.length == 0)
                {
                    toastr['warning']('approver cannot be null');  
                }else{
                    postCallback('updateApproverPC',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#stepApprovalModal').modal('hide')
                    getCallback('getApproverPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
                }

            })
            
        // Edit Step Approver
    // Operation

    // Function
        function mappingTable(response){
            var data =''
            $('#approver_table').DataTable().clear();
            $('#approver_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="">${i + 1}</td>
                                <td style="text-align:left;">${response[i].approver_id}</td>
                                <td style="text-align:left;">${response[i].department_relation == null ? '' :response[i].department_relation.name}</td>
                                <td style="text-align:left;">${response[i].location_relation == null ? '' :response[i].location_relation.name}</td>
                                <td style="text-align:center;">${response[i].step} step</td>
                                <td style="">
                                        <button title="Detail Master Approver" class="detail btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editApprover">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>

                                        <button title="Detail Step Approval" class="stepApproval btn btn-sm btn-primary rounded"   data-step="${response[i].step}" data-approvalid="${response[i].approver_id}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#stepApprovalModal">
                                            <i class="fas fa-solid fa-user"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#approver_table > tbody:first').html(data);
            $('#approver_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
        }

        function mappingStepApprover(step,response){
            var data = ''
           
            $('#approver_step_table').DataTable().clear();
            $('#approver_step_table').DataTable().destroy();
            for(i = 0; i < step ; i++){
                var user =''
                var selectTitle = 'select_approver_' + i
                data += `
                    <tr>
                        <td style="width:10%; text-align:center;">${i + 1}</td>
                        <td style="width:90%">
                            <select name="${selectTitle}" class="select2 select_approver" style="font-size:9px;" id="${selectTitle}">
                                <option >
                                </option>
                            </select>
                        </td>
                    </tr>
                
                `;
                getApproval(response[i] == null ? '' : response[i].user_id,selectTitle)
            }
         
            $('#approver_step_table > tbody:first').html(data);
            $('#approver_step_table').DataTable({
                scrollX  : false,
            }).columns.adjust()
            $('.select2').select2()
            $(".select2").select2({ dropdownCssClass: "myFont" });
        }
        function getApproval(response,title){
            getCallbackNoSwal('getUser',null, function(res){
                $('#'+title).empty()
                $('#'+title).append('<option value ="">Choose Approver </option>');
                $.each(res.data,function(i,data){
                    $('#'+title).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                });
                if(response){
                    $('#'+title).val(response)
                    var test = $('#'+title).val(response)
                    $('#'+title).trigger('change')
                }

            })
           
        }
    // Function
</script>