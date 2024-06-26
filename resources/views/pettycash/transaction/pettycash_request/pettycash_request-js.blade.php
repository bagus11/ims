<script>
    var array_item = []
    var total = 0
    
    $('#pc_req_table').prop('hidden', true)
    $('#btn_update_array_pc').prop('hidden', true)
    // Call Function
    getCallback('getPettyCashRequest',null,function(response){
        swal.close()
            mappingTable(response.data)
    })
        getCallback('getActivePettyCashBank',null,function(response){
            $('#bank_container').empty()
            var data =''
            var color =[
                'core','danger','success','warning'
            ]
            for(i =0; i < response.data.length ; i++){
                var icon = response.data[i].location_id == 1 ?'building':'house-laptop'

                data +=`
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-${color[i]} elevation-1"><i class="fas fa-${icon}"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">${response.data[i].location_relation.initial}</span>
                                <span class="info-box-number">
                                    <small>${formatRupiah(response.data[i].total_petty_cash)}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            }
            $('#bank_container').append(data)

        })
        $('#btn_refresh').on('click', function(){
            getCallback('getPettyCashRequest',null,function(response){
                swal.close()
                mappingTable(response.data)
            })

        })
    // Call Function

    // Operation
        // Add Request
                $('#btn_add_pr').on('click', function(){
                  
                    $('#max_transaction').val('')
                    $('#category_id').val('')
                    $('#amount').val('')
                    $('#remark').val('')
                    $('#total_array').val(0)
                    $('#attachment').val('')
                    getActiveItemTransaction('getActiveCategoryPC',null,'select_category', 'Category')
                    getActiveItems('getUserDepartment',null,'select_pic', 'PIC')
                })
                $(document).ready(function(){
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
                 
                 
                })
                onChange('select_subcategory','subcategoryId')
                onChange('select_category','category_id')
                onChange('select_pic','pic_id')
                $("#amount").on({
                    keyup: function() {
                    formatCurrency($(this));
                    },
                    blur: function() { 
                    formatCurrency($(this), "blur");
                    }
                });
            // Add Array Request
                $('#btn_array_pc').on('click', function(){
                    var total_array = $('#total_array').val()
                    var max_transaction_str = $('#max_transaction_str').val()
                    var subcategory = $("#select_subcategory").select2().find(":selected").data("name");
                    var selectSubcategory = $('#select_subcategory').val()
                    var amount_string = $('#amount').val()
                    var amount = parseFloat(amount_string.replace(/,/g, ''));
                    var totalPC = parseInt(total_array) + parseInt(amount) 
                    if(subcategory =='' || amount_string == ''||selectSubcategory == ''|| selectSubcategory==undefined ){
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
                                    'subcategoryId'         : $('#subcategoryId').val(),
                                    'subcategory'           : subcategory,
                                    'amount'                : amount,
                                }
                                array_item.push(post_array)
                                mappingArrayTable('pc_req_table',array_item)
                                $('#amount').val('')
                                $('#select_subcategory').val('')
                                $('#select_subcategory').select2().trigger('change')
                            }
                        }
                    }
                })
            // Add Array Request
            // Update Array request
                $('#pc_req_table').on('click', '.edit', function(){
                    $('#btn_array_pc').prop('hidden', true)
                    $('#btn_update_array_pc').prop('hidden', false)
                    var id = $(this).data("id");
                    $('#arraySubCategory').val(id)
                    $('#select_subcategory').val(array_item[id].subcategoryId)
                    $('#select_subcategory').select2().trigger('change')
                    $('#amount').val(array_item[id].amount)
                
                });
                $('#btn_update_array_pc').on('click', function(){
                    $('#btn_update_array_pc').prop('hidden', true)
                    $('#btn_array_pc').prop('hidden', false)
                    var id = $('#arraySubCategory').val()
                    var subcategory = $("#select_subcategory").select2().find(":selected").data("name");
                    var amount_string = $('#amount').val()
                    var amount = parseFloat(amount_string.replace(/,/g, ''));
                    array_item[id].subcategory = subcategory
                    array_item[id].subcategoryId = $('#subcategoryId').val()
                    array_item[id].amount = amount

                    mappingArrayTable('pc_req_table', array_item)
                    $('#amount').val('')
                    $('#select_subcategory').val('')
                    $('#select_subcategory').select2().trigger('change')
                })
            // Update Array request
            // Delete Array Request 
                $('#pc_req_table').on('click','.delete', function(){
                        var id = $(this).data("id");
                        $('#btn_update_array_pc').prop('hidden', true)
                        $('#btn_array_pc').prop('hidden', false)
                        array_item.splice(id,1)
                        mappingArrayTable('pc_req_table', array_item)
                })
            // Delete Array Request 

            // Add Request Here
                $('#btn_save_category_pc').on('click', function(e){
                    e.preventDefault();
                    var data = new FormData();
                    data.append('attachment',$('#attachment')[0].files[0]);
                    data.append('pic_id',$('#pic_id').val())
                    data.append('category_id',$('#category_id').val())
                    data.append('remark',$('#remark').val())
                    data.append('array_item',JSON.stringify(array_item))
                
                    if(array_item.length > 0){
                        postAttachment('addPettyCashRequest',data,false,function(response){
                            swal.close()
                            $('.message_error').html('')
                            toastr['success'](response.meta.message);
                            $('#addPettycashRequst').modal('hide')
                            getCallback('getPettyCashRequest',null,function(response){
                                swal.close()
                                mappingTable(response.data)
                            })
                        })
                    }else{
                        toastr['error']('subcategory cannot be null');
                        return false
                    }
                })
            // Add Request Here 
        // Add Request

        // Edit Request 
                $('#pettycash_request_table').on('click','.edit',function(){
                    var id =$(this).data('id')
                    $('#detail_transaction_card').prop('hidden', true)
                    data ={
                        'id':id
                    }
                    getCallback('detailPettyCashRequest',data,function(response){
                        swal.close()
                        var status =''
                    if(response.detail.status ==0){
                        status ='NEW'
                    }else if(response.detail.status == 1){
                        status ='Partially Approved'
                    }else if(response.detail.status == 2){
                        status = 'On Progress'
                     
                    }else if(response.detail.status == 3){
                        status = 'On Review'
                    }else if(response.detail.status == 4){
                        status = 'Finalization'
                    }else if(response.detail.status == 5){
                        status = 'DONE'
                    }else{
                        status = 'Reject'
                    }      
                    if(response.detail.approval_id ==0){
                            $('#ca_label').prop('hidden', true)
                            $('#current_approval_label').prop('hidden', true)
                    }else{
                        $('#ca_label').prop('hidden', false)
                        $('#current_approval_label').prop('hidden', false)

                    }    
                    if(response.detail.status >= 3){
                        $('#detail_transaction_card').prop('hidden', false)
                    }   
                        var output = response.detail.attachment.split('/').pop();
                       $('#pc_code_label').html(': ' + response.detail.pc_code)
                       $('#pc_code_id').val( response.detail.pc_code)
                       $('#status_label').html(': ' + status)
                       $('#amount_req_label').html(': ' + formatRupiah(response.detail.amount))
                       $('#approved_amount_label').html(': ' + formatRupiah(response.detail.amount_approve))
                        $('#start_date_label').html(': ' + response.detail.start_date)
                        $('#end_date_label').html(': ' + response.detail.end_date)
                       $('#request_label').html(': ' + response.detail.requester_relation.name)
                       $('#pic_label').html(': ' + response.detail.pic_relation.name)
                       $('#category_label').html(': ' + response.detail.category_relation.name)
                       $('#attachment_label').html(`:  <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                            ${output}
                                        </a>`)
                        $('#remark_label').html(': ' +  response.detail.remark)
                        if(response.detail.approval_relation != null){
                            $('#current_approval_label').html(': ' +  response.detail.approval_relation.name)
                        }
                        $('#loc_label').html(': ' +  response.detail.location_relation === null ? '' : ': ' + response.detail.location_relation.name)
                        if(response.detail.status >= 3){
                            $('#detail_req_table_pi_container').prop('hidden', false)
                            $('#detail_req_table_container').prop('hidden', true)
                            mappingArrayTablePIChecking('detail_req_table_pi',response.data)
                            // console.log(response.data)
                        }else{
                            $('#detail_req_table_container').prop('hidden', false)
                            $('#detail_req_table_pi_container').prop('hidden', true)
                            mappingArrayTableDetail('detail_req_table',response.data)
                            console.log(response.data)
                        }
                    })
                })
                // Payment Instruction
                    $('#pettycash_request_table').on('click','.add-pi',function(){
                        var id =$(this).data('id')
                        $('#detail_transaction_card').prop('hidden', true)
                        data ={
                            'id':id
                        }
                        getCallback('detailPettyCashRequest',data,function(response){
                            swal.close()
                            var status =''
                            if(response.detail.status != 1 || response.detail.status != 2){
                                $('#detail_transaction_card').prop('hidden', false)
                            }
                        if(response.detail.status ==0){
                            status ='NEW'
                        }else if(response.detail.status == 1){
                            status ='Partially Approved'
                        }else if(response.detail.status == 2){
                            status = 'On Progress'
                        
                        }else if(response.detail.status == 3){
                            status = 'On Review'
                        }else if(response.detail.status == 4){
                            status = 'DONE'
                        }else{
                            status = 'Reject'
                        }      
                        if(response.detail.approval_id ==0){
                                $('#ca_label').prop('hidden', true)
                                $('#current_approval_label').prop('hidden', true)
                        }else{
                            $('#ca_label').prop('hidden', false)
                            $('#current_approval_label').prop('hidden', false)

                        }       
                        var output = response.detail.attachment.split('/').pop();
                        $('#pc_code_label_pi').html(': ' + response.detail.pc_code)
                        $('#pc_code_id_pi').val( response.detail.pc_code)
                        $('#status_label_pi').html(': ' + status)
                        $('#amount_req_label_pi').html(': ' + formatRupiah(response.detail.amount))
                        $('#approved_amount_label_pi').html(': ' + formatRupiah(response.detail.amount_approve))
                        $('#start_date_label_pi').html(': ' + response.detail.start_date)
                        $('#end_date_label_pi').html(': ' + response.detail.end_date)
                        $('#request_label_pi').html(': ' + response.detail.requester_relation.name)
                        $('#pic_label_pi').html(': ' + response.detail.pic_relation.name)
                        $('#category_label_pi').html(': ' + response.detail.category_relation.name)
                        $('#attachment_label_pi').html(`:  <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" style="color:blue;">
                                                <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                                ${output}
                                            </a>`)
                            $('#remark_label_pi').html(': ' +  response.detail.remark)
                            if(response.detail.approval_relation != null){
                                $('#current_approval_label_pi').html(': ' +  response.detail.approval_relation.name)
                            }
                            $('#loc_label_pi').html(': ' +  response.detail.location_relation === null ? '' : ': ' + response.detail.location_relation.name)
                            mappingArrayTablePI('detail_pi_table',response.data)
                        })
                    })
                    // onChange('select_paid','paid_id')
                    // Add Payment Instruction
                        $('#btn_save_pi').on('click', function(e){
                            e.preventDefault()
                            var array_amount =[]
                            
                            $('.payment_amount').each(function() {
                                array_amount.push($(this).val()); 
                            })
                            var array_attachment =[]
                            $('.attachment_pi').each(function() {
                                var files = $(this)[0].files;
                                for (var i = 0; i < files.length; i++) {
                                    array_attachment.push(files[i]);
                                }
                            });
                            var data = new FormData();
                            data.append('pc_code_id_pi',$('#pc_code_id_pi').val())
                            data.append('remark_pi',$('#remark_pi').val())
                            for (var i = 0; i < array_attachment.length; i++) {
                                data.append('attachment_pi[]', array_attachment[i]);
                            }
                            data.append('amount',JSON.stringify(array_amount));
                            postAttachment('addPaymentInstruction',data,false,function(response){
                                swal.close()
                                $('.message_error').html('')
                                toastr['success'](response.meta.message);
                                $('#paymentInstructionModal').modal('hide')
                                getCallback('getPettyCashRequest',null,function(response){
                                    swal.close()
                                    mappingTable(response.data)
                                })
                            })
                        })
                        $('#btn_history_remark_pi').on('click', function(){
                            $('#loading').prop('hidden', false)
                            var data ={
                                'pc_code' : $('#pc_code_id_pi').val()
                            }
                          
                            getCallbackNoSwal('getHistoryRemark',data, function(response){
                              
                                $('#loading').prop('hidden', true)
                                $('#logMessagePI').empty()
                                var data =''
                                for(i = 0; i < response.data.length; i++){
                                    const d = new Date(response.data[i].created_at)
                                    const date = d.toISOString().split('T')[0];
                                    const time = d.toTimeString().split(' ')[0];
                                    var auth = $('#authId').val()
                                    var name_img = response.data[i].creator_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                    data +=`
                                            <div class="direct-chat-msg ${response.data[i].creator_relation.id == $('#authId').val() ?'right':''}">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name ${response.data[i].creator_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.data[i].creator_relation == null ?'':response.data[i].creator_relation.name}</span>
                                                    <span style='font-size:9px;' class="direct-chat-timestamp ${response.data[i].creator_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                                                </div>
                                                
                                                    <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                                            
                                                <div class="direct-chat-text" style='font-size:9px;'>
                                                    ${response.data[i].remark}
                                                </div>
                                            
                                            </div>
                                    `;
                                    }
                        
                                    $('#logMessagePI').append(data)
                                    
                                })
                        })
                    // Add Payment Instruction
                // Payment Instruction
                $('#btn_history_remark').on('click', function(){
                    $('#loading').prop('hidden', false)
                    var data ={
                        'pc_code' : $('#pc_code_id').val()
                    }
                    getCallbackNoSwal('getHistoryRemark',data, function(response){
                       
                        $('#loading').prop('hidden', true)
                        $('#logMessage').empty()
                        var data =''
                        for(i = 0; i < response.data.length; i++){
                            const d = new Date(response.data[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            var auth = $('#authId').val()
                            var name_img = response.data[i].creator_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                            data +=`
                                    <div class="direct-chat-msg ${response.data[i].creator_relation.id == $('#authId').val() ?'right':''}">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name ${response.data[i].creator_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.data[i].creator_relation == null ?'':response.data[i].creator_relation.name}</span>
                                            <span style='font-size:9px;' class="direct-chat-timestamp ${response.data[i].creator_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                                        </div>
                                        
                                            <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                                    
                                        <div class="direct-chat-text" style='font-size:9px;'>
                                            ${response.data[i].remark}
                                        </div>
                                    
                                    </div>
                            `;
                            }
                
                            $('#logMessage').append(data)
                            
                        })
                })
        // Edit Request 
        // Export to PDF
                $('#pettycash_request_table').on('click','.report', function(){
                 var pc_code = $(this).data('pc')
                 window.open(`exportPI/${pc_code}`,'_blank');
                })
                $('#pettycash_request_table').on('click','.reportPC', function(){
                 var pc_code = $(this).data('pc')
                 window.open(`exportPC/${pc_code}`,'_blank');
                })
        // Export to PDF
    // Operation

    // Function
        function mappingTable(response){
            
            var data =''
                $('#pettycash_request_table').DataTable().clear();
                $('#pettycash_request_table').DataTable().destroy();

                var data=''
           
                for(i = 0; i < response.length; i++ )
                {
                            var status =''
                            var color =''
                            if(response[i].status ==0){
                                status ='NEW'
                                color = 'secondary'
                            }else if(response[i].status == 1){
                                status ='Partially Approved'
                                color = 'warning'
                            }else if(response[i].status == 2){
                                color = 'primary'
                                status = 'On Progress'
                            }else if(response[i].status == 3){
                                color = 'purple'
                                status = 'On Review'
                            }else if(response[i].status == 4){
                                color = 'orange'
                                status = 'Finalization'
                            }else if(response[i].status == 5){
                                color = 'success'
                                status = 'DONE'
                            }else{
                                status = 'Reject'
                                color = 'danger'
                            }     
                            var btnPaymentInstruction = ''
                            var btnReportPI = ''
                            var authId = $('#authId').val()
                            if(response[i].status == 2 && response[i].user_id == authId){
                                btnPaymentInstruction =` 
                                        <button title="Payment Instruction" class="add-pi btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#paymentInstructionModal">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button> `
                            }   
                            if(response[i].status == 5){
                                replace = response[i].pc_code.replaceAll('/','_');
                                btnReportPI = `
                                        <button title="Report PI" class="report btn btn-sm btn-danger rounded"data-id="${response[i]['id']}" data-pc ="${replace}" type="button">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button> 
                                `;
                            }         
                            replacePC = response[i].pc_code.replaceAll('/','_');
                            data += `<tr style="text-align: center;">
                                    
                                        <td style="text-align:center;">${response[i].pc_code}</td>
                                        <td style="text-align:left;">${response[i].category_relation.name}</td>
                                        <td style="text-align:left;">${formatRupiah(response[i].amount)}</td>
                                        <td style="text-align:center;"><b style ="font-size:13px"><span class="badge badge-${color}">${status}</span></b></td>
                                        <td style="text-align:left;">${response[i].pic_relation.name}</td>
                                        <td style="width:25%;text-align:left">
                                       
                                        <button title="Detail" class="edit btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailPettycashRequst">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button> 
                                        <button title="Report Petty Cash" class="reportPC btn btn-sm btn-success rounded"data-id="${response[i]['id']}" data-pc ="${replacePC}" type="button">
                                            <i class="fa-solid fa-print"></i>
                                        </button> 
                                        ${btnPaymentInstruction}
                                        ${btnReportPI}
                                      
                                        
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
        function mappingArrayTable(name, response) {
            var data = '';
            var total = 0;

            // Build table rows
            for (var i = 0; i < response.length; i++) {
                total += response[i].amount;
                data += `<tr style="text-align: center;">
                    <td>${i + 1}</td>
                    <td>${response[i].subcategory}</td>
                    <td>${formatRupiah(response[i].amount)}</td>
                    <td>
                        <button class="btn btn-sm btn-info edit" data-id="${i}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete" data-id="${i}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            }

            // Display total row
            var data_total = `<tr style="text-align:center;background-color:yellow">
                <td></td>
                <td style="font-weight:bold">Total</td>
                <td style="font-weight:bold">${formatRupiah(total)}</td>
                <td></td>
            </tr>`;
            data += data_total;

            // Update table content
            $('#' + name).DataTable().clear().destroy();
            $('#' + name + ' > tbody:first').html(data);
            $('#' + name).DataTable({
                scrollX: false,
                language: {
                    'paginate': {
                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                        'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                }
            }).columns.adjust();

            // Clear other form fields
            // ...
        }
        function mappingArrayTableDetail(name, response) {
            var data = '';
            var total = 0;

            // Build table rows
            for (var i = 0; i < response.length; i++) {
              
                total += response[i].amount;
                data += `<tr style="text-align: center;">
                    <td>${i + 1}</td>
                    <td style="text-align:left">${response[i].subcategory_name}</td>
                    <td style="text-align:left">${formatRupiah(response[i].amount)}</td>
                   
                </tr>`;
            }

            // Display total row
            var data_total = `<tr style="text-align:center;background-color:yellow">
                <td></td>
                <td style="font-weight:bold">Total</td>
                <td style="font-weight:bold">${formatRupiah(total)}</td>
                
            </tr>`;
            // data += data_total;

            // Update table content
            $('#' + name).DataTable().clear().destroy();
            $('#' + name + ' > tbody:first').html(data);
            $('#' + name).DataTable({
                scrollX: false,
                language: {
                    'paginate': {
                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                        'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                }
            }).columns.adjust();

            // Clear other form fields
            // ...
        }
        function mappingArrayTablePI(name,response){
            var data =''
            var total = 0
                $('#'+ name).DataTable().clear();
                $('#'+ name).DataTable().destroy();
                var data_total='';
                        for(i = 0; i < response.length; i++ )
                        {
                            total += response[i].amount
                                data += `<tr style="text-align: center;">
                                  
                                  <td style="text-align:center;">${i + 1}</td>
                                  <td style="text-align:left;width:30%">${response[i].subcategory_name}</td>
                                  <td style="text-align:left;width:20%">${formatRupiah(response[i].amount)}</td>
                                  <td style="text-align:center;">
                                    <input type="text" class="form-control payment_amount">  
                                    </td>
                                  <td style ="text-align:center">
                                    <input type="file" class="form-control attachment_pi" >
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
                              
                $('#total_array').val(total)
                $('#'+ name +' > tbody:first').html(data);
                $('#'+ name).DataTable({
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
        function mappingArrayTablePIChecking(name,response){
            var data =''
            var total = 0
            var total_payment = 0
                $('#'+ name).DataTable().clear();
                $('#'+ name).DataTable().destroy();
                var data_total='';
                        for(i = 0; i < response.length; i++ )
                        {
                            var output = response[i].attachment.split('/').pop();
                            total += response[i].subcategory_amount
                            total_payment += response[i].payment
                                data += `<tr style="text-align: center;">
                                  
                                  <td style="text-align:center;">${i + 1}</td>
                                  <td style="text-align:left;width:30%">${response[i].subcategory_name}</td>
                                  <td style="text-align:left;width:20%">${formatRupiah(response[i].subcategory_amount)}</td>
                                  <td style="text-align:left;width:20%">${formatRupiah(response[i].payment)}</td>
                                  <td style="text-align:left;width:20%">
                                    <a target="_blank" href="{{URL::asset('${response[i].attachment}')}}" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 20px;margin-top:-15px"></i>
                                            ${output}
                                        </a>
                                    </td>
                                
                              </tr>
                              `;
                        }
                        data_total= ` <tr style="text-align:center;background-color:yellow">
                                    <td></td>
                                    <td style="font-weight:bold"> Total </td>
                                    <td style="font-weight:bold !important;text-align:left">${formatRupiah(total)} </td>
                                    <td style="font-weight:bold !important;text-align:left">${formatRupiah(total_payment)} </td>
                                    <td></td>
                                    
                                </tr>`
                        data += data_total
                              
                $('#total_array').val(total)
                $('#'+ name +' > tbody:first').html(data);
                $('#'+ name).DataTable({
                    scrollX  : false,
                    language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                    ordering : false
                }).columns.adjust()
         
        }
    // Function
</script>