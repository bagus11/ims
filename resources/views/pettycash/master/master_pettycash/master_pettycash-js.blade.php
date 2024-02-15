<script>
    // Call Fuction
        getCallback('getMasterPC',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
        $('#btn_refresh').on('click',function(){
            getCallback('getMasterPC',null,function(response){
            swal.close()
            mappingTable(response.data)
            })
        })
    // Call Fuction

    // Operation
        // Add PC
        $("#total_pc").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() { 
            formatCurrency($(this), "blur");
            }
        });
        $('#btn_add_pc').on('click', function(){
            getActiveItems('getActiveBank', null, 'select_bank','Bank')
            getActiveItems('getLocation', null, 'select_location','Location')
        })
        onChange('select_bank','bank_id')
        onChange('select_location','location_id')
        $('#btn_save_pc').on('click', function(e){
            e.preventDefault();
            const total_pc = $('#total_pc').val()
            var total_pc_string = parseFloat(total_pc.replace(/,/g, ''));
            var data = new FormData();
         

            data.append('attachment',$('#attachment')[0].files[0]);
            data.append('total_pc',total_pc_string)
            data.append('period',$('#period').val())
            data.append('bank_id',$('#bank_id').val())
            data.append('location_id',$('#location_id').val())
            data.append('no_check',$('#no_check').val())
            
            postAttachment('addMasterPC',data,false,function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addPCModal').modal('hide')
                    getCallback('getMasterPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
        })
        // Add PC
        // Update Status 
            $('#pc_table').on('change','.is_checked', function(){
                var data ={
                    'status':$(this).data('status'),
                    'no_check':$(this).data('check'),
                }
                postCallbackNoSwal('activatePC', data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getMasterPC',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
        // Update Status 
    // Operation

    // Fucntion
    function mappingTable(response){
        
        var data =''
            $('#pc_table').DataTable().clear();
            $('#pc_table').DataTable().destroy();

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
                        var output = response[i].attachment.split('/').pop();
                        data += `<tr style="text-align: center;">
                                    <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  ${response[i].status == 1 ?'checked' :''} data-check="${response[i].no_check}" data-status="${response[i].status}"></td>
                                    <td style="text-align:center;">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;">${response[i].no_check}</td>
                                    <td style="text-align:left;">${response[i].location_relation.name}</td>
                                    <td style="text-align:left;">${response[i].bank_relation.name}</td>
                                    <td style="text-align:center;">${response[i].period}</td>
                                    <td style="text-align:right;">${ formatRupiah(response[i].total_petty_cash)}</td>
                                    <td style="text-align:center;">
                                        <a target="_blank" href="{{URL::asset('${response[i].attachment}')}}" class="ml-3" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                            ${output}
                                        </a>
                                       
                                        
                                        </td>
                                </tr>
                            `;
                    }
            $('#pc_table > tbody:first').html(data);
            $('#pc_table').DataTable({
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
    // Fucntion
</script>