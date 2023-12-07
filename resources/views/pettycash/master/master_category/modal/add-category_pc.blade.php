
<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add Role</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                    <div class="row px-1">
                        <div class="col-md-3 mt-2">
                           <p>Name</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;" class="message_error text-red block name_error"></span>
                        </div>
                        <div class="col-md-3 mt-2">
                           <p>Description</p>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="description" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block description_error"></span>
                        </div>
                    </div>
                    <div class="row px-1 mt-2">
                        <div class="col-md-3 mt-2">
                            <p>Min Transaction</p>
                         </div>
                         <div class="col-md-8">
                             <input type="currency" class="form-control" id="min_transaction" style="text-align: left">
                             <span  style="color:red;" class="message_error text-red block min_transaction_error"></span>
                         </div>
                         <div class="col-md-3 mt-2">
                            <p>Max Transaction</p>
                         </div>
                         <div class="col-md-8">
                             <input type="currency" class="form-control" id="max_transaction" style="text-align: left">
                             <span  style="color:red;" class="message_error text-red block max_transaction_error"></span>
                         </div>
                         <div class="col-md-3 mt-2">
                            <p>Duration</p>
                         </div>
                         <div class="col-2">
                             <input type="number" class="form-control" id="duration" style="text-align: left">
                             <span  style="color:red;" class="message_error text-red block duration_error"></span>
                         </div>
                         <div class="col-7 mt-2">
                            <p>day</p>
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