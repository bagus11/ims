<script>
    // Call Function
        getCallback('getCategoryPC',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Category
            $('#btn_add_category_pc').on('click', function(){
                $('#name').val('')
                $('#description').val('')
                $('#min_transaction').val('')
                $('#max_transaction').val('')
                $('#duration').val('')
            })
            $("#min_transaction").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
            $("#max_transaction").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
            $('#btn_save_category_pc').on('click', function(){
                const min_transaction = $('#min_transaction').val()
                var min_transaction_string = parseFloat(min_transaction.replace(/,/g, ''));

                const max_transaction = $('#max_transaction').val()
                var max_transaction_string = parseFloat(max_transaction.replace(/,/g, ''));
                var data ={
                    'name' : $('#name').val(),
                    'description' : $('#description').val(),
                    'min_transaction' :min_transaction_string,
                    'max_transaction' : max_transaction_string,
                    'duration' : $('#duration').val(),
                }
                $('.message_error').html('')
                postCallback('addCategoryPC',data,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    $('#addCategoryModal').modal('hide')
                    getCallbackNoSwal('getCategoryPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Add Category
        // Update Category
            // Activated Category
                $('#category_pc_table').on('change','.is_checked', function(){
                    var data ={
                        'status':$(this).data('status'),
                        'id':$(this).data('id'),
                    }
                    postCallbackNoSwal('activateCategoryPC', data, function(response){
                        swal.close()
                        $('.message_error').html('')
                        toastr['success'](response.meta.message);
                        getCallbackNoSwal('getCategoryPC',null,function(response){
                            swal.close()
                            mappingTable(response.data)
                        })
                    })
                })

            // Activated Category
            
            // Update Category
            $("#min_transaction_edit").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
            $("#max_transaction_edit").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
                $('#category_pc_table').on('click','.edit', function(){
                    var id = $(this).data('id');
                    var data ={
                        'id':id,
                    }
                    getCallback('detailCategoryPC',data,function(response){
                        swal.close()
                       
                       $('#categoryId').val(response.detail.id)
                       $('#name_edit').val(response.detail.name)
                       $('#description_edit').val(response.detail.description)
                       $('#duration_edit').val(response.detail.duration)
                       $('#min_transaction_edit').val(convertToRupiah(response.detail.min_transaction))
                       $('#max_transaction_edit').val(convertToRupiah(response.detail.max_transaction))
                    })
                })
                $('#btn_update_category_pc').on('click', function(){
                    const min_transaction = $('#min_transaction_edit').val()
                    var min_transaction_string = parseFloat(min_transaction.replace(/,/g, ''));

                    const max_transaction = $('#max_transaction_edit').val()
                    var max_transaction_string = parseFloat(max_transaction.replace(/,/g, ''));
                    var data ={
                        'id' : $('#categoryId').val(),
                        'name_edit' : $('#name_edit').val(),
                        'description_edit' : $('#description_edit').val(),
                        'min_transaction_edit' :min_transaction_string,
                        'max_transaction_edit' : max_transaction_string,
                        'duration_edit' : $('#duration_edit').val(),
                    }
                    $('.message_error').html('')
                    postCallback('UpdateCategoryPC',data,function(response){
                        swal.close()
                        toastr['success'](response.meta.message);
                        $('#editCategoryModal').modal('hide')
                        getCallbackNoSwal('getCategoryPC',null,function(response){
                            swal.close()
                            mappingTable(response.data)
                        })
                    })
            })
            // Update Category
        // Update Category
    // Operation

    // Function
    function mappingTable(response){
        
        var data =''
            $('#category_pc_table').DataTable().clear();
            $('#category_pc_table').DataTable().destroy();

            var data=''
            for(i = 0; i < response.length; i++ )
            {
                        var css ='';
                        if(response[i].quantity <= response[i].min_quantity){
                            css ='color : red; font-weight:bold'
                        }

                        var editBuffer =` <button title="Edit Buffer" class="editBufferProduct btn btn-sm btn-secondary rounded" data-code="${response[i]['product_code']}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBufferProductModal">
                                            <i class="fas fa-solid fa-gears"></i>
                                        </button>`
                        
                        data += `<tr style="text-align: center;">
                                    <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  ${response[i].status == 1 ?'checked' :''} data-id="${response[i].id}" data-status="${response[i].status}"></td>
                                    <td style="text-align:center;">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;">${response[i].name}</td>
                                    <td style="text-align:right;">${ formatRupiah(response[i].min_transaction)}</td>
                                    <td style="text-align:right;">${ formatRupiah(response[i].max_transaction)}</td>
                                    <td style="text-align:right;">${response[i].duration} day</td>
                                    <td style="width:25%;text-align:center">
                                       
                                       <button title="Detail" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editCategoryModal">
                                           <i class="fas fa-solid fa-eye"></i>
                                       </button> 
                                       
                               </td>
                                </tr>
                            `;
                    }
            $('#category_pc_table > tbody:first').html(data);
            $('#category_pc_table').DataTable({
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                scrollY:300
                
            }).columns.adjust()
    }
    // Function
</script>