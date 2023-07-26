<?php

use App\Http\Controllers\DamageRequestController;
use App\Http\Controllers\RequisitionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/map', function () {
    return view('map');
});

Auth::routes();
Route::group(['middleware'=>['auth']],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //****** Accounts ***********//
    Route::prefix(config('app.account'))->group(function () {
        Route::resource('account-type', 'App\Http\Controllers\AccountTypeController');
        Route::resource('bank-account', 'App\Http\Controllers\BankAccountController');
        Route::get('bank-deposit/{id}', 'App\Http\Controllers\BankDepositController@bankDeposit');
        Route::resource('bank-deposit', 'App\Http\Controllers\BankDepositController');
        Route::get('amount-transfer/{id}', 'App\Http\Controllers\AmountTransferController@amountTransfer');
        Route::resource('amount-transfer', 'App\Http\Controllers\AmountTransferController');
        Route::get('amount-withdraw/{id}', 'App\Http\Controllers\AmountWithdrawController@amountWithdraw');
        Route::resource('amount-withdraw', 'App\Http\Controllers\AmountWithdrawController');
        Route::get('bank-report/{id}', 'App\Http\Controllers\BankAccountController@showBankReport');
        Route::post('bank-report/{id}', 'App\Http\Controllers\BankAccountController@showBankReportFilter')->name('bank-report.filter');
        Route::post('find-chequeno-with-chequebook-id', 'App\Http\Controllers\AmountWithdrawController@findChequeNoWithChequeBookId');
        Route::resource('cheque-book', 'App\Http\Controllers\ChequeBookController');
        Route::resource('cheque-no', 'App\Http\Controllers\ChequeNoController');
        Route::resource('daily-transaction', 'App\Http\Controllers\DailyTransactionController');
        Route::post('daily-transaction', 'App\Http\Controllers\DailyTransactionController@filter')->name('transaction.filter');
        Route::get('final-report', 'App\Http\Controllers\DailyTransactionController@finalReport');
        Route::post('final-report', 'App\Http\Controllers\DailyTransactionController@finalReportFiltering')->name('final-report.filter');
        // get overall income report
        Route::get('overall-income-report', 'App\Http\Controllers\DailyTransactionController@overallIncomeReport');
        Route::post('overall-income-report', 'App\Http\Controllers\DailyTransactionController@overallIncomeReportFiltering')->name('overall-income-report.filter');
        // get overall income report
        Route::get('overall-expense-report', 'App\Http\Controllers\DailyTransactionController@overallExpenseReport');
        Route::post('overall-expense-report', 'App\Http\Controllers\DailyTransactionController@overallExpenseReportFiltering')->name('overall-expense-report.filter');
    });

    //******** Other Receive *******//
    Route::prefix(config('app.or'))->group(function () {
        Route::resource('receive-type', 'App\Http\Controllers\ReceiveTypeController');
        Route::resource('receive-sub-type', 'App\Http\Controllers\ReceiveSubTypeController');
        Route::resource('receive-voucher', 'App\Http\Controllers\ReceiveVoucherController');
        Route::get('receive-voucher-report', 'App\Http\Controllers\ReceiveVoucherController@report');
        Route::post('receive-voucher-report', 'App\Http\Controllers\ReceiveVoucherController@filter')->name('receive.filter');
        Route::post('find-receive-subtype-with-type-id', 'App\Http\Controllers\ReceiveVoucherController@findReceiveSubTypeWithType');
    });

    //******** Other Payment *******//
    Route::prefix(config('app.op'))->group(function () {
        Route::resource('payment-type', 'App\Http\Controllers\PaymentTypeController');
        Route::resource('payment-sub-type', 'App\Http\Controllers\PaymentSubTypeController');
        Route::resource('payment-voucher', 'App\Http\Controllers\PaymentVoucherController');
        Route::get('payment-voucher-report', 'App\Http\Controllers\PaymentVoucherController@report');
        Route::post('payment-voucher-report', 'App\Http\Controllers\PaymentVoucherController@filter')->name('payment.filter');
        Route::post('find-payment-subtype-with-type-id', 'App\Http\Controllers\PaymentVoucherController@findPaymentSubTypeWithType');
    });

    //******** products part *******//
    Route::prefix(config('app.product'))->group(function () {
        Route::resource('product-type', 'App\Http\Controllers\ProductTypeController');
        Route::resource('product-category', 'App\Http\Controllers\ProductCategoryController');
        Route::resource('product-sub-category', 'App\Http\Controllers\ProductSubCategoryController');
        Route::resource('product-unit', 'App\Http\Controllers\ProductUnitController');
        Route::resource('product-brand', 'App\Http\Controllers\ProductBrandController');
        Route::resource('product', 'App\Http\Controllers\ProductController');
        Route::resource('previous-stock-product', 'App\Http\Controllers\AddToPreStockController');
        Route::get('previous-stock-report', 'App\Http\Controllers\AddToPreStockController@previousStockReport')->name('previous-stock-report');
        Route::resource('stock-product', 'App\Http\Controllers\StockProductController');
        Route::get('date-wise-stock-report', 'App\Http\Controllers\StockProductController@dateWiseStockReport')->name('date-wise-stock-report');
        Route::post('date-wise-stock-report', 'App\Http\Controllers\StockProductController@dateWiseStockFilter')->name('date-wise-stock-filter');
        Route::get('stock-notify', 'App\Http\Controllers\StockProductController@stockNotify')->name('stock-notify');


        //------------------ ajax part ----------------------//
        Route::post('get-product-unit', 'App\Http\Controllers\AddToPreStockController@productUnit');
        Route::get('stock-product-chart', 'App\Http\Controllers\HomeController@stockProduct');

    });

    //******** supplier part *******//
    Route::prefix(config('app.supplier'))->group(function () {
        Route::resource('product-supplier', 'App\Http\Controllers\ProductSupplierController');
        Route::get('supplier-payment-list', 'App\Http\Controllers\ProductSupplierController@supplierDueList')->name('supplier-payment-list');
        Route::post('supplier-payment-list', 'App\Http\Controllers\ProductSupplierController@supplierPaymentStore')->name('supplier-payment-store');
        Route::get('supplier-due-report', 'App\Http\Controllers\ProductSupplierController@supplierDueReport')->name('supplier-due-report');
        Route::get('supplier-payment-report', 'App\Http\Controllers\ProductSupplierController@supplierPaymentReport')->name('supplier-payment-report');
        Route::get('supplier-payment-amendment', 'App\Http\Controllers\ProductSupplierController@supplierPaymentAmendment')->name('supplier-payment-amendment');
        Route::get('supplier-payment-edit/{id}', 'App\Http\Controllers\ProductSupplierController@paymentEdit')->name('supplier-payment-edit');
        Route::post('supplier-payment-update/{id}', 'App\Http\Controllers\ProductSupplierController@paymentUpdate')->name('supplier-payment-update');
        Route::delete('supplier-payment-destroy/{id}', 'App\Http\Controllers\ProductSupplierController@paymentDestroy')->name('supplier-payment-destroy');

        //------------------- ledger ------------------//
        Route::get('supplier-ledger/{id}', 'App\Http\Controllers\ProductSupplierController@supplierLedger')->name('supplier-ledger');
        Route::post('supplier-ledger/{id}', 'App\Http\Controllers\ProductSupplierController@supplierLedgerFilter')->name('supplier-ledger.filter');

    });

    //******** purchase part *******//
    Route::prefix(config('app.purchase'))->group(function () {
        Route::resource('product-purchase', 'App\Http\Controllers\ProductPurchaseController');
        Route::get('purchase-report', 'App\Http\Controllers\ProductPurchaseController@showReport')->name('purchase-report');
        Route::get('purchase-details/{tok}', 'App\Http\Controllers\ProductPurchaseController@purchaseDetails')->name('purchase-details');
        Route::get('purchase-amendment', 'App\Http\Controllers\ProductPurchaseController@purchaseAmendment')->name('purchase-amendment');
        
        Route::get('purchase-item-delete/{id}/{tok}', 'App\Http\Controllers\ProductPurchaseController@deletePurchaseItem')->name('purchase-item-delete');

    });

    //******** requisition part *******//
    Route::prefix(config('app.requisition'))->group(function () {
        Route::resource('requisition', 'App\Http\Controllers\RequisitionController');
        Route::put('changeStatus/{id}',[RequisitionController::class,'statusupdate'])->name('requisition.statusUpdate');
        Route::get('report',[RequisitionController::class,'report'])->name('requisition.report');
        Route::get('delete-an-item/{id}',[RequisitionController::class,'deleteAnItem'])->name('delete-an-item');
    });


    //******** damage request part *******//
    Route::prefix(config('app.damagerequest'))->group(function () {
        Route::resource('damagerequests', 'App\Http\Controllers\DamageRequestController');
        Route::put('damagerequests/changeStatus/{id}',[DamageRequestController::class,'statusupdate'])->name('damagerequests.statusUpdate');
        Route::get('report',[DamageRequestController::class,'report'])->name('damagerequests.report');
    });

    //******** asset part *******//
    Route::prefix(config('app.asset'))->group(function () {
        Route::resource('asset-type', 'App\Http\Controllers\AssetTypeController');
        Route::resource('asset-sub-type', 'App\Http\Controllers\AssetSubTypeController');
        Route::resource('asset', 'App\Http\Controllers\AssetController');
        //------------------ ajax route -----------------------//
        Route::post('get-asset-sub-type', 'App\Http\Controllers\AssetController@getSubType');
        Route::post('get-asset-type', 'App\Http\Controllers\DesignationWiseAssetController@getAssetType');
        //-------------------- designation wise asset ----------------//
        Route::resource('assign-asset', 'App\Http\Controllers\DesignationWiseAssetController');
        Route::get('assign-asset-report-details/{tok}', 'App\Http\Controllers\DesignationWiseAssetController@designationWiseAssetDetails')->name('assign-asset-report-details');
        Route::get('assign-asset-amendment', 'App\Http\Controllers\DesignationWiseAssetController@designationWiseAssetAmendment')->name('assign-asset-amendment');
    });
    
    //******** library  part *******//
    Route::prefix(config('app.library'))->group(function () {
        Route::resource('asset-type', 'App\Http\Controllers\AssetTypeController');
        Route::resource('asset-sub-type', 'App\Http\Controllers\AssetSubTypeController');
        Route::resource('asset', 'App\Http\Controllers\AssetController');
    });



    //******** users part *******//
    Route::prefix(config('app.user'))->group(function () {
        Route::resource('department', 'App\Http\Controllers\DepartmentController');
        Route::resource('designation', 'App\Http\Controllers\DesignationController');
        Route::resource('user-list', 'App\Http\Controllers\UserController');
        Route::resource('designation-wise-product', 'App\Http\Controllers\DesignationWiseProductController');
        Route::get('designation-wise-product-details/{tok}', 'App\Http\Controllers\DesignationWiseProductController@designationWiseProductDetails')->name('designation-wise-product-details');
        Route::get('designation-wise-product-amendment', 'App\Http\Controllers\DesignationWiseProductController@designationWiseProductAmendment')->name('designation-wise-product-amendment');
        Route::resource('user-role', 'App\Http\Controllers\RoleController');

    });


    //******** amendment part *******//
    Route::prefix(config('app.amendment'))->group(function () {
        Route::resource('purchase-product-edit', 'App\Http\Controllers\PurchaseProductEditController');
        Route::post('purchase-product-edit', 'App\Http\Controllers\PurchaseProductEditController@filter')->name('product-edit.filter');
        Route::resource('sell-product-edit', 'App\Http\Controllers\SellProductEditController');
        Route::post('sell-product-edit', 'App\Http\Controllers\SellProductEditController@filter')->name('sell-product-edit.filter');
        Route::resource('other-receive-amenment', 'App\Http\Controllers\OtherReceiveAmenmentController');
        Route::post('other-receive-amenment', 'App\Http\Controllers\OtherReceiveAmenmentController@filter')->name('other-receive.filter');
        Route::resource('other-payment-amenment', 'App\Http\Controllers\OtherPaymentAmenmentController');
        Route::post('other-payment-amenment', 'App\Http\Controllers\OtherPaymentAmenmentController@filter')->name('other-payment.filter');
        Route::resource('bank-deposit-amendment', 'App\Http\Controllers\BankDepositAmenmentController');
        Route::post('bank-deposit-amendment', 'App\Http\Controllers\BankDepositAmenmentController@filter')->name('bank-deposit.filter');
        Route::resource('bank-withdraw-amendment', 'App\Http\Controllers\BankWithdrawAmenmentController');
        Route::post('bank-withdraw-amendment', 'App\Http\Controllers\BankWithdrawAmenmentController@filter')->name('bank-withdraw.filter');
        Route::resource('bank-transfer-amendment', 'App\Http\Controllers\BankTransferAmenmentController');
        Route::post('bank-transfer-amendment', 'App\Http\Controllers\BankTransferAmenmentController@filter')->name('bank-transfer.filter');
        Route::resource('supplier-payment-amendment', 'App\Http\Controllers\SupplierPaymentAmenmentController');
        Route::post('supplier-payment-amendment', 'App\Http\Controllers\SupplierPaymentAmenmentController@filter')->name('supplier-payment-amendment.filter');
        Route::resource('customer-bill-amendment', 'App\Http\Controllers\CustomerBillCollectionAmenmentController');
        Route::post('customer-bill-amendment', 'App\Http\Controllers\CustomerBillCollectionAmenmentController@filter')->name('customer-bill-amendment.filter');
        
        Route::get('sell-product-amendment', 'App\Http\Controllers\SellProductEditController@sellProductReport');
        Route::get('delete-sell-products/{id}', 'App\Http\Controllers\SellProductEditController@destroy');
        Route::post('sell-product-amendment', 'App\Http\Controllers\SellProductEditController@sellProductReportFilter')->name('sell-product-amendment.filter');
        
        Route::get('purchase-product-amendment', 'App\Http\Controllers\PurchaseProductEditController@purchaseProductReport');
        Route::get('delete-purchase-products/{id}', 'App\Http\Controllers\PurchaseProductEditController@destroy');
        Route::post('purchase-product-amendment', 'App\Http\Controllers\PurchaseProductEditController@purchaseProductReportFilter')->name('purchase-product-amendment.filter');

    });


    // Setting part
    Route::put('save-site-setting/{id}', 'App\Http\Controllers\SettingController@saveSiteSetting')->name('save-site-setting');
    Route::put('save-currency-setting/{id}', 'App\Http\Controllers\SettingController@saveCurrencySetting')->name('save-currency-setting');
    Route::put('update-user-password/{id}', 'App\Http\Controllers\SettingController@updateUserPassword')->name('update-user-password');
    Route::put('update-site-theme/{id}', 'App\Http\Controllers\SettingController@saveSiteTheme')->name('update-site-theme');

    Route::get('settings', 'App\Http\Controllers\SettingController@index');


});    
Route::get('send-mail', 'App\Http\Controllers\MailController@index');

//Clear Cache facade value:
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});
//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});
//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});
//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
    return '<h1>Storage Created</h1>';
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
