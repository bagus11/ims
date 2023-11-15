<script>
    //Call Function
        getCallback('getProduct',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
        getCallback('getAssignment',null,function(response){
            swal.close()
            mappingTableAssignment(response.data)
        })
        var dataDashboard = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
        getCallback('getHistoryProductDashboard',dataDashboard,function(response){
            swal.close()
            mappingTableStock(response.data)
        })
    //Call Function

    // Operation
        $('#from').on('change', function(){
            var data = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
            getCallbackNoSwal('getHistoryProductDashboard',data,function(response){
                swal.close()
                mappingTableStock(response.data)
            })
        })
        $('#to').on('change', function(){
            var data = {
            'from' : $('#from').val(),
            'to' : $('#to').val(),
        }
            getCallbackNoSwal('getHistoryProductDashboard',data,function(response){
                swal.close()
                mappingTableStock(response.data)
            })
        })
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
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:300
                
            }).columns.adjust()
        
        }
        function mappingTableAssignment(response){
            var data =''
            $('#assignment_table').DataTable().clear();
            $('#assignment_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var editBuffer =` <button title="Edit Buffer" class="editBufferProduct btn btn-sm btn-secondary rounded" data-code="${response[i]['product_code']}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBufferProductModal">
                                            <i class="fas fa-solid fa-gears"></i>
                                        </button>`
                        
                        data += `<tr style="text-align: center;">
                                    <td style="width:35%;text-align:left">${response[i].request_code}</td>
                                    <td style="text-align:left;">${response[i].user_relation.name}</td>
                                    <td style="width:15%;text-align:center">
                                        <button class="btn btn-success btn-sm">
                                            <a target="_blank" href="assignment" style="color:white;font-size:9.5px">
                                                <i class="fa-solid fa-share"></i>
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    }
            $('#assignment_table > tbody:first').html(data);
            $('#assignment_table').DataTable({
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:300
                
            }).columns.adjust()
        
        }
        function mappingTableStock(response){
            var data =''
            $('#stock_move_table').DataTable().clear();
            $('#stock_move_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    {    
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        data += `<tr style="text-align: center;">
                                    <td style="text-align:center;">${date} ${time}</td>
                                    <td style="text-align:center;">${response[i].transaction_relation.request_code}</td>
                                    <td style="text-align:left">${response[i].item_relation.name}</td>
                                    <td style="text-align:center;">${response[i].quantity_request} ${response[i].item_relation.uom}</td>

                                  
                                </tr>
                            `;
                    }
            $('#stock_move_table > tbody:first').html(data);
            $('#stock_move_table').DataTable({
                dom: 'rtip',
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                iDisplayLength:10,
                scrollY:260,
                order: [[0, 'desc']]
            }).columns.adjust()
        
        }
    // Function
</script>