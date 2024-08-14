<div class="modal fade" id="approvalTransactionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Approval Transaction
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                                    <span style="font-size:11px" id="transaction_code"></span>
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
                                    <span style="font-size:11px">Status</span>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <span style="font-size:11px" id="detail_status"></span>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <span style="font-size:11px">User</span>
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
                            </div>
                            <div class="row">
                                <div class="col-3 mt-2">
                                    <p>Additional Info</p>
                                </div>
                                <div class="col-9 mt-2">
                                    <textarea name="detail_remark" class="form-control" disabled id="detail_remark"></textarea>
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
                        <legend class="scheduler-border"> Approval Transaction</legend>
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <span style="font-size:11px">Approval</span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <select name="select_approval" class="form-select" style="font-size:11px;padding:5px;width:100%" id="select_approval">
                                    <option value="">Choose Approval</option>
                                    <option value="1">Approve</option>
                                    <option value="7">Reject</option>
                                </select>
                                <input type="hidden" id="approval_id">
                                <span  style="color:red;font-size:9px" class="message_error text-red block approval_id_error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <span style="font-size:11px">Comment</span>
                            </div>
                            <div class="col-md-9 mt-2">
                                <textarea name="approve_comment" class="summernote" id="approve_comment" cols="30" rows="10"></textarea>
                                <span  style="color:red;font-size:9px" class="message_error text-red block approve_comment_error"></span>
                            </div>
                        </div>
                    </fieldset>

                   
                 </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_approval" type="button" class="btn btn-md btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

