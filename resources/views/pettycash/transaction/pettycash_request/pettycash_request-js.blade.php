<script>
    // Call Function
        getCallback('getPettyCashRequest',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Request
            $('#btn_add_pr').on('click', function(){
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
            })
            $("#amount").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
            $('#amount').on('change', function(){
                var max =  $("#select_category").select2().find(":selected").data("max")
                var amount =  $('#amount').val()
                var amount_v = parseFloat(amount.replace(/,/g, ''));
                if(amount_v > max){
                    $('#amount').val('')
                    toastr['warning']('amount cannot bigger than max transaction');
                    return false
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
    // Function
</script>