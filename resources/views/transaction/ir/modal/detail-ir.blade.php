<div class="modal fade" id="detailTransacrionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Detail Transaction</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="your_path" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> General Transaction</legend>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Transaction Code</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="detail_transaction_code"></span>
                                    </div>
        
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Source Location</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="detail_location_id"></span>
                                    </div>
        
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Product</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="detail_product"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Quantity Request</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="detail_quantity_request"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Destination Location</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="detail_des_location"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Attachment</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                       <div id="detail_attachment"></div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">PIC</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="detail_user_id"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Current Approval</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="detail_approval_id"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Status</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="detail_status"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Last Remark</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <textarea name="detail_comment" class="form-control" disabled id="detail_comment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Log Transaction</legend>
                            <div class="container">
                                <table class="datatable-bordered nowrap display" id="ir_detail_table">
                                    <thead>
                                        <tr>
                                            <th  style="text-align: center">Created At</th>
                                            <th  style="text-align: center">PIC</th>
                                            <th  style="text-align: center">Status</th>
                                            <th  style="text-align: center">Status Approval</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                   
                </div>
            </form>
        </div>
    </div>
</div>

