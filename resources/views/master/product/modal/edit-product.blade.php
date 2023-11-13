<div class="modal fade" id="editProductModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Edit Product</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                           <p>Name</p>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" id="productId">
                            <input type="text" class="form-control" id="name_edit">
                            <span  style="color:red;" class="message_error text-red block name_edit_error"></span>
                        </div>

                        <div class="col-md-2 mt-2">
                            <p>Type</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_type_edit" class="select2" id="select_type_edit"></select>
                            <input type="hidden" class="form-control" id="type_id_edit">
                            <span  style="color:red;" class="message_error text-red block type_id_edit_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Category</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_category_edit" class="select2" id="select_category_edit"></select>
                            <input type="hidden" class="form-control" id="category_id_edit">
                            <span  style="color:red;" class="message_error text-red block category_id_edit_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Location</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_location_edit" class="select2" id="select_location_edit"></select>
                            <input type="hidden" class="form-control" id="location_id_edit">
                            <span  style="color:red;" class="message_error text-red block location_id_edit_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_product" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>