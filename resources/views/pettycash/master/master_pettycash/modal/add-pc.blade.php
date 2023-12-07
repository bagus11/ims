
<div class="modal fade" id="addPCModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add Role</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>No Check</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="no_check">
                            <span  style="color:red;" class="message_error text-red block no_check_error"></span>
                        </div>
                        <div class="col-md-3 mt-2">
                           <p>Period</p>
                        </div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" id="period" value="{{date('Y-m-d')}}">
                            <span  style="color:red;" class="message_error text-red block period_error"></span>
                        </div>
                        <div class="col-md-3 mt-2">
                           <p>Total Petty Cash</p>
                        </div>
                        <div class="col-md-8">
                            <input type="currency" class="form-control" id="total_pc" style="text-align: left">
                            <span  style="color:red;" class="message_error text-red block total_pc_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_pc" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>