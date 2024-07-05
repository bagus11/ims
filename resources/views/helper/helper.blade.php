<script>
    function saveHelper(url,data,route){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "post",
            dataType: 'json',
            async: true,
            data: data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('.message_error').html('')
                toastr['success'](response.meta.message);
                window.location = route;
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact Developer');
                }
            }
        });
    }
    function onChange(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function onChangeSelect(selectId, id){
        $('#'+selectId).on('change', function(){
            var x = $('#'+ selectId).val()
            $('#'+id).val(x)
        })
    }
    function getActiveItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    function getActiveItemTransaction(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-min ="'+ data.min_transaction +'" data-name="'+ data.name +'" data-max ="'+ data.max_transaction +'" data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    function getProductItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-uom="'+data.uom+'" data-buffer="'+ data.quantity_buffer +'" data-min="'+ data.min_quantity +'" data-max="'+ data.max_quantity +'"  data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
    
    function postCallback(route,data,callback){
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function postCallbackNoSwal(route,data,callback){
        $.ajax({
            url: route,
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            success:callback,
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    }
    function getCallback(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        beforeSend: function() {
            SwalLoading('Please wait ...');
        },
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function getCallbackNoSwal(route,data,callback){
        $.ajax({
        url: route,
        type: "get",
        dataType: 'json',
        data:data,
        success: callback,
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
            }
        }); 
    }
    function selectName(route, id, name){
            $.ajax({
            url: route,
            type: "get",
            dataType: 'json',
            async: true,
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function postAttachment(route,data,withFile,callback){
        $.ajax({
                url: route,
                type: 'POST',
                dataType: 'json',
                async: true,
                processData: withFile,
                contentType: withFile,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success:callback,
                error: function(response) {
                    $('.message_error').html('')
                    swal.close();
                    if(response.status == 500){
                        console.log(response)
                        toastr['error'](response.responseJSON.meta.message);
                        return false
                    }
                    if(response.status === 422){
                        $.each(response.responseJSON.errors, (key, val) => 
                            {
                                $('span.'+key+'_error').text(val)
                            });
                    }else{
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }
        });
    }



    // Case Mapping Table Item 
        function mappingTableItem(response,id){
            var data =''
                $('#'+id).DataTable().clear();
                $('#'+id).DataTable().destroy();
                        for(i = 0; i < response.length; i++ )
                        {
                            var result =response[i].item_relation == null ? response[i].quantity_result :response[i].item_relation.quantity + response[i].quantity_request
                           
                            data += `<tr style="text-align: center;">
                                        <td style="width:5%">${i + 1}</td>
                                        <td style="text-align:left; width:60%;">${response[i].item_relation == null ?response[i].item_name : response[i].item_relation.name}</td>
                                        <td style="text-align:right; width:10%;">${response[i].item_relation == null ? response[i].quantity : response[i].item_relation.quantity}</td>
                                        <td style="text-align:right; width:10%;">${response[i].quantity_request}</td>
                                        <td style="text-align:right; width:10%;">${result}</td>
                                        <td style="text-align:center; width:5%;">${response[i].item_relation == null ? response[i].uom : response[i].item_relation.uom}</td>
                                    </tr>
                                `;
                        }
                var table = $('#'+ id +' > tbody:first').html(data);
                $('#'+id).DataTable({
                    scrollX  : false,
                }).columns.adjust()
                autoAdjustColumns(table)
        }
    // Case Mapping Table Item 

    // Format Number
        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val =  input_val;
            
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }
        function formatRupiah(money) {
            return new Intl.NumberFormat('id-ID',
                { style: 'currency', currency: 'IDR' }
            ).format(money);
        }

        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ',';
            return rupiah.split('', rupiah.length - 1).reverse().join('');
        }
    // Format Number

    // Case Petty cash get mapping array table 
        function mappingArrayTable(name,response){
            var data =''
            var total = 0
                $('#'+ name).DataTable().clear();
                $('#'+ name).DataTable().destroy();
                var data_total='';
                
                        for(i = 0; i < response.length; i++ )
                        {
                            total += response[i].amount
                            if(name == 'detail_req_table'){
                                data += `<tr style="text-align: center;">
                                
                                <td style="text-align:center;">${i + 1}</td>
                                <td style="text-align:left;width:50%">${response[i].subcategory_name}</td>
                                <td style="text-align:center;">${formatRupiah(response[i].amount)}</td>
                            </tr>
                            `;
                            }else{
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
                        }
                        data_total= ` <tr style="text-align:center;background-color:yellow">
                                    <td></td>
                                    <td style="font-weight:bold"> Total </td>
                                    <td style="font-weight:bold">${formatRupiah(total)} </td>
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
            
                $('#quantity_product').val('')
                $('#quantity_request').val('')
                $('#select_product').val('')
                $('#select_product').select2().trigger('change')
                $('#select_category').prop('disabled', true)
                $('#select_location').prop('disabled', true)
                $('#itemListContainer').prop('hidden',false)
        }
    // Case Petty cash get mapping array table 

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function findIndexByProperty(array, property, value) {
    for (let i = 0; i < array.length; i++) {
        if (array[i][property] === value) {
            return i;
        }
    }
    return -1; // Return -1 if not found
}
    function autoAdjustColumns(table) {
        var container = table.table().container();
        var resizeObserver = new ResizeObserver(function () {
            table.columns.adjust();
        });
        resizeObserver.observe(container);
    }
    function findIndexByProperty(array, property, value) {
        for (let i = 0; i < array.length; i++) {
            if (array[i][property] === value) {
                return i;
            }
        }
        return -1; // Return -1 if not found
    }
    function convertDate(inputDate) {
    // Parse the input date string
    const dateParts = inputDate.split("-");
    const year = parseInt(dateParts[0]);
    const month = parseInt(dateParts[1]);
    const day = parseInt(dateParts[2]);

    // Create a Date object
    const date = new Date(year, month - 1, day);

    // Define month names
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Format the date
    const formattedDate = day + " " + monthNames[month - 1] + " " + year;

    return formattedDate;
}

</script>