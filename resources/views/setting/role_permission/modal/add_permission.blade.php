
<div class="modal fade" id="addPermissionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle"> Add Permisson</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                           <p>Option</p>
                        </div>
                        <div class="col-md-8">
                            <select name="option" class="select2" style="width:100%"  id="option">
                                <option value="view">View</option>
                                <option value="get-dashboard_admin">Dashboard Admin</option>
                                <option value="get-only_user">Only User</option>
                                <option value="get-only_staff">Only Staff</option>
                                <option value="get-only_admin">Only Admin</option>
                                <option value="create">Create</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                            <input type="hidden" class="form-control" id="permission_name" >
                            <span  style="color:red;" class="message_error text-red block permission_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                         <p>Menus</p>
                        </div>
                        <div class="col-md-8">
                            <select name="menus_name" class="menus_name select2" style="width:100%" id="menus_name">
                            </select>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_permission" type="button" class="btn btn-success">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>