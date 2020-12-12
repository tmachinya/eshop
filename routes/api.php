<?php

Route::group([

    'middleware' => 'api',

], function () {
//    Authentication start
    Route::post('login', 'AuthController@login');
    Route::post('create', 'AuthController@creatUsers');
    Route::post('signup', 'AuthController@signup');
    Route::get('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('users','AuthController@allUsers');
    Route::get('allRoles','AuthController@allRoles');
    Route::post('editRoles','AuthController@editRoles');
//    Authentication end here
    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    Route::post('resetPassword', 'ChangePasswordController@process');
    Route::resource('employee','EmployeeController');
    Route::post('inspection','InspectionController@insert');
    Route::post('register', 'EmployeeController@add');
    Route::get('allQR', 'QrCodesController@makeAll');
    Route::post('createProduct', 'QrCodesController@createProduct');
    Route::post('makeSale', 'QrCodesController@recordSales');
    Route::post('createStaff', 'QrCodesController@createStaff');
    Route::get('allStaff', 'QrCodesController@allStaff');
    Route::post('sync_records', 'QrCodesController@uploadScans');
    Route::get('allScans', 'QrCodesController@allScans');
    Route::resource('sales', 'SalesController');
    Route::resource('purchase', 'PurchasesController');
    Route::get('prices', 'ProductController@prices');
    Route::resource('transactions', 'TransactionController');
    Route::resource('product', 'ProductController');
    Route::get('allTransactions', 'PurchasesController@transactions');
    Route::resource('requisitions', 'RequisitionController');
    Route::get('branches', 'RequisitionController@allbranches');
    Route::get('departments', 'RequisitionController@departments');
    Route::post('section', 'RequisitionController@sectionCost');

//    updating requisitions start
    Route::post('awaiting', 'RequisitionController@awaiting');
    Route::get('waiting', 'RequisitionController@waitingApproval');
    Route::get('warehouse', 'RequisitionController@waitingWarehouse');
    Route::post('detailing', 'RequisitionController@detailsAwaiting');
    Route::post('approvals', 'RequisitionController@hodApprovals');
    Route::post('warehouseApproving', 'RequisitionController@warehouseApproving');
//    updating requisitions end

//    Expenditure
    Route::resource('expenditure', 'ExpenditureController');
    Route::get('cats', 'ExpenditureController@categories');
//    Expenditure

//    reports start
    Route::get('vanhu', 'AuthController@allStaff');
    Route::post('departmental', 'RequisitionController@departReport');
    Route::post('master', 'RequisitionController@masterReport');
//    reports end



});
