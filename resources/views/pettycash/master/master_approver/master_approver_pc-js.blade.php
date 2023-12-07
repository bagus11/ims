<script>
    // Call Function
        getCallback('getApproverPC',null,function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
    // Operation

    // Function
        function mappingTable(response){
            var data =''
            $('#approver_table').DataTable().clear();
            $('#approver_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="">${i + 1}</td>
                                <td style="text-align:center;">${response[i].approval_id}</td>
                                <td style="text-align:left;">${response[i].department_relation == null ? '' :response[i].department_relation.name}</td>
                                <td style="text-align:left;">${response[i].location_relation == null ? '' :response[i].location_relation.name}</td>
                                <td style="text-align:center;">${response[i].step} step</td>
                                <td style="">
                                        <button title="Detail Master Approver" class="detail btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editApprover">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>

                                        <button title="Detail Step Approval" class="stepApproval btn btn-sm btn-primary rounded"   data-step="${response[i].step}" data-approvalid="${response[i].approval_id}" data-id="${response[i]['id']}" data-toggle="modal" data-target="#stepApprovalModal">
                                            <i class="fas fa-solid fa-user"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#approver_table > tbody:first').html(data);
            $('#approver_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
        }
    // Function
</script>