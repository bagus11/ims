
<div class="modal fade" id="uploadProductModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Upload Product
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-2">
                <div class="row">
                    <div class="col-6">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Download Template Excell</legend>
                            <p>Please filter location and category product first,</p>
                            <div class="row">
                                <div class="col-4 mt-2">
                                    <p>Location</p>
                                </div>
                                <div class="col-8">
                                    <select name="select_download_location" class="select2" id="select_download_location"></select>
                                </div>
                                <div class="col-4 mt-2">
                                    <p>Category</p>
                                </div>
                                <div class="col-8">
                                    <select name="select_download_category" class="select2" id="select_download_category"></select>
                                </div>
                            </div>
                            <div class="row mx-2 mt-2 d-flex justify-content-end">
                                <button class="btn rounded btn-sm btn-success" id="btn_download_template">
                                    <i class="fas fa-download"></i> Download Template
                                </button>
                            </div>
                      </fieldset>
        
                    </div>
                    <div class="col-6">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Upload Product</legend>
                            <form class="form" id="uploadForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-4 mt-2">
                                        <p>Location</p>
                                    </div>
                                    <div class="col-8">
                                        <select name="select_upload_location" class="select2" id="select_upload_location"></select>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-8">
                                        <select name="select_upload_category" class="select2" id="select_upload_category"></select>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <p>Upload File Here</p>
                                    </div>
                                    <div class="col-8">
                                        <input type="file" class="form-control upload_file" name="upload_file"  id="upload_file" accept=".xlsx">
                                        <span  style="color:red;font-size:9px;" class="message_error text-red block upload_file_error"></span>
                                    </div>
                                </div>
                                <div class="row mx-2 mt-2 d-flex justify-content-end">
                                    <button class="btn rounded btn-sm btn-success" type="submit" id="btn_submit_upload" title="upload file here">
                                        <i class="fas fa-check"></i>  Upload Product
                                    </button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            
               
            </div>
            <div class="modal-footer justify-content-end">
              
            </div>
        </div>
    </div>
</div>