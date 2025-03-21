<script>
    getCallback('getInventoryAdjustment',null, function(data) {
        swal.close();
        mappingTable(data.data)
    });
    $('#btn_upload_product').on('click', function(){
            getActiveItems('getLocation',null,'select_upload_location','Location')
            getActiveItems('getActiveCategory',null,'select_upload_category','Category')
            getActiveItems('getLocation',null,'select_download_location','Location')
            getActiveItems('getActiveCategory',null,'select_download_category','Category')
        })
        
        $('#btn_download_template').on('click', function(){
            var location = $('#select_download_location').val();
            var category = $('#select_download_category').val();
            window.open(`/downloadTemplateProduct/${location}/${category}`, '_blank');
        });

        $('#btn_submit_upload').on('click', function (e) {
            e.preventDefault();
            var data = new FormData($('#uploadForm')[0]);

            postAttachment('uploadProduct', data, false, function (response) {
                swal.close();
                console.log(response);

                let swalOptions = {
                    icon: 'info',
                    width: '700px',
                    confirmButtonText: 'OK'
                };

                if (response.data.total_updated > 0) {
                    let tableContent = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Name</th>
                                    <th>Quantity Before</th>
                                    <th>Quantity After</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    response.data.updated_products.forEach(product => {
                        tableContent += `
                            <tr>
                                <td>${product.product_code}</td>
                                <td>${product.name}</td>
                                <td>${product.quantity_before}</td>
                                <td>${product.quantity_after}</td>
                            </tr>
                        `;
                    });

                    tableContent += `</tbody></table>`;

                    swalOptions.title = 'Product Updated!';
                    swalOptions.html = `<p>Total updated: <strong>${response.data.total_updated}</strong></p>${tableContent}`;
                } else {
                    swalOptions.title = 'No Changes!';
                    swalOptions.text = 'No products were updated.';
                    swalOptions.icon = 'warning';
                }

                Swal.fire(swalOptions).then(() => {
                    // Tutup modal setelah swal ditutup
                    $('#uploadProductModal').modal('hide');

                    // Jalankan fungsi getCallback setelah swal ditutup
                    getCallback('getInventoryAdjustment', null, function (response) {
                        swal.close();
                        mappingTable(response.data);
                    });
                });
            });
        });

        $('#inventory_adjustment_table').on('click', '.detail', function(){
            var id = $(this).data('id');
            getCallback('detailInventoryAdjustment', {'id' : id}, function(response){
                swal.close()
                const d = new Date(response.detail.created_at)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                $('#label_transaction_code').html(': ' + response.detail.transaction_code)
                $('#label_pic').html(': ' + response.detail.user_relation.name)
                $('#label_location').html(': ' + response.detail.location_relation.name)
                $('#label_category').html(': ' + response.detail.category_relation.name)
                $('#label_created_at').html(': ' + date + ' ' + time)

                fetchAndDisplayExcel(response.detail.attachment_excel);
                let attachmentPdf = response.detail.attachment_pdf;
                let assetUrl = "{{ asset('/storage/inventory_adjustment/') }}";

                $('#label_attachment_pdf').html(`
                    <a target="_blank" href="${assetUrl}/${attachmentPdf}" class="ml-3" style="color:blue;">
                        <i class="fa-solid fa-file-pdf" style="color:#D84040"></i> ${attachmentPdf}
                    </a>
                `);
                $('#label_attachment_excel').html(`  <a target="_blank" href="{{URL::asset('/storage/inventory_adjustment/${response.detail.attachment_excel}')}}" class="ml-3" style="color:blue;">
                           <i class="fa-solid fa-file-excel" style="color:#2DAA9E"></i>
                            ${response.detail.attachment_excel}</a>`)
                $('#label_attachment_sql').html(`
                            <a href="{{ asset('storage/inventory_adjustment/${response.detail.attachment_sql}') }}" 
                            class="ml-3" style="color:blue;" download>
                                <i class="fa-solid fa-file-zipper" style="color:#00879E"></i>
                                ${response.detail.attachment_sql}
                            </a>
                        `);

            })
        })
    
        function mappingTable(response){
            var data =''
            $('#inventory_adjustment_table').DataTable().clear();
            $('#inventory_adjustment_table').DataTable().destroy();

            var data=''
                    for(i = 0; i < response.length; i++ )
                    { 
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        data += `<tr style="text-align: center;">
                                <td style="text-align:left">${date } ${time}</td>
                                <td style=""">${response[i].transaction_code}</td>
                                <td style="text-align:left">${response[i].location_relation.name}</td>
                                <td style="text-align:left">${response[i].category_relation.name}</td>
                                @can('get-only_staff-master_product')
                                <td style="text-align:center">
                                        <button title="Detail" class="detail btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailAdjustment">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                     
                                </td>
                                @endcan
                            </tr>
                            `;
                    }
            $('#inventory_adjustment_table > tbody:first').html(data);
           var table =  $('#inventory_adjustment_table').DataTable({
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
        function fetchAndDisplayExcel(excelFileName) {
            let filePath = `/storage/inventory_adjustment/${excelFileName}`;
            let currentPage = 1;
            let rowsPerPage = 10;
            let fullData = []; // Menyimpan seluruh data

            fetch(filePath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.blob(); 
                })
                .then(blob => blob.arrayBuffer()) 
                .then(data => {
                    let workbook = XLSX.read(new Uint8Array(data), { type: "array" });
                    let sheetName = workbook.SheetNames[0]; 
                    let sheet = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });

                    if (sheet.length > 0) {
                        fullData = sheet.slice(1); // Simpan semua data tanpa header

                        let searchBox = `
                            <input type="text" id="searchExcel" class="form-control mb-2" placeholder="Search...">
                        `;

                        let tableHeaders = sheet[0].map(header => `<th>${header}</th>`).join('');
                        let tableTemplate = `
                            ${searchBox}
                            <table class="table table-bordered" id="excelTable">
                                <thead>
                                    <tr>${tableHeaders}</tr>
                                </thead>
                                <tbody id="excelTableBody"></tbody>
                            </table>
                            <div class="d-flex justify-content-between">
                                <button id="prevPage" class="btn btn-sm btn-secondary">Prev</button>
                                <span id="pageInfo"></span>
                                <button id="nextPage" class="btn btn-sm btn-secondary">Next</button>
                            </div>
                        `;

                        $('#excel_data_container').html(tableTemplate);

                        function renderTable(data, page) {
                            let start = (page - 1) * rowsPerPage;
                            let end = start + rowsPerPage;
                            let tableContent = '';

                            let paginatedData = data.slice(start, end);
                            paginatedData.forEach(row => {
                                tableContent += '<tr>';
                                row.forEach(cell => {
                                    tableContent += `<td>${cell ?? ''}</td>`;
                                });
                                tableContent += '</tr>';
                            });

                            $('#excelTableBody').html(tableContent);
                            $('#pageInfo').text(`Page ${page} of ${Math.ceil(data.length / rowsPerPage)}`);

                            $('#prevPage').prop('disabled', page === 1);
                            $('#nextPage').prop('disabled', end >= data.length);
                        }

                        function filterAndRender(searchTerm) {
                            let filteredData = fullData.filter(row =>
                                row.some(cell => (cell ?? '').toString().toLowerCase().includes(searchTerm))
                            );

                            currentPage = 1; // Reset ke halaman pertama saat search
                            renderTable(filteredData, currentPage);
                        }

                        $('#searchExcel').on('keyup', function () {
                            let value = $(this).val().toLowerCase();
                            filterAndRender(value);
                        });

                        $('#prevPage').on('click', function () {
                            if (currentPage > 1) {
                                currentPage--;
                                renderTable(fullData, currentPage);
                            }
                        });

                        $('#nextPage').on('click', function () {
                            if (currentPage < Math.ceil(fullData.length / rowsPerPage)) {
                                currentPage++;
                                renderTable(fullData, currentPage);
                            }
                        });

                        renderTable(fullData, currentPage);

                    } else {
                        $('#excel_data_container').html('<p>No data found in Excel file.</p>');
                    }
                })
                .catch(error => console.error('Error loading Excel:', error));
        }



</script>