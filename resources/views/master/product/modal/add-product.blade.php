
<div class="modal fade" id="addProductModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add Product
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
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block name_error"></span>
                        </div>
                       
                        <div class="col-md-2 mt-2">
                            <p>Location</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_location" class="select2" id="select_location"></select>
                            <input type="hidden" class="form-control" id="location_id">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block location_id_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Department</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_department" class="select2" id="select_department"></select>
                            <input type="hidden" class="form-control" id="department_id">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block department_id_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Type</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_type" class="select2" id="select_type"></select>
                            <input type="hidden" class="form-control" id="type_id">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block type_id_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Category</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_category" class="select2" id="select_category"></select>
                            <input type="hidden" class="form-control" id="category_id">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block category_id_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>UOM</p>
                        </div>
                        <div class="col-md-4">
                            <select name="select_uom" class="select2" id="select_uom">
                                <option value="">Choose UOM</option>
                                <option value="pcs">pcs</option>
                                <option value="rim">rim</option>
                                <option value="liter">liter</option>
                                <option value="box">box</option>
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                                <option value="box">box</option>
                                <option value="cm">cm</option>
                                <option value="roll">roll</option>
                            </select>
                            <input type="hidden" id="uom_id">
                            <span  style="color:red;font-size:9px;" class="message_error text-red block uom_id_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Quantity</p>
                         </div>
                         <div class="col-md-4">
                             <input type="text" class="form-control" id="quantity">
                             <span  style="color:red;font-size:9px;" class="message_error text-red block quantity_error"></span>
                         </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_product" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>