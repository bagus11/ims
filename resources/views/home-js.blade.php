<script>
    //Call Function
        getCallback('getProduct',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    //Call Function

    // Operation
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
                                    <td style="width:45%;text-align:left">${response[i].name}</td>
                                    <td style="width:15%;text-align:right">${response[i].quantity}</td>
                                    <td style="width:15%;text-align:center">${response[i].uom}</td>
                                </tr>
                            `;
                    }
            $('#product_table > tbody:first').html(data);
            $('#product_table').DataTable({
               
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                paginate: false,
                lengthChange: false,
                filter: true,
                info: false,
                
            }).columns.adjust()
        
        }
    // Function
</script>