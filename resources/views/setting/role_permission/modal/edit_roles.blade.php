
<div class="modal fade" id="editRolesModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Edit Role</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>Name</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="roles_name_edit">
                            <input type="hidden" class="form-control" id="roleId">
                            <span  style="color:red;" class="message_error text-red block roles_name_edit_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_role" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>