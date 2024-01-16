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
                                    <p id="location_label"></p>
                                </div>
                                <div class="col-2" id="ca_label">
                                    <p>Current Approval</p>
                                </div>
                                <div class="col-4">
                                    <p id="current_approval_label"></p>
                                </div>
                                <div class="col-2">
                                    <p> Remark</p>
                                </div>
                                <div class="col-9">
                                    <p id="remark_label"></p>
                                </div>
                               
                            </div>
                           
                        </div>
                  </fieldset>
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Detail Transaction</legend>
                       <div class="mx-4">
                        <div class="" style="width:100% !important">
                            <div id="detail_req_table_container">
                                <table class="datatable-bordered nowrap display" id="detail_req_table" style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th  style="text-align: center">No</th>
                                            <th  style="text-align: center">Category</th>
                                            <th  style="text-align: center">Amount</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="detail_req_table_pi_container">
                                <table class="datatable-bordered nowrap display" id="detail_req_table_pi" style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th  style="text-align: center">No</th>
                                            <th  style="text-align: center">Category</th>
                                            <th  style="text-align: center">Amount</th>
                                            <th  style="text-align: center">Payment</th>
                                            <th  style="text-align: center">Attachment</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                       </div>
                  </fieldset>

                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Approval Transaction</legend>
                    <div class="mx-4">
                        <div class="row">
                            <div class="col-2 mt-2">
                                <p>Approval</p>
                            </div>
                            <div class="col-4">
                                <select name="select_approval" id="select_approval" class="select2">
                                    <option value="">Choose Approval</option>
                                    <option value="1">Approve </option>
                                    <option value="2">Reject</option>
                                </select>
                                <input type="hidden" id="approval_id">
                                <input type="hidden" id="pc_code_id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 mt-2">
                                <p>Remark</p>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" id="remark" rows="3"></textarea>
                                <span  style="color:red;" class="message_error text-red block remark_error"></span>
                            </div>
                        </div>
                        <div class="row mt-2" id="detail_transaction_card">
                            <div class="col-2 mt-2">
                                <p>Start Date</p>
                            </div>
                            <div class="col-4">
                                <div class="input-group date" id="start_date" data-target-input="nearest">
                                    <input type="text" id="start_date_input" class="form-control datetimepicker-input" data-target="#start_date"/>
                                    <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span  style="color:red;" class="message_error text-red block start_date_input_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Amount</p>
                            </div>
                            <div class="col-4">
                                <input type="currency" class="form-control" id="amount_assign" style="text-align: left">
                                <input type="hidden" class="form-control" id="amount_total_detail" style="text-align: left">
                            </div>
                        </div>
                    </div>

                  </fieldset>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-sm btn-success" id="btn_save_assignment">
                        <i class="fa-solid fa-check"></i>
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
   /* HTML: <div class="loader"></div> */
    .loader {
    width: fit-content;
    font-size: 17px;
    margin: auto;
    font-family: monospace;
    line-height: 1.4;
    font-weight: bold;
    background: 
        linear-gradient(#000 0 0) left ,
        linear-gradient(#000 0 0) right;
    background-repeat: no-repeat; 
    border-right: 5px solid #0000;
    border-left: 5px solid #0000;
    background-origin: border-box;
    position: relative;
    animation: l9-0 2s infinite;
    }
    .loader::before {
    content:"Loading";
    }
    .loader::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    width: 22px;
    height: 60px;
    background: 
    linear-gradient(90deg,#000 4px,#0000 0 calc(100% - 4px),#000 0) bottom            /22px 20px,
    linear-gradient(90deg,red  4px,#0000 0 calc(100% - 4px),red  0) bottom 10px left 0/22px 6px,
    linear-gradient(#000 0 0) bottom 3px left 0  /22px 8px,
    linear-gradient(#000 0 0) bottom 0   left 50%/8px  16px;
    background-repeat: no-repeat;
    animation: l9-1 2s infinite;
    }
    @keyframes l9-0{
    0%,25%    {background-size: 50% 100%}
    25.1%,75% {background-size: 0 0,50% 100%}
    75.1%,100%{background-size: 0 0,0 0}
    }
    @keyframes l9-1{
    25%   { background-position:bottom, bottom 54px left 0,bottom 3px left 0,bottom 0 left 50%;left:0}
    25.1% { background-position:bottom, bottom 10px left 0,bottom 3px left 0,bottom 0 left 50%;left:0}
    50%   { background-position:bottom, bottom 10px left 0,bottom 3px left 0,bottom 0 left 50%;left:calc(100% - 22px)}
    75%   { background-position:bottom, bottom 54px left 0,bottom 3px left 0,bottom 0 left 50%;left:calc(100% - 22px)}
    75.1% { background-position:bottom, bottom 10px left 0,bottom 3px left 0,bottom 0 left 50%;left:calc(100% - 22px)}
    }
    
</style>