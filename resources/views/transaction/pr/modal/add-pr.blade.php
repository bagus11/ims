<div class="modal fade" id="addPrModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add Transaction
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body">
                    <div class="container">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Form Transaction</legend>
                            <div class="form-group row">
                                <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Transaction Type</p>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_transaction_type" class="select2" id="select_transaction_type">
                                        <option value="">Choose Request Type</option>
                                        <option value="4">Purchase</option>
                                    </select>
                                    <input type="hidden" class="form-control" id="transaction_id">
                                    <span  style="color:red;" class="message_error text-red block transaction_id_error"></span>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Source Location</p>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_location" class="select2" id="select_location"></select>
                                    <input type="hidden" class="form-control" id="location_id">
                                    <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                                </div>
                            
                                <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Remark</p>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <textarea name="comment" class="summernote" id="comment" cols="30" rows="10"></textarea>
                                    <span  style="color:red;font-size:9px" class="message_error text-red block comment_error"></span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Item List</legend>
                           <div class="row">
                            <div class="col-md-2 mt-2">
                                <p>Category</p>
                            </div>
                            <div class="col-md-4">
                                <select name="select_category" class="select2" id="select_category">
                                </select>
                                <input type="hidden" class="form-control" id="category_id">
                                <span  style="color:red;" class="message_error text-red block category_id_error"></span>
                            </div>
                            <div class="col-md-2 mt-2">
                                <p style="font-size:9px">Product</p>
                            </div>
                            <div class="col-md-4">
                                <select name="select_product" class="select2" id="select_product">
                                    <option value="">Choose Category First</option>
                                </select>
                                <input type="hidden" class="form-control" id="itemArrayId">
                                <input type="hidden" class="form-control" id="product_id">
                                <span  style="color:red;" class="message_error text-red block product_id_error"></span>
                            </div>
                            <div class="col-md-2 mt-2">
                                <p style="font-size:9px">Current Quantity</p>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="quantity_product">
                            </div>
                            <div class="col-md-2 mt-2">
                                <p style="font-size:9px">pcs</p>
                            </div>
                            <div class="col-md-2 mt-2">
                                <p style="font-size:9px">Transaction Quantity</p>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="quantity_request" name="quantity_request">
                                <span  style="color:red;" class="message_error text-red block quantity_request_error"></span>
                            </div>
                            <div class="col-md-1 mt-2">
                                <p style="font-size:9px">pcs</p>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-success" id="btn_add_array_item" style="float: right">
                                    <i class="fas fa-plus"></i>
                                </button>   
                                <button class="btn btn-sm btn-info" id="btn_edit_array_item" style="float: right">
                                    <i class="fas fa-edit"></i>
                                </button>   
                            </div>
                           </div>
                           <div class="row">
                            <div class="col-md-12" id="itemListContainer">
                                <table class="datatable-stepper nowrap display" id="itemListTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center" rowspan="2">No</th>
                                            <th style="text-align: center" rowspan="2">Item Name</th>
                                            <th style="text-align: center" colspan="2">Quantity</th>
                                            <th style="text-align: center" rowspan="2">UOM</th>
                                            <th style="text-align: center" rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center"> Current </th>
                                            <th style="text-align: center"> Request </th>
                                        </tr>
                                    </thead>
                                </table>
                           </div>
                           </div>

                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_transaction" type="submit" class="btn btn-md btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

