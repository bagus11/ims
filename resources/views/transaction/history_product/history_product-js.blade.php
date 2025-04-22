<script>
    // $('.datatable').dataTable({
    //     processing: true,
    //     serverSide: true,
    //     // scrollX   :true,
    //     ordering    :true,
    //     responsive :true,
    //     scrollXInner:'100%',
    //     language : { processing : 'Loading' },
    //     ajax: "getHistoryProduct",
    //     columns: [
    //         {data: 'created_at', name: 'created_at'},
    //         {data: 'request_code', name: 'request_code'},
    //         {data: 'item_name', name: 'item_name'},
    //         {data: 'location_name', name: 'location_name'},
    //         {data: 'des_location_name', name: 'des_location_name'},
    //         {data: 'quantity', name: 'quantity'},
    //         {data: 'quantity_request', name: 'quantity_request'},
    //         {data: 'quantity_result', name: 'quantity_result'},
    //         {data: 'pcs', name: 'pcs'},
    //         {data: 'pic', name: 'pic'},
           
    //     ],
    //     columnDefs: [
    //         { className: "text-center", "targets": [5,6,7,8] }
    //     ],
    //     fnRowCallback: function( nRow, aData, iDisplayIndex ) {
    //         $('td', nRow).attr('nowrap','nowrap');
    //         return nRow;
    //     }
    // });

    // Call Function
        var firstData = {
            'from' :$('#from').val(),
            'to' :$('#to').val(),
            'productFilter' :$('#productFilter').val(),
            'officeFilter' :$('#officeFilter').val(),
            'reqFilter' :$('#reqFilter').val(),
        }
        getCallback('getHistoryProduct',firstData,function(response){
            swal.close()
            mappingTable(response.data)
        })
        getActiveItems('getLocation',null,'officeFilter','Office')    
        $('#officeFilter').on('change', function(){
            var data ={
                'id' : $('#officeFilter').val()
            } 
            getProductItems('getActiveProduct',data,'productFilter','Product')

        })
      
        getCallbackNoSwal('getPICReq',null,function(response){
            $('#reqFilter').empty()
            $('#reqFilter').append('<option value=""> Please Choose PIC </option>')
            $.each(response.data,function(i,data,param){
                $('#reqFilter').append('<option value="'+data.user_id+'">' + data.user_relation.name +'</option>');
            });
        })

        $('#btn_filter_stock').on('click', function(){
            var firstData = {
                'from' :$('#from').val(),
                'to' :$('#to').val(),
                'productFilter' :$('#productFilter').val(),
                'officeFilter' :$('#officeFilter').val(),
                'reqFilter' :$('#reqFilter').val(),
            }
            getCallback('getHistoryProduct',firstData,function(response){
            swal.close()
            mappingTable(response.data)
            })
        })
        $('#btn_report_stock').on('click', function(){
            var from = $('#from').val();
            var to = $('#to').val();
            var productFilter = $('#productFilter').val();
            var officeFilter = $('#officeFilter').val();
            var reqFilter = $('#reqFilter').val();

            window.open(`print_stock_move/${from}/${to}/${productFilter =='' ? '*':productFilter}/${officeFilter =='' ? '*' : officeFilter}/${reqFilter =='' ? '*' : reqFilter}`,'_blank');
        })
    // Call Function

    // Operation
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
    // Operation

    // Function
        function mappingTable(response){
            var data =''
            $('#product_table').DataTable().clear();
            $('#product_table').DataTable().destroy();

            var data = '';
            for (var i = 0; i < response.length; i++) {
                const d = new Date(response[i].created_at);
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];

                data += `<tr style="text-align: center;">
                            <td style="width:10%">${date} ${time}</td>
                            <td style="width:10%">${response[i].request_code}</td>
                            <td style="width:10%;text-align:left">${response[i].item_relation?.name}</td>
                            <td style="width:10%;text-align:left">${response[i].location_relation?.name}</td>
                            <td style="width:10%;text-align:left">${response[i].des_location_relation?.name}</td>
                            <td style="width:5%">${response[i].quantity}</td>
                            <td style="width:5%">${response[i].quantity_request}</td>
                            <td style="width:5%">${response[i].quantity_result}</td>
                            <td style="width:5%;text-align:center">${response[i].item_relation?.uom}</td>
                            <td style="width:40%;text-align:left">${response[i].transaction_relation?.user_relation.name}</td>
                        </tr>`;
            }

            $('#product_table > tbody:first').html(data);

            var table = $('#product_table').DataTable({
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