<div class="modal fade" id="addPettycashRequst">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add PettyCash Request</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> Form Transaction</legend>
                        <div class="row">
                            <div class="col-2 mt-2">
                                <p>Category</p>
                            </div>
                            <div class="col-md-4">
                                <select name="select_category" class="select2" id="select_category"></select>
                                <input type="hidden" id="category_id">
                                <input type="hidden" id="total_array">
                                <span  style="color:red;" class="message_error text-red block category_id_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Max Transaction</p>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="max_transaction" disabled>
                                <input type="hidden" class="form-control" id="max_transaction_str">
                                
                            </div>
                            <div class="col-2 mt-2">
                                <p>Sub Category</p>
                            </div>
                            <div class="col-md-4">
                                <select name="select_subcategory" class="select2" id="select_subcategory">
                                    <option value="">Select Category First</option>
                                </select>
                                <input type="hidden" id="subcategoryId">
                                <input type="hidden" id="arraySubCategory">
                            </div>
                            <div class="col-2 mt-2">
                                <p>Amount</p>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="amount">
                                <span  style="color:red;" class="message_error text-red block amount_error"></span>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success btn-sm" style="float: right" type="button" id="btn_array_pc">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-success btn-sm" style="float: right" type="button" id="btn_update_array_pc">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="container">
                            <table class="datatable-bordered nowrap display" id="pc_req_table">
                                <thead>
                                    <tr>
                                        <th  style="text-align: center">No</th>
                                        <th  style="text-align: center">Category</th>
                                        <th  style="text-align: center">Amount</th>
                                        <th  style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </fieldset>

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> Form Attachment</legend>
                        <div class="row">
                            <div class="col-2 mt-2">
                                <p>PIC</p>
                            </div>
                            <div class="col-md-4">
                                <select name="select_pic" class="select2" id="select_pic"></select>
                                <input type="hidden" id="pic_id">
                            </div>
                            <div class="col-2 mt-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control" id="attachment">
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
                    </fieldset>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_category_pc" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
  .modal-dialog {
        overflow-y: auto !important; 
    }
    .modal-body {
        overflow-y: auto !important;
    }
    
</style>