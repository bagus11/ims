
<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Add Category</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>Type</p>
                        </div>
                        <div class="col-md-8">
                            <select name="select_type" class="select2" id="select_type"></select>
                            <input type="hidden" class="form-control" id="type_id">
                            <span  style="color:red;" class="message_error text-red block type_id_error"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>Department</p>
                        </div>
                        <div class="col-md-8">
                            <select name="select_department" class="select2" id="select_department"></select>
                            <input type="hidden" class="form-control" id="department_id">
                            <span  style="color:red;" class="message_error text-red block department_id_error"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>Name</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;" class="message_error text-red block name_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_category" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>