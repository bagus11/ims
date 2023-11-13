
    <script>
    // Call Function
        getCallback('getType',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Type
            $('#btn_add_type').on('click', function(){
                $('#name').val('')
                $('#initial').val('')
                $('.message_error').html('')
            })
            $('#btn_save_type').on('click', function(){
                var data ={
                    'name':$('#name').val(),
                    'initial':$('#initial').val()
                }
                postCallback('addType', data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addTypeModal').modal('hide')
                    getCallback('getType',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Add Type
        // Change Active flag
            $('#type_table').on('change', '.is_checked', function(e) {
                    $('.is_checked').prop('disabled',true)
                    e.preventDefault();
                    var status = $(this).data('status')
                    var data ={
                            'id': $(this).data('id'),     
                            'is_active': $(this).data('isactive'),     
                    }
                    
                    postCallback('updateStatusType',data,function(response) {
                            $('.is_checked').prop('disabled',false)
                            toastr['success'](response.message);
                            getCallback('getType',null,function(response){
                                swal.close()
                                mappingTable(response.data)
                            })
                    });
            });
        // Change Active flag

        // Update Type
            $('#type_table').on('click','.editType', function(){
                var id      = $(this).data('id')
                var data    = {
                    'id':id
                }
                getCallback('detailType',data, function(response){
                    swal.close()
                    $('#typeId').val(id)
                    $('#name_edit').val(response.detail.name)
                    $('#initial_edit').val(response.detail.initial)
                    
                })
            })
            $('#btn_update_type').on('click', function(){
                var data ={
                    'id' : $('#typeId').val(),
                    'name_edit' : $('#name_edit').val(),
                    'initial_edit' : $('#initial_edit').val(),
                }
                postCallback('updateType',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#editTypeModal').modal('hide')
                    getCallback('getType',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Update Type

        // Delete Type
            $('#type_table').on('click','.deleteTypes', function(){
                var data ={
                    'id':$(this).data('id')
                }
                getCallback('deleteType', data,function(response){
                    swal.close()
                    if(response.status == 200){
                        toastr['success'](response.message);
                        getCallback('getType',null,function(response){
                            swal.close()
                            mappingTable(response.data)
                        })
                    }else{
                        toastr['error'](response.message);
                    }
                })
            })
        // Delete Type
    // Operation

    // Function
        function mappingTable(response){
            var data =''
            $('#type_table').DataTable().clear();
            $('#type_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:5%">${i + 1}</td>
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-isactive="${response[i]['is_active']}" data-id="${response[i]['id']}" ${response[i]['is_active'] == 1 ?'checked':'' }></td>
                                <td style="width:5%">${response[i].is_active == 1 ?'active':'inactive'}</td>
                                <td style="text-align:left;width:10%">${response[i].initial}</td>
                                <td style="text-align:left;width:65%">${response[i].name}</td>
                                <td style="width:20%">
                                        <button title="Detail" class="editType btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editTypeModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteTypes btn btn-sm btn-danger"data-id="${response[i]['id']}">
                                            <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                    }
            $('#type_table > tbody:first').html(data);
            $('#type_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
        
        }
    // Function
</script>