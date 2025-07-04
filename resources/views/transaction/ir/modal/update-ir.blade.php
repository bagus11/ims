<div class="modal fade" id="updateProgressModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Update Transaction</b>
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
                                        <input type="hidden" id="update_transaction_id">
                                        <span style="font-size:11px" id="update_transaction_code"></span>
                                    </div>
        
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Source Location</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_location_id"></span>
                                    </div>
        
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Product</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_product"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Current Quantity</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_current_quantity"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Quantity Request</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_quantity_request"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Quantity After Transaction</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_quantity_after_transaction"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Destination Location</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px" id="update_des_location"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Attachment</span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                       <div id="update_attachment"></div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">PIC</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="update_user_id"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Current Approval</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="update_approval_id"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Status</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <span style="font-size:11px" id="update_status"></span>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <span style="font-size:11px">Additional Info</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <textarea name="update_last_remark" class="form-control" disabled id="update_last_remark"></textarea>
                                    </div>
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
                                    <select name="select_update_approval_id" class="form-select" style="font-size:11px;padding:5px;width:100%" id="select_update_approval_id">
                                        <option value="">Choose Approval</option>
                                        <option value="6">Done</option>
                                        <option value="7">Reject</option>
                                    </select>
                                    <input type="hidden" id="update_approvalId">
                                    <span  style="color:red;font-size:9px" class="message_error text-red block update_approvalId_error"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <span style="font-size:11px">Remark</span>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <textarea name="update_comment" class="summernote" id="update_comment" cols="30" rows="10"></textarea>
                                    <span  style="color:red;font-size:9px" class="message_error text-red block update_comment_error"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                   <button class="btn btn-sm btn-success" type="button" id="btn_update_progress">
                    <i class="fas fa-check"></i>
                   </button>
                </div>
        </div>
    </div>
</div>

