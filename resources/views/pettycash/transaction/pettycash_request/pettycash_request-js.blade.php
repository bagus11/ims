<script>
    var array_item = []
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
                $('#attachment').val('')
                getActiveItemTransaction('getActiveCategoryPC',null,'select_category', 'Category')
            })
            $('#select_category').on('change', function(){
                var max_transaction = $("#select_category").select2().find(":selected").data("max")
                var rupiah = formatRupiah(max_transaction)
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
                $('#pc_req_table').prop('hidden', false)
                var subcategory = $("#select_subcategory").select2().find(":selected").data("name");
                console.log(subcategory)
                var amount = $('#amount').val()
              
               
                if(amount =='' || subcategory == ''){
                    toastr['error']('subcategory or amount cannot be null');
                    return false
                }else{
                    var test = array_item.some(el => el.subcategory == subcategory)
                   
                    if(test == true){
                        toastr['error']('item is already exist');
                        return false
                    }else{
                        var post_array ={
                            'subcategory'         : subcategory,
                            'amount'            : amount,
                        }
                        array_item.push(post_array)
                        mappingArrayTable(array_item)
                    }
                }
            })
          
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
                $('#pc_req_table').DataTable().clear();
                $('#pc_req_table').DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                           
                            data += `<tr style="text-align: center;">
                                  
                                    <td style="text-align:center;">${i + 1}</td>
                                    <td style="text-align:left;width:50%">${response[i].subcategory}</td>
                                    <td style="text-align:center;">${response[i].amount}</td>
                                    <td style ="text-align:center">
                                        <button class="btn btn-sm btn-info editListItem" data-id ="${i}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteListItem" data-id ="${i}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                     
                                    </td>
                                </tr>
                                `;
                        }
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