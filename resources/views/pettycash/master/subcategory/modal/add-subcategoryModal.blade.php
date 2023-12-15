
<div class="modal fade" id="addSubCategoryModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add SubCategory</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row px-1">
                      <div class="col-3 mt-2">
                        <p>Category</p>
                      </div>
                      <div class="col-md-8">
                        <select name="select_category" class="select2" id="select_category"></select>
                        <input type="hidden" class="form-control" id="category_id">
                        <span  style="color:red;" class="message_error text-red block category_id_error"></span>
                      </div>
                    </div>
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

            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_sub_category" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>