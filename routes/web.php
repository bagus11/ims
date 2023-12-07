<?php

use App\Http\Controllers\Master\MasterApproverController;
use App\Http\Controllers\Master\MasterCategoryController;
use App\Http\Controllers\Master\MasterProductController;
use App\Http\Controllers\Master\MasterTypeController;
use App\Http\Controllers\PettyCash\Master\MasterCategoryPCController;
use App\Http\Controllers\PettyCash\Master\MasterPettyCashController;
use App\Http\Controllers\PettyCash\Master\MaterApproverPCController;
use App\Http\Controllers\Setting\RolePermissionController;
use App\Http\Controllers\Setting\UserAccessController;
use App\Http\Controllers\Transaction\AssignmentController;
use App\Http\Controllers\Transaction\ItemRequestController;
use App\Http\Controllers\Transaction\PurchaseRequestController;
use App\Http\Controllers\Transaction\TransactionProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SettingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // IMS 
        // Setting
            // Role & Permission 
                Route::get('role_permission', [RolePermissionController::class, 'index'])->name('role_permission');
                Route::get('getRole', [RolePermissionController::class, 'getRole'])->name('getRole');
                Route::get('getPermission', [RolePermissionController::class, 'getPermission'])->name('getPermission');
                Route::get('deleteRole', [RolePermissionController::class, 'deleteRole'])->name('deleteRole');
                Route::post('addRole', [RolePermissionController::class, 'addRole'])->name('addRole');
                Route::get('detailRole', [RolePermissionController::class, 'detailRole'])->name('detailRole');
                Route::post('updateRole', [RolePermissionController::class, 'updateRole'])->name('updateRole');
                Route::get('permissionMenus', [RolePermissionController::class, 'permissionMenus'])->name('permissionMenus');
                Route::post('savePermission', [RolePermissionController::class, 'savePermission'])->name('savePermission');
                Route::get('deletePermission', [RolePermissionController::class, 'deletePermission'])->name('deletePermission');
            // Role & Permission 
            // User Access
                Route::get('user_access', [UserAccessController::class, 'index'])->name('user_access');
                Route::get('getRoleUser', [UserAccessController::class, 'getRoleUser'])->name('getRoleUser');
                Route::get('getUser', [UserAccessController::class, 'getUser'])->name('getUser');
                Route::post('addRoleUser', [UserAccessController::class, 'addRoleUser'])->name('addRoleUser');
                Route::get('detailRoleUser', [UserAccessController::class, 'detailRoleUser'])->name('detailRoleUser');
                Route::post('updateRoleUser', [UserAccessController::class, 'updateRoleUser'])->name('updateRoleUser');
                Route::get('getRolePermissionDetail', [UserAccessController::class, 'getRolePermissionDetail'])->name('getRolePermissionDetail');
                Route::post('saveRolePermission', [UserAccessController::class, 'saveRolePermission'])->name('saveRolePermission');
                Route::get('destroyRolePermission', [UserAccessController::class, 'destroyRolePermission'])->name('destroyRolePermission');
            // User Access
        // Setting

        // Master
            // Type
                Route::get('master_type', [MasterTypeController::class, 'index'])->name('master_type');
                Route::get('getType', [MasterTypeController::class, 'getType'])->name('getType');
                Route::get('getActiveType', [MasterTypeController::class, 'getActiveType'])->name('getActiveType');
                Route::get('detailType', [MasterTypeController::class, 'detailType'])->name('detailType');
                Route::get('deleteType', [MasterTypeController::class, 'deleteType'])->name('deleteType');
                Route::post('addType', [MasterTypeController::class, 'addType'])->name('addType');
                Route::post('updateStatusType', [MasterTypeController::class, 'updateStatusType'])->name('updateStatusType');
                Route::post('updateType', [MasterTypeController::class, 'updateType'])->name('updateType');
            // Type

            // Category
                Route::get('master_category', [MasterCategoryController::class, 'index'])->name('master_category');
                Route::get('getCategory', [MasterCategoryController::class, 'getCategory'])->name('getCategory');
                Route::get('detailCategory', [MasterCategoryController::class, 'detailCategory'])->name('detailCategory');
                Route::post('updateStatusCategory', [MasterCategoryController::class, 'updateStatusCategory'])->name('updateStatusCategory');
                Route::post('addCategory', [MasterCategoryController::class, 'addCategory'])->name('addCategory');
                Route::post('updateCategory', [MasterCategoryController::class, 'updateCategory'])->name('updateCategory');
                Route::get('deleteCategory', [MasterCategoryController::class, 'deleteCategory'])->name('deleteCategory');
                Route::get('getActiveCategory', [MasterCategoryController::class, 'getActiveCategory'])->name('getActiveCategory');
                Route::get('getLocation', [MasterCategoryController::class, 'getLocation'])->name('getLocation');
                Route::get('getActiveDepartment', [MasterCategoryController::class, 'getActiveDepartment'])->name('getActiveDepartment');
            // Category
            // Product
                Route::get('master_product', [MasterProductController::class, 'index'])->name('master_product');
                Route::get('getProduct', [MasterProductController::class, 'getProduct'])->name('getProduct');
                Route::get('getActiveProduct', [MasterProductController::class, 'getActiveProduct'])->name('getActiveProduct');
                Route::post('addProduct', [MasterProductController::class, 'addProduct'])->name('addProduct');
                Route::get('detailProduct', [MasterProductController::class, 'detailProduct'])->name('detailProduct');
                Route::get('logBufferProduct', [MasterProductController::class, 'logBufferProduct'])->name('logBufferProduct');
                Route::post('updateProduct', [MasterProductController::class, 'updateProduct'])->name('updateProduct');
                Route::post('updateBuffer', [MasterProductController::class, 'updateBuffer'])->name('updateBuffer');
            // Product
            // Approver
                Route::get('approver', [MasterApproverController::class, 'index'])->name('approver');
                Route::get('getApproval', [MasterApproverController::class, 'getApproval'])->name('getApproval');
                Route::get('detailMasterApproval', [MasterApproverController::class, 'detailMasterApproval'])->name('detailMasterApproval');
                Route::post('addMasterApproval', [MasterApproverController::class, 'addMasterApproval'])->name('addMasterApproval');
                Route::post('editMasterApproval', [MasterApproverController::class, 'editMasterApproval'])->name('editMasterApproval');
                Route::get('getStepApproval', [MasterApproverController::class, 'getStepApproval'])->name('getStepApproval');
                Route::post('updateApprover', [MasterApproverController::class, 'updateApprover'])->name('updateApprover');
                
                // Approver
                // Master
                
        // Transaction
            // Purchase Request
                Route::get('purchase_req', [PurchaseRequestController::class, 'index'])->name('purchase_req');
                Route::get('getPurchase', [PurchaseRequestController::class, 'getPurchase'])->name('getPurchase');
                Route::post('savePurchase', [PurchaseRequestController::class, 'savePurchase'])->name('savePurchase');
                Route::get('detailPurchaseTransaction', [PurchaseRequestController::class, 'detailPurchaseTransaction'])->name('detailPurchaseTransaction');
                Route::post('updateProgressPurchase', [PurchaseRequestController::class, 'updateProgressPurchase'])->name('updateProgressPurchase');

            // Purchase Request
            // Item Request  
                Route::get('item_request', [ItemRequestController::class, 'index'])->name('item_request');
                Route::get('getItemRequest', [ItemRequestController::class, 'getItemRequest'])->name('getItemRequest');
                Route::post('addTransaction', [ItemRequestController::class, 'addTransaction'])->name('addTransaction');
                Route::get('detailTransaction', [ItemRequestController::class, 'detailTransaction'])->name('detailTransaction');
                Route::post('updateProgress', [ItemRequestController::class, 'updateProgress'])->name('updateProgress');
            // Item Request
                
            // Assignment
                Route::get('assignment', [AssignmentController::class, 'index'])->name('assignment');
                Route::get('getAssignment', [AssignmentController::class, 'getAssignment'])->name('getAssignment');
                Route::post('updateAssignment', [AssignmentController::class, 'updateAssignment'])->name('updateAssignment');
            // Assignment
                
            // Hisrory Product
                Route::get('historyProduct', [TransactionProductController::class, 'index'])->name('historyProduct');
                Route::get('getHistoryProduct', [TransactionProductController::class, 'getHistoryProduct'])->name('getHistoryProduct');
                Route::get('getHistoryProductDashboard', [TransactionProductController::class, 'getHistoryProductDashboard'])->name('getHistoryProductDashboard');
                Route::get('getPICReq', [TransactionProductController::class, 'getPICReq'])->name('getPICReq');
                Route::get('print_stock_move/{from}/{date}/{productFilter}/{officeFilter}/{reqFilter}',[TransactionProductController::class, 'print_stock_move']);
                Route::get('print_ir/{request_code}',[TransactionProductController::class, 'print_ir']);
                Route::get('print_pr/{request_code}',[TransactionProductController::class, 'print_pr']);
            // Hisrory Product

            // Setting Password
            
                Route::get('setting_password', [SettingController::class, 'index'])->name('setting_password');
                Route::post('update_user', [SettingController::class, 'update_user'])->name('update_user');
                Route::post('change_password', [SettingController::class, 'change_password'])->name('change_password');
            
            // Setting Password
        // Transaction
    // IMS 
    
    // Petty Cash 
        // Master
            Route::get('master_pettycash', [MasterPettyCashController::class, 'index'])->name('master_pettycash');
            Route::get('getMasterPC', [MasterPettyCashController::class, 'getMasterPC'])->name('getMasterPC');
            Route::post('addMasterPC', [MasterPettyCashController::class, 'addMasterPC'])->name('addMasterPC');
            Route::post('activatePC', [MasterPettyCashController::class, 'activatePC'])->name('activatePC');
        // Master
        
        // Category
            Route::get('master_category_pt', [MasterCategoryPCController::class, 'index'])->name('master_category_pt');
            Route::get('getCategoryPC', [MasterCategoryPCController::class, 'getCategoryPC'])->name('getCategoryPC');
            Route::get('detailCategoryPC', [MasterCategoryPCController::class, 'detailCategoryPC'])->name('detailCategoryPC');
            Route::post('addCategoryPC', [MasterCategoryPCController::class, 'addCategoryPC'])->name('addCategoryPC');
            Route::post('activateCategoryPC', [MasterCategoryPCController::class, 'activateCategoryPC'])->name('activateCategoryPC');
            Route::post('UpdateCategoryPC', [MasterCategoryPCController::class, 'UpdateCategoryPC'])->name('UpdateCategoryPC');
            // Category
            
        // Master Approver
            Route::get('master_approver_pc', [MaterApproverPCController::class, 'index'])->name('master_approver_pc');
            Route::get('getApproverPC', [MaterApproverPCController::class, 'getApproverPC'])->name('getApproverPC');
            Route::get('addMasterApproverPC', [MaterApproverPCController::class, 'addMasterApproverPC'])->name('addMasterApproverPC');
            
        // Master Approver
    // Petty Cash 
});