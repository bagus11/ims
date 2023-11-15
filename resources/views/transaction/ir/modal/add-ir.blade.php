<div class="modal fade" id="addIrModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Add Transaction</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="your_path" method="post" enctype="multipart/form-data">
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
                                        <option value="1">Request</option>
                                        <option value="2">Return</option>
                                        @can('get-only_staff-item_request')
                                            <option value="3">Disposal</option>
                                        @endcan
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
                                    <p style="font-size:9px">Product</p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_product" class="select2" id="select_product">
                                            <option value="">Choose Source Location First</option>
                                        </select>
                                        <input type="hidden" class="form-control" id="product_id">
                                        <span  style="color:red;" class="message_error text-red block product_id_error"></span>
                                    </div>
                                    {{-- @can('get-only_staff-item_request') --}}
                                        <div class="col-md-2 mt-2">
                                            <p style="font-size:9px">Current Quantity</p>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="quantity_product">
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <p style="font-size:9px" id="uom_cp">pcs</p>
                                        </div>
                                    {{-- @endcan --}}
                                    <div class="col-md-2 mt-2">
                                        <p style="font-size:9px">Transaction Quantity</p>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="quantity_request" name="quantity_request">
                                        <span  style="color:red;" class="message_error text-red block quantity_request_error"></span>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p style="font-size:9px" id="uom_pr">pcs</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Remark</p>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <textarea name="comment" class="summernote" id="comment" cols="30" rows="10"></textarea>
                                    <span  style="color:red;font-size:9px" class="message_error text-red block comment_error"></span>
                                </div>
                            </div>
                        </fieldset>
                            {{-- <div class="form-group row"> --}}
                              
                                {{-- <div class="col-md-2 offset-1 mt-2">
                                    <p style="font-size:9px">Department</p>
                                </div>
                                <div class="col-md-3">
                                    <select name="select_department" class="select2" id="select_department">
                                    </select>
                                    <input type="hidden" class="form-control" id="department_id">
                                    <span  style="color:red;" class="message_error text-red block department_id_error"></span>
                                </div> --}}
                            {{-- </div> --}}

                            {{-- <div class="form-group row">
                                <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Type</p>
                                </div>
                                <div class="col-md-3">
                                    <select name="select_type" class="select2" id="select_type">
                                    </select>
                                    <input type="hidden" class="form-control" id="type_id">
                                    <span  style="color:red;" class="message_error text-red block type_id_error"></span>
                                </div>
                               
                                <div class="col-md-2 offset-1 mt-2">
                                    <p style="font-size:9px">Category</p>
                                </div>
                                <div class="col-md-3">
                                    <select name="select_category" class="select2" id="select_category">
                                        <option value="">Select Type First</option>
                                    </select>
                                    <input type="hidden" class="form-control" id="category_id">
                                    <span  style="color:red;" class="message_error text-red block category_id_error"></span>
                                </div>
                            </div> --}}

                               
                                {{-- <div class="col-md-2 mt-2">
                                    <p style="font-size:9px">Destination Location</p>
                                </div>
                            
                                <div class="col-md-3">
                                    <select name="select_des_location" id="select_des_location" class="select2"></select>
                                    <input type="hidden" class="form-control" id="des_location_id">
                                    <span  style="color:red;" class="message_error text-red block des_location_id_error"></span>
                                </div> --}}
                                {{-- <div class="col-md-2 mt-2">
                                    Attachment
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="file" class="form-control-file" id="attachment_req">
                                    <span  style="color:red;" class="message_error text-red block attachment_req_error"></span>
                                </div> --}}
                      
                      
                       
                            
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_transaction" type="submit" class="btn btn-md btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

