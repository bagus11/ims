<div class="modal fade" id="addPettycashRequst">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add PettyCash Request</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Category</p>
                    </div>
                    <div class="col-md-4">
                        <select name="select_category" class="select2" id="select_category"></select>
                        <input type="hidden" id="category_id">
                        <span  style="color:red;" class="message_error text-red block category_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Max Transaction</p>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="max_transaction" disabled>
                        
                    </div>
                    <div class="col-2 mt-2">
                        <p>Amount</p>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="amount">
                        <span  style="color:red;" class="message_error text-red block amount_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-md-4">
                        <input type="file" class="form-control" id="attachment">
                    </div>
                    <div class="col-2 mt-2">
                        <p>Remark</p>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="remark" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block remark_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_category_pc" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>