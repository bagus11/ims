
<script>
    // Call Function
        getCallback('getCategory',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Type
            $('#btn_add_category').on('click', function(){
                $('#name').val('')
                $('#type_id').val('')
                $('.message_error').html('')
                getActiveItems('getActiveType',null,'select_type','Type')
                getActiveItems('getActiveDepartment',null,'select_department','Department')
            })
            onChange('select_type','type_id')
            onChange('select_department','department_id')
            $('#btn_save_category').on('click', function(){
                var data ={
                    'type_id':$('#type_id').val(),
                    'department_id':$('#department_id').val(),
                    'name':$('#name').val()
                }
                postCallback('addCategory', data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addCategoryModal').modal('hide')
                    getCallback('getCategory',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Add Type
        // Change Active flag
            $('#category_table').on('change', '.is_checked', function(e) {
                    $('.is_checked').prop('disabled',true)
                    e.preventDefault();
                    var status = $(this).data('status')
                    var data ={
                            'id': $(this).data('id'),     
                            'is_active': $(this).data('isactive'),     
                    }
                    
                    postCallback('updateStatusCategory',data,function(response) {
                            $('.is_checked').prop('disabled',false)
                            toastr['success'](response.message);
                            getCallback('getCategory',null,function(response){
                                swal.close()
                                mappingTable(response.data)
                            })
                    });
            });
        // Change Active flag

        // Update Type
            $('#category_table').on('click','.editCategory', function(){
                var id      = $(this).data('id')
                getActiveItems('getActiveType',null,'select_type_edit','Type')
                var data    = {
                    'id':id
                }
                getCallback('detailCategory',data, function(response){
                    swal.close()
                    $('#categoryId').val(id)
                    $('#name_edit').val(response.detail.name)
                    $('#select_type_edit').val(response.detail.type_id)
                    $('#select_type_edit').select2().trigger('change');
                    $('#type_id_edit').val(response.detail.type_id)
                    
                })
            })
            $('#btn_update_category').on('click', function(){
                var data ={
                    'id' : $('#categoryId').val(),
                    'type_id_edit' : $('#type_id_edit').val(),
                    'name_edit' : $('#name_edit').val(),
                }
                postCallback('updateCategory',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#editCategoryModal').modal('hide')
                    getCallback('getCategory',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Update Type

        // Delete Type
            $('#category_table').on('click','.deleteCategory', function(){
                var data ={
                    'id':$(this).data('id')
                }
                getCallback('deleteCategory', data,function(response){
                    swal.close()
                    if(response.status == 200){
                        toastr['success'](response.message);
                        getCallback('getCategory',null,function(response){
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
            $('#category_table').DataTable().clear();
            $('#category_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:5%">${i + 1}</td>
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-isactive="${response[i]['is_active']}" data-id="${response[i]['id']}" ${response[i]['is_active'] == 1 ?'checked':'' }></td>
                                <td style="width:5%">${response[i].is_active == 1 ?'active':'inactive'}</td>
                                <td style="text-align:left;width:15%">${response[i].type_relation.name}</td>
                                <td style="text-align:left;width:15%">${response[i].department_relation.name}</td>
                                <td style="text-align:left;width:65%">${response[i].name}</td>
                                <td style="width:20%">
                                        <button title="Detail" class="editCategory btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editCategoryModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteCategory btn btn-sm btn-danger"data-id="${response[i]['id']}">
                                            <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                    }
            $('#category_table > tbody:first').html(data);
            $('#category_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
        
        }
    // Function
</script>