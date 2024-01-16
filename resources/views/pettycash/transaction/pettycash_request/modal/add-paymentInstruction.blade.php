<div class="modal fade" id="paymentInstructionModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add Payment Instruction</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Form Transaction</legend>
                        <div class="mx-4">
                            <div class="row">
                                <div class="col-2">
                                    <p> PC Code </p>
                                </div>
                                <div class="col-4">
                                    <p id="pc_code_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p> Status</p>
                                </div>
                                <div class="col-4">
                                    <p id="status_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p> Request By</p>
                                </div>
                                <div class="col-4">
                                    <p id="request_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p> PIC</p>
                                </div>
                                <div class="col-4">
                                    <p id="pic_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p> Category</p>
                                </div>
                                <div class="col-4">
                                    <p id="category_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p> Attachment</p>
                                </div>
                                <div class="col-4">
                                    <p id="attachment_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p>Location</p>
                                </div>
                                <div class="col-4">
                                    <p id="loc_label_pi"></p>
                                </div>
                                <div class="col-2" id="ca_label_pi">
                                    <p>Current Approval</p>
                                </div>
                                <div class="col-4">
                                    <p id="current_approval_label_pi"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <p>Amount Request</p>
                                </div>
                                <div class="col-4">
                                    <p id="amount_req_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p>Approved Amount</p>
                                </div>
                                <div class="col-4">
                                    <p id="approved_amount_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p>Start Date</p>
                                </div>
                                <div class="col-4">
                                    <p id="start_date_label_pi"></p>
                                </div>
                                <div class="col-2">
                                    <p>End Date</p>
                                </div>
                                <div class="col-4">
                                    <p id="end_date_label_pi"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <p> Remark</p>
                                </div>
                                <div class="col-9">
                                    <p id="remark_label_pi"></p>
                                    <input type="hidden" id="pc_code_id_pi">
                                </div>
                                <div class="col-1">
                                    <div class="btn-group" style="float:right">
                                        <button type="button" class="btn btn-tool btn-info dropdown-toggle" id="btn_history_remark_pi" title="Remark History" style="margin-top:3px" data-toggle="dropdown">
                                            <i class="fa-solid fa-comments"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-left" role="menu" style="width: 390px !important">
                                            <div class="container">
                                                <div class="mx-auto mb-4 mt-4">
                                                    <div class="loader" id="loading" hidden></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-12">
                                                        <div class="direct-chat-messages" id="logMessagePI">
        
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
                            <table class="datatable-bordered nowrap display" id="detail_pi_table" style="width: 100% !important">
                                <thead>
                                    <tr>
                                        <th  style="text-align: center">No</th>
                                        <th  style="text-align: center">Category</th>
                                        <th  style="text-align: center">Amount Reqeuest</th>
                                        <th  style="text-align: center">Amount</th>
                                        <th  style="text-align: center">Attachment</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="row mt-2">
                                <div class="col-2 mt-2">
                                    <p>Paid By</p>
                                </div>
                                <div class="col-4">
                                    <select name="select_paid" id="select_paid" class="select2">
                                        <option value="">Choose Payment By</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Giro</option>
                                    </select>
                                    <input type="hidden" id="paid_id">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2 mt-2">
                                    <p>Remark</p>
                                </div>
                                <div class="col-10">
                                    <textarea class="form-control" id="remark_pi" rows="3"></textarea>
                                    <span  style="color:red; font-size:9px" class="message_error text-red block remark_pi_error"></span>
                                </div>
                                
                            </div>
                       </div>

                  </fieldset>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-sm btn-success" id="btn_save_pi" type="submit">
                        <i class="fas fa-check"></i>
                    </button>
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