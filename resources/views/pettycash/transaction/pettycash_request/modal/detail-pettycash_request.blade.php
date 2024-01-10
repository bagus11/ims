<div class="modal fade" id="detailPettycashRequst">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Detail PettyCash Request</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
         
                <div class="modal-body">
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Form Transaction</legend>
                        <div class="mx-4">
                            <div class="row">
                                <div class="col-2">
                                    <p> PC Code </p>
                                </div>
                                <div class="col-4">
                                    <p id="pc_code_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> Status</p>
                                </div>
                                <div class="col-4">
                                    <p id="status_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> Request By</p>
                                </div>
                                <div class="col-4">
                                    <p id="request_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> PIC</p>
                                </div>
                                <div class="col-4">
                                    <p id="pic_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> Category</p>
                                </div>
                                <div class="col-4">
                                    <p id="category_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> Attachment</p>
                                </div>
                                <div class="col-4">
                                    <p id="attachment_label"></p>
                                </div>
                                <div class="col-2">
                                    <p>Location</p>
                                </div>
                                <div class="col-4">
                                    <p id="loc_label"></p>
                                </div>
                                <div class="col-2" id="ca_label">
                                    <p>Current Approval</p>
                                </div>
                                <div class="col-4">
                                    <p id="current_approval_label"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <p> Remark</p>
                                </div>
                                <div class="col-9">
                                    <p id="remark_label"></p>
                                    <input type="hidden" id="pc_code_id">
                                </div>
                                <div class="col-1">
                                    <div class="btn-group" style="float:right">
                                        <button type="button" class="btn btn-tool btn-info dropdown-toggle" id="btn_history_remark" title="Remark History" style="margin-top:3px" data-toggle="dropdown">
                                            <i class="fa-solid fa-comments"></i>
                                        </button>
                                        <input type="hidden" name="pc_code_id" id="pc_code_id">
                                        <div class="dropdown-menu dropdown-menu-left" role="menu" style="width: 390px !important">
                                            <div class="container">
                                                <div class="mx-auto mb-4 mt-4">
                                                    <div class="loader" id="loading" hidden></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-12">
                                                        <div class="direct-chat-messages" id="logMessage">
        
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                  </fieldset>
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Detail Transaction</legend>
                       <div class="mx-4">
                        <table class="datatable-bordered nowrap display" id="detail_req_table" style="width: 100% !important">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Category</th>
                                    <th  style="text-align: center">Amount</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="mx-4" id="detail_transaction_card">
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <p>Amount Request</p>
                                </div>
                                <div class="col-3">
                                    <p id="amount_req_label"></p>
                                </div>
                                <div class="col-3">
                                    <p>Approved Amount</p>
                                </div>
                                <div class="col-3">
                                    <p id="approved_amount_label"></p>
                                </div>
                                <div class="col-3">
                                    <p>Start Date</p>
                                </div>
                                <div class="col-3">
                                    <p id="start_date_label"></p>
                                </div>
                                <div class="col-3">
                                    <p>End Date</p>
                                </div>
                                <div class="col-3">
                                    <p id="end_date"></p>
                                </div>
                            </div>
                        </div>
                       
                       </div>
                  </fieldset>
                </div>
                <div class="modal-footer justify-content-end">
                  
                </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog{
        overflow-y: initial 
    }
    .modal-body{
        overflow-y : auto
    }
    
</style>