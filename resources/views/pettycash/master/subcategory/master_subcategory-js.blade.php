<script>
    // Call Function
        getCallback('getSubCategory',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        $('#btn_add_subcategory').on('click', function(){
            getActiveItems('getActiveCategoryPC',null,'select_category','Category')
            $('#name').val('')
            $('#description').val('')
            $('#category_id').val('')
            $('.message_error').val('')
        })
        onChange('select_category', 'category_id')

        $('#btn_save_sub_category').on("click", function(){
            var data ={
                'name' : $('#name').val(),
                'description' : $('#description').val(),
                'category_id' : $('#category_id').val(),
            }
            postCallback('addSubCategory',data,function(response){
                swal.close()
                toastr['success'](response.meta.message);
                $('#addSubCategoryModal').modal('hide')
                getCallbackNoSwal('getSubCategory',null,function(response){
                    swal.close()
                    mappingTable(response.data)
                })
            })
        })
        // Active Sub Category
        $('#subcategory_table').on('change','.is_checked', function(){
            var data ={
                'status':$(this).data('status'),
                'id':$(this).data('id'),
            }
            postCallbackNoSwal('activateSubCategoryPC', data, function(response){
                swal.close()
                $('.message_error').html('')
                toastr['success'](response.meta.message);
                getCallbackNoSwal('getSubCategory',null,function(response){
                    swal.close()
                    mappingTable(response.data)
                })
            })
        })
        // Active Sub Category
        // Edit Sub Category
            $('#subcategory_table').on('click', '.edit',function(response){
                var id = $(this).data('id')
                var data ={
                    'id' : id
                }
                getCallback('detailSubCategory', data, function(response){
                    swal.close()
                    $('#name_edit').val(response.detail.name)
                    $('#description_edit').val(response.detail.description)
                    $('#category_id_edit').val(response.detail.category_relation.name)
                    $('#subcategoryId').val(response.detail.id)
                })
            })
            $('#btn_update_sub_category').on('click', function(response){
                var data_test ={
                    'id' :$('#subcategoryId').val(),
                    'name_edit' :$('#name_edit').val(),
                    'description_edit' :$('#description_edit').val()
                }
                console.log(data_test)
                postCallback('updateSubCategory',data_test,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    $('#editSubCategoryModal').modal('hide')
                    getCallbackNoSwal('getSubCategory',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Edit Sub Category
    // Operation

    // Function
        function mappingTable(response){
                
        var data =''
            $('#subcategory_table').DataTable().clear();
            $('#subcategory_table').DataTable().destroy();

            var data=''
            for(i = 0; i < response.length; i++ )
            {
                     
                                            
                        data += `<tr style="text-align: center;">
                                    <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  ${response[i].status == 1 ?'checked' :''} data-id="${response[i].id}" data-status="${response[i].status}"></td>
                                    <td style="text-align:center;">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;">${response[i].category_relation.name}</td>
                                    <td style="text-align:left;">${ response[i].name}</td>
                                    <td style="width:25%;text-align:center">
                                       
                                       <button title="Detail" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editSubCategoryModal">
                                           <i class="fas fa-solid fa-eye"></i>
                                       </button> 
                               </td>
                                </tr>
                            `;
                    }
            $('#subcategory_table > tbody:first').html(data);
            $('#subcategory_table').DataTable({
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