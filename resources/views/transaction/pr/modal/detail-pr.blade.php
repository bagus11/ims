<div class="modal fade" id="detailTransacrionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Detail Transaction
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
                                        <span style="font-size:11px">Additional Info</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <textarea name="detail_comment" class="form-control" disabled id="detail_comment"></textarea>
                                    </div>
                                </div>
                              
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Detail Item </legend>
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <table class="datatable-bordered nowrap display" id="detail_item_table">
                                        <thead>
                                            <tr>
                                                <th rowspan="2"  style="text-align: center">No</th>
                                                <th rowspan="2"  style="text-align: center">Item Name</th>
                                                <th colspan="3"  style="text-align: center">Quantity</th>
                                                <th rowspan="2"  style="text-align: center">UOM</th>
                                            </tr>
                                            <tr>
                                                <th>Current</th>
                                                <th>Request</th>
                                                <th>Result</th>
                                            </tr>
                                        </thead>
                                    </table>
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

