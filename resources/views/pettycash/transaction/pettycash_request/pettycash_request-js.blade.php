<script>
    var array_item = []
    var total = 0
    $('#btn_update_array_pc').prop('hidden', true)
    // Call Function
        getCallback('getPettyCashRequest',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Request
            $('#btn_add_pr').on('click', function(){
                $('#pc_req_table').prop('hidden', true)
                $('#max_transaction').val('')
                $('#category_id').val('')
                $('#amount').val('')
                $('#remark').val('')
                $('#total_array').val(0)
                $('#attachment').val('')
                getActiveItemTransaction('getActiveCategoryPC',null,'select_category', 'Category')
            })
            $('#select_category').on('change', function(){
                var max_transaction = $("#select_category").select2().find(":selected").data("max")
                var rupiah = formatRupiah(max_transaction)
                $('#max_transaction_str').val(max_transaction)
                $('#max_transaction').val(rupiah)
                var data ={
                    'id' : $('#select_category').val()
                }
                getActiveItems('getActiveSubCategory',data, 'select_subcategory', 'Sub Category')
            })
            $("#amount").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
            $('#btn_array_pc').on('click', function(){
                var total_array = $('#total_array').val()
                var max_transaction_str = $('#max_transaction_str').val()
                var subcategory = $("#select_subcategory").select2().find(":selected").data("name");
                var amount_string = $('#amount').val()
                var amount = parseFloat(amount_string.replace(/,/g, ''));
                var totalPC = parseInt(total_array) + parseInt(amount) 
                console.log(max_transaction_str +' + ' + (totalPC) + '=' + total_array )
                if(amount =='' || amount_string == ''){
                    toastr['error']('subcategory or amount cannot be null');
                    return false
                }else{
                    var test = array_item.some(el => el.subcategory == subcategory)
                   
                    if(test == true){
                        toastr['error']('item is already exist');
                        return false
                    }else{
                        
                        if( parseInt(max_transaction_str) < parseInt(totalPC) ){
                        toastr['error']('transaction cannot bigger than max transaction in this category');
                        return false
                        }else{
                            $('#pc_req_table').prop('hidden', false)
                            var post_array ={
                                'subcategory'         : subcategory,
                                'amount'            : amount,
                            }
                            array_item.push(post_array)
                            mappingArrayTable(array_item)
                            $('#amount').val('')
                            $('#select_subcategory').val('')
                            $('#select_subcategory').select2().trigger('change')
                        }
                    }
                }
            })
            // Update Array request
            $('#pc_req_table').on('click', '.edit', function(){
                $('#btn_array_pc').prop('hidden', true)
                $('#btn_update_array_pc').prop('hidden', false)
                var id = $(this).data("id");
                $('#itemArrayId').val(id)
                $('#select_product').val(array_item[id].product_id)
                $('#select_product').select2().trigger('change')
                $('#quantity_request').val(array_item[id].quantity_request)
                $('#quantity_product').val(array_item[id].current_quantity)
               
            });
            $('#btn_edit_array_item').on('click', function(){
                $('#btn_update_array_pc').prop('hidden', true)
                $('#btn_array_pc').prop('hidden', false)
                var id = $('#subcategoryId').val()
                var item_name = $("#select_product").select2().find(":selected").data("name");

                array_item[id].item_name = item_name
                array_item[id].product_id = $('#product_id').val()
                array_item[id].quantity_request = $('#quantity_request').val()
                array_item[id].quantity_product = $('#quantity_product').val()
                mappingArrayTable(array_item)

            })
            // Update Array request
        // Add Request
    // Operation

    // Function
        function mappingTable(response){
            
            var data =''
                $('#pettycash_request_table').DataTable().clear();
                $('#pettycash_request_table').DataTable().destroy();

                var data=''
           
                for(i = 0; i < response.length; i++ )
                {
                    
                            var status ='';
                            if(response[i].status == 0){
                                status ='NEW';
                            }else if(response[i].status == 1){
                                status ='Partially Approve';
                            }else if(response[i].status == 2){
                                status ='On Progress';
                            }else if(response[i].status == 3){
                                status ='DONE';
                            }else{
                                status ='REJECT';
                            }
                                                
                            data += `<tr style="text-align: center;">
                                    
                                        <td style="text-align:center;">${response[i].pc_code}</td>
                                        <td style="text-align:left;">${response[i].category_relation.name}</td>
                                        <td style="text-align:left;">${formatRupiah(response[i].amount)}</td>
                                        <td style="text-align:left;">${response[i].category_relation.name}</td>
                                        <td style="text-align:left;">${status}</td>
                                        <td style="text-align:left;">${response[i].pic_relation.name}</td>
                                        <td style="width:25%;text-align:center">
                                        
                                        <button title="Detail" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editCategoryModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button> 
                                        
                                </td>
                                    </tr>
                                `;
                        }
                $('#pettycash_request_table > tbody:first').html(data);
                $('#pettycash_request_table').DataTable({
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
        function mappingArrayTable(response){
            var data =''
            var total = 0
                $('#pc_req_table').DataTable().clear();
                $('#pc_req_table').DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                            var data_total='';
                           total += response[i].amount
                            data += `<tr style="text-align: center;">
                                  
                                    <td style="text-align:center;">${i + 1}</td>
                                    <td style="text-align:left;width:50%">${response[i].subcategory}</td>
                                    <td style="text-align:center;">${formatRupiah(response[i].amount)}</td>
                                    <td style ="text-align:center">
                                        <button class="btn btn-sm btn-info edit" data-id ="${i}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete" data-id ="${i}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                `;
                        }
                        data_total= ` <tr style="text-align:center;background-color:yellow">
                                    <td></td>
                                    <td style="font-weight:bold"> Total </td>
                                    <td style="font-weight:bold">${formatRupiah(total)} </td>
                                    <td></td>
                                    
                                </tr>`
                                data += data_total
                $('#total_array').val(total)
                $('#pc_req_table > tbody:first').html(data);
                $('#pc_req_table').DataTable({
                    scrollX  : false,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                    ordering : false
                }).columns.adjust()
              
                $('#quantity_product').val('')
                $('#quantity_request').val('')
                $('#select_product').val('')
                $('#select_product').select2().trigger('change')
                $('#select_category').prop('disabled', true)
                $('#select_location').prop('disabled', true)
                $('#itemListContainer').prop('hidden',false)
        }
    // Function
</script>