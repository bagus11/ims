<script>
    // Call Function
        getCallback('getProduct',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
        getActiveItems('getActiveCategory', null, 'select_category_filter', 'Category')
        getActiveItems('getLocation', null, 'select_location_filter', 'Location')
    // Call Function

    // Operation
        // Add Product
            $('#btn_add_product').on('click', function(){
                $('.message_error').html('')
                $('#name').val('')
                $('#quantity').val('')
                $('#last_price').val('')
                $('#category_id').val('')
                $('#type_id').val('')
                $('#quantity').val('')
                $('#location_id').val('')
                $('#select_category').empty()
                $('#select_category').append('<option value=""> Choose Type First</option>')
                getActiveItems('getActiveType',null,'select_type','Type')
                getActiveItems('getLocation',null,'select_location','Location')
                getActiveItems('getActiveDepartment',null,'select_department','Department')
            })
            onChange('select_location','location_id')
            onChange('select_department','department_id')
            onChange('select_type','type_id')
            onChange('select_category','category_id')
            onChange('select_uom','uom_id')
            $('#select_type').on('change', function(){
                var data ={
                    'id':$('#select_type').val(),
                    'location_id':$('#location_id').val(),
                    'department_id':$('#department_id').val(),
                   
                }
             
                getActiveItems('getActiveCategory',data,'select_category','Category')
            })

            $('#btn_save_product').on('click', function(){
                var data ={
                    'name':$('#name').val(),
                    'category_id':$('#category_id').val(),
                    'type_id':$('#type_id').val(),
                    'department_id':$('#department_id').val(),
                    'uom_id':$('#uom_id').val(),
                    'quantity':$('#quantity').val(),
                    'location_id':$('#location_id').val(),
                }
                postCallback('addProduct',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addProductModal').modal('hide')
                    getCallback('getProduct',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Add Product

        // Edit Product
            $('#product_table').on('click','.editProduct', function(){
                getActiveItems('getActiveCategory',null,'select_category_edit','Category')
                getActiveItems('getLocation',null,'select_location_edit','Location')
                var id = $(this).data('id')
                var data ={
                    'id':id
                }
           
                getCallback('detailProduct',data,function(response){
                    swal.close()
                    $('#select_type_edit').empty();
                    $('#select_type_edit').append('<option value="'+response.detail.type_id+'">'+response.detail.type_relation.name+'</option>')
                    $('#productId').val(id)
                    $('#name_edit').val(response.detail.name)
                    $('#type_id_edit').val(response.detail.type_id)
                    $('#category_id_edit').val(response.detail.category_id)
                    $('#location_id_edit').val(response.detail.location_id)
                    $('#select_category_edit').val(response.detail.category_id)
                    $('#select_category_edit').select2().trigger('change');
                    $('#select_location_edit').val(response.detail.location_id)
                    $('#select_location_edit').select2().trigger('change');
                  
                })
            })
            onChange('select_category_edit','category_id_edit')
            onChange('select_location_edit','location_id_edit')

            $('#btn_update_product').on('click', function(){
                var data ={
                    'id':$('#productId').val(),
                    'type_id_edit':$('#type_id_edit').val(),
                    'location_id_edit':$('#location_id_edit').val(),
                    'name_edit':$('#name_edit').val(),
                    'category_id_edit':$('#category_id_edit').val(),
                }
                postCallback('updateProduct',data,function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#editProductModal').modal('hide')
                    getCallback('getProduct',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Edit Product

        // Edit Buffer
            $('#product_table').on('click','.editBufferProduct', function(){
                var data ={
                    'product_code' :$(this).data('code')
                }
                getCallback('logBufferProduct',data,function(response){
                    swal.close()
                    $('#bufferId').val(response.detail.product_code)
                    $('#buffer_name').val(response.detail.name)
                    $('#buffer_min').val(response.detail.min_quantity)
                    $('#buffer_max').val(response.detail.max_quantity)
                    $('#buffer_max_uom').html(response.detail.uom)
                    $('#buffer_min_uom').html(response.detail.uom)

                    mappingBufferLogTable(response.data)
                })
            })
            $('#btn_update_buffer').on('click', function(){
                var data={
                    'product_code' : $('#bufferId').val(),
                    'buffer_min' : $('#buffer_min').val(),
                    'buffer_max' : $('#buffer_max').val(),
                }
                postCallbackNoSwal('updateBuffer',data,function(response){
                    toastr['success'](response.meta.message);
                    mappingBufferLogTable(response.data)
                })
            })
        // Edit Buffer
            
        // History Product
            $('#product_table').on('click', '.history', function(){
                var id = $(this).data('id')
                $('#history_id').val(id)
                $('#request_type').val(1)
                var data ={
                    'product_id'    : $('#history_id').val(),
                    'from'          : $('#from').val(),
                    'to'            : $('#to').val(),
                    'request_type'  : $('#request_type').val()
                }
                getCallback('trackRequestHistory', data, function(response){
                    swal.close()
                   mappingTableHistory('in_table', response.data)
                })
            })

            $('#custom-tabs-one-home-tab').on('click', function(response){
                $('#request_type').val(1)
                var data ={
                    'product_id'    : $('#history_id').val(),
                    'from'          : $('#from').val(),
                    'to'            : $('#to').val(),
                    'request_type'  : $('#request_type').val()
                }
                getCallback('trackRequestHistory', data, function(response){
                    swal.close()
                   mappingTableHistory('in_table', response.data)
                })

            })
            $('#custom-tabs-one-profile-tab').on('click', function(response){
                $('#request_type').val(4)
                var data ={
                    'product_id'    : $('#history_id').val(),
                    'from'          : $('#from').val(),
                    'to'            : $('#to').val(),
                    'request_type'  : $('#request_type').val()
                }
                getCallback('trackRequestHistory', data, function(response){
                    swal.close()
                   mappingTableHistory('out_table', response.data)
                })
            })

            $('#from').on('change', function(){
                var request_type = $('#request_type').val()
                var data ={
                    'product_id'    : $('#history_id').val(),
                    'from'          : $('#from').val(),
                    'to'            : $('#to').val(),
                    'request_type'  : $('#request_type').val()
                }
                getCallback('trackRequestHistory', data, function(response){
                    swal.close()
                    request_type == 1 ? mappingTableHistory('in_table', response.data) :  mappingTableHistory('out_table', response.data)
                  
                })
            })
            $('#to').on('change', function(){
                var request_type = $('#request_type').val()
                var data ={
                    'product_id'    : $('#history_id').val(),
                    'from'          : $('#from').val(),
                    'to'            : $('#to').val(),
                    'request_type'  : $('#request_type').val()
                }
                getCallback('trackRequestHistory', data, function(response){
                    swal.close()
                    request_type == 1 ? mappingTableHistory('in_table', response.data) :  mappingTableHistory('out_table', response.data)
                  
                })
            })
        // History Product

        // Export Product
            $('#btn_export_product').on('click', function(){
               
                    var select_category_filter =  $('#select_category_filter').val() 
                    var select_location_filter =  $('#select_location_filter').val()

                    var location = select_location_filter !== '' ?select_location_filter :0 
                    var category = select_category_filter !== '' ?select_category_filter :0 
                
                window.open(`exportMasterProductReport/${location}/${category}`, '_blank');
            })
            $('#btn_export_excell').on('click', function () {
                var select_category_filter = $('#select_category_filter').val();
                var select_location_filter = $('#select_location_filter').val();

                var location = select_location_filter !== '' ? select_location_filter : 0;
                var category = select_category_filter !== '' ? select_category_filter : 0;

                window.open(`exportExcellMasterProduct/${location}/${category}`, '_blank');
                // Redirect to export route
            });

        // Export Product
    
    // Operation
    

    // Function
        function mappingTable(response){
            var data =''
            $('#product_table').DataTable().clear();
            $('#product_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var editBuffer =` <button title="Edit Buffer" class="editBufferProduct btn btn-sm btn-secondary rounded" data-code="${response[i]['product_code']}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBufferProductModal">
                                            <i class="fas fa-solid fa-gears"></i>
                                        </button>`
                        
                        data += `<tr style="text-align: center;">
                                <td style="width:1%">${i + 1}</td>
                                <td style="width:10%;text-align:left">${response[i].product_code}</td>
                                <td style="width:10%">${response[i].location_relation.name}</td>
                                <td style="width:25%;text-align:left">${response[i].name}</td>
                                <td style="width:10%;text-align:left">${response[i].type_relation.name}</td>
                                <td style="width:10%;text-align:left">${response[i].category_relation.name}</td>
                                <td style="width:10%;text-align:left">${response[i].department_relation.name}</td>
                                <td style="width:5%;text-align:right">${response[i].quantity}</td>
                                <td style="width:5%;text-align:center">${response[i].uom}</td>
                                @can('get-only_staff-master_product')
                                <td style="width:10%;text-align:center">
                                        <button title="Detail" class="editProduct btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editProductModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        ${editBuffer}
                                        <button title="History Product" class="history btn btn-sm btn-info rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#historyProductModal">
                                            <i class="fas fa-solid fa-clock-rotate-left"></i>
                                        </button>
                                </td>
                                @endcan
                            </tr>
                            `;
                    }
            $('#product_table > tbody:first').html(data);
           var table =  $('#product_table').DataTable({
                scrollX  : false,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
            })
            autoAdjustColumns(table)
        
        }
        function mappingBufferLogTable(response){
            $('#log_buffer_table').DataTable().clear();
            $('#log_buffer_table').DataTable().destroy();

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
                                    <td>${date} ${time}</td>
                                    <td style="text-align:left">${response[i].user_relation.name}</td>
                                    <td>${response[i].buffer_min_before}</td>
                                    <td>${response[i].buffer_min_after}</td>
                                    <td>${response[i].buffer_max_before}</td>
                                    <td>${response[i].buffer_max_after}</td>
                                    <td>${response[i].uom}</td>
                                </tr>
                            `;
                    }
            $('#log_buffer_table > tbody:first').html(data);
            $('#log_buffer_table').DataTable({
                scrollX  : true,
                order: [[0, 'desc']]
            }).columns.adjust()
        }

        function mappingTableHistory(name , response){
            var data =''
            $('#'+name).DataTable().clear();
            $('#'+name).DataTable().destroy();

            var data = '';
            for (var i = 0; i < response.length; i++) {
                const d = new Date(response[i].created_at);
                console.log(response[i].item_relation)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];

                data += `<tr style="text-align: center;">
                            <td style="width:10%">${date} ${time}</td>
                            <td style="width:10%">${response[i].request_code}</td>
                            <td style="width:10%;text-align:left">${response[i].item_relation.name}</td>
                            <td style="width:10%;text-align:left">${response[i].location_relation.name}</td>
                            <td style="width:10%;text-align:left">${response[i].des_location_relation.name}</td>
                            <td style="width:5%">${response[i].quantity}</td>
                            <td style="width:5%">${response[i].quantity_request}</td>
                            <td style="width:5%">${response[i].quantity_result}</td>
                            <td style="width:5%;text-align:center">${response[i].item_relation.uom}</td>
                            <td style="width:40%;text-align:left">${response[i].transaction_relation.user_relation.name}</td>
                        </tr>`;
            }

            $(`#${name}> tbody:first`).html(data);

            var table = $('#'+name).DataTable({
                scrollX: true,
                ordering: true,
                language: {
                    'paginate': {
                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                        'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                columns: [
                    { type: 'datetime' }, // Assuming the first column is date-like
                    null, // Assuming other columns don't need special sorting
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ]
            });
            autoAdjustColumns(table)
        
        }
    // Function
</script>