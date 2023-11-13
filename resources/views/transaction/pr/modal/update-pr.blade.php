<div class="modal fade" id="updateTransacrionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Detail Transaction
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
                                        <span style="font-size:11px">Last Remark</span>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <textarea name="update_comment" class="form-control" disabled id="update_comment"></textarea>
                                    </div>
                                </div>
                              
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Detail Item </legend>
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <table class="datatable-bordered nowrap display" id="update_item_table">
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
                   <button class="btn btn-success" id="btn_update_progress">
                    <i class="fas fa-check"></i>
                   </button>
                </div>
           
        </div>
    </div>
</div>

