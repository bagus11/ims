<div class="modal fade" id="editBufferProductModal">
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
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> General Item</legend>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                           <p>Name</p>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" id="bufferId">
                            <input type="text" class="form-control" id="buffer_name">
                            <span  style="color:red;" class="message_error text-red block buffer_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <p>Min Quantity</p>
                        </div>
                        <div class="col md-2">
                            <input type="text" class="form-control" style="text-align: center" id="buffer_min">
                            <span  style="color:red;" class="message_error text-red block buffer_min_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p id="buffer_min_uom"> pcs</p>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p>Max Quantity</p>
                        </div>
                        <div class="col md-2">
                            <input type="text" class="form-control" style="text-align: center" id="buffer_max">
                            <span  style="color:red;" class="message_error text-red block buffer_max_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p id="buffer_max_uom"> pcs</p>
                        </div>
                    </div>
                </fieldset>
               
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> Log Quantity Item </legend>
                            <table class="datatable-bordered nowrap display" id="log_buffer_table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" rowspan="2">Created At</th>
                                        <th style="text-align: center" rowspan="2">User</th>
                                        <th style="text-align: center" colspan="2">Min Quantity</th>
                                        <th style="text-align: center" colspan="2">Max Quantity</th>
                                        <th style="text-align: center" rowspan="2">UOM</th>

                                    </tr>
                                    <tr>
                                        <th style="text-align: center">Before</th>
                                        <th style="text-align: center">Current</th>
                                        <th style="text-align: center">Before</th>
                                        <th style="text-align: center">Current</th>
                                    </tr>
                                </thead>
                            </table>
                    </fieldset>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_buffer" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>