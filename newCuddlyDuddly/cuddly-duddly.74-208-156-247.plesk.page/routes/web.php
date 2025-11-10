<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    DashboardController,
    CategoryController,
    CustomerController,
    SellerController,
    PayoutController,
    WebhookController,
    ProductController,
    BrandController,
    InventoryController,
    ReviewController,
    WishlistController,
    OrderController,
    ReturnController,
    CancellationController,
    ReportController,
    SettingController,
    RoleController,
    WebsiteController,
    BlogController,
    SEOController,
    SupportController,
    TicketController
};
use App\Http\Controllers\Seller\{
    SellerDashboardController,
    SellerOrderController,
    SellerProductController,
    SellerPayoutController,
    SellerProfileController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

/*
|--------------------------------------------------------------------------
| Authentication Routes (Admin + Seller)
|--------------------------------------------------------------------------
*/

// 🔹 ADMIN LOGIN (at /admin)
Route::get('/admin', [AdminController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login.submit');

// 🔹 SELLER LOGIN (at /seller)
Route::get('/seller', [AdminController::class, 'showSellerLoginForm'])->name('seller.login');
Route::post('/seller', [AdminController::class, 'login'])->name('seller.login.submit');

// 🔹 LOGOUTS
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/seller/logout', [AdminController::class, 'logout'])->name('seller.logout');


/*
|--------------------------------------------------------------------------
| Admin Panel (Protected by admin.auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Sellers Management
    Route::prefix('sellers')->name('admin.sellers.')->group(function () {
        Route::get('/', [SellerController::class, 'index'])->name('index');
        Route::get('/applications', [SellerController::class, 'applications'])->name('applications');
        Route::get('/{seller}/download-docs', [SellerController::class, 'viewDocs'])->name('applications.viewDocs');
        Route::get('/compliance', [SellerController::class, 'compliance'])->name('compliance');
        Route::patch('/{seller}/accept', [SellerController::class, 'KYCaccept'])->name('kyc.verify');
        Route::patch('/{seller}/reject', [SellerController::class, 'KYCreject'])->name('kyc.reject');
        Route::get('/bank/{seller}', [SellerController::class, 'bankDetails'])->name('bank');
        Route::resource('/', SellerController::class)->parameters(['' => 'seller']);
    });

    // Payouts
    Route::prefix('payouts')->name('admin.payouts.')->group(function () {
        Route::get('/', [PayoutController::class, 'index'])->name('index');
        Route::get('/create', [PayoutController::class, 'create'])->name('create');
        Route::get('/{id}', [PayoutController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PayoutController::class, 'edit'])->name('edit');
        Route::get('/{id}/update', [PayoutController::class, 'update'])->name('update');
        Route::post('/', [PayoutController::class, 'store'])->name('store');
        Route::delete('/{payout}', [PayoutController::class, 'destroy'])->name('destroy');
    });

    // Webhooks
    Route::post('webhooks/razorpayx', [WebhookController::class, 'razorpayx'])->name('admin.webhooks.razorpayx');

    // Products, Categories, Brands, Inventory
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::get('products/{id}/quick-view', [ProductController::class, 'quickView'])->name('quickView');
    Route::post('products/bulk-approve', [ProductController::class, 'bulkApprove'])->name('bulkApprove');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    // Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('admin.categories.bulkAction');

    // Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/categories/upload-image', [CategoryController::class, 'uploadImage'])->name('admin.categories.uploadImage');
    // Route::post('categories/upload-image', [CategoryController::class, 'uploadImage'])->name('admin.categories.uploadImage');
    Route::resource('brands', BrandController::class)->names('admin.brands');
    Route::resource('inventory', InventoryController::class)->names('admin.inventory');
    Route::post('inventory/{inventory}/reserve', [InventoryController::class, 'reserveStock'])->name('admin.inventory.reserve');
    Route::post('inventory/{inventory}/release', [InventoryController::class, 'releaseStock'])->name('admin.inventory.release');
    Route::post('inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock'])->name('admin.inventory.adjust');

    // Orders, Returns, Cancellations
    Route::resource('orders', OrderController::class)->names('admin.orders');
    Route::get('orders/{id}/quick-view', [OrderController::class, 'quickView'])->name('quickView');
    Route::resource('returns', ReturnController::class)->names('admin.returns');
    Route::resource('cancellations', CancellationController::class)->names('admin.cancellations');
    Route::patch('cancellations/{id}/approve', [CancellationController::class, 'approve'])->name('admin.cancellations.approve');
    Route::patch('cancellations/{id}/reject', [CancellationController::class, 'reject'])->name('admin.cancellations.reject');

    // Customers, Reviews, Wishlists
    Route::resource('customers', CustomerController::class)->names('admin.customers');
    Route::post('customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('admin.customers.bulkDelete');
    Route::patch('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.customers.toggle-status');
    Route::resource('reviews', ReviewController::class)->names('admin.reviews');
    Route::post('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('admin.reviews.bulkDelete');
    Route::resource('wishlists', WishlistController::class)->names('admin.wishlists');
    Route::post('wishlists/bulk-delete', [WishlistController::class, 'bulkDelete'])->name('admin.wishlists.bulkDelete');


    // Website
    Route::prefix('website')->name('admin.website.')->group(function () {
        Route::get('banners', [WebsiteController::class, 'banners'])->name('banners');
        Route::get('pages', [WebsiteController::class, 'pages'])->name('pages');
        Route::resource('blogs', BlogController::class)->names('blogs');
        Route::get('seo', [SEOController::class, 'index'])->name('seo');
        Route::post('seo/update', [SEOController::class, 'update'])->name('seo.update');
    });

    // Support
    Route::prefix('support')->name('admin.support.')->group(function () {
        //seller
        Route::get('seller', [SupportController::class, 'seller'])->name('seller');
        Route::get('seller/{id}/messages', [SupportController::class, 'getMessagesforSeller'])->name('seller.messages');
        Route::post('seller/{id}/Storemessages', [SupportController::class, 'storeMessageforSeller'])->name('seller.messages.store');
        Route::get('seller/{id}/productreview', [SupportController::class, 'searchReview']);
        Route::get('seller/{id}/showsupport', [SupportController::class, 'showSupport']);
        Route::post('seller/{id}/updatestatus', [SupportController::class, 'updateStatus'])->name('seller.update');
        Route::put('seller/{id}/bankinfo', [SupportController::class, 'updateBankInfo'])->name('seller.BankInfo');
        //customer
        Route::get('customer', [SupportController::class, 'customer'])->name('customer');
        Route::post('customer/{support}/Storemessages', [SupportController::class, 'storeMessageforCustomer'])->name('customer.messages.store');
        Route::get('customer/{id}/messages', [SupportController::class, 'getMessagesforCustomer'])->name('customer.messages');
        Route::resource('tickets', TicketController::class)->names('tickets');
    });

    // Support & Tickets
    // Route::resource('seller-supports', SellerSupportController::class)->names('admin.seller-supports');
    // Route::get('products/{productId}/reviews', [SellerSupportController::class, 'searchReview']);
    // Route::get('/seller-supports/{id}/messages', [SellerSupportController::class, 'getMessages'])->name('seller-supports.messages');
    // Route::post('/seller-supports/{id}/messages', [SellerSupportController::class, 'storeMessage'])->name('seller-supports.messages.store');
    // Route::post('seller-supports/{id}/update-status', [SellerSupportController::class, 'updateStatus'])->name('seller-supports.update-status');
    // Route::put('/sellers/{seller}/bank-info', [SellerSupportController::class, 'updateBankInfo'])->name('sellers.updateBankInfo');
    // Customer Support
    // Route::resource('customer-supports', CustomerSupportController::class)->names('admin.customer-supports');
    // Route::get('/customer-supports/{support}/messages', [CustomerSupportController::class, 'getMessages'])->name('messages');
    // Route::post('/customer-supports/{support}/messages', [CustomerSupportController::class, 'storeMessage'])
    //     ->name('admin.customer-supports.messages.store');




    // Reports
    Route::prefix('reports')->name('admin.reports.')->group(function () {
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('seller-performance', [ReportController::class, 'sellerPerformance'])->name('seller-performance');
        Route::get('customer-insights', [ReportController::class, 'customerInsights'])->name('customer-insights');
    });

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('general', [SettingController::class, 'general'])->name('general');
        Route::get('payments', [SettingController::class, 'payments'])->name('payments');
        Route::get('shipping', [SettingController::class, 'shipping'])->name('shipping');
    });

    // Roles & Admin Users
    Route::resource('roles', RoleController::class)->names('admin.roles');
    Route::post('roles/assign', [RoleController::class, 'assignRole'])->name('admin.roles.assign');
    Route::resource('users', AdminController::class)->names('admin.users');
});

/*
|--------------------------------------------------------------------------
| Seller Panel (Protected by seller.auth)
|--------------------------------------------------------------------------
*/
Route::prefix('seller')->middleware('seller.auth')->group(function () {

    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');

    // Seller Orders
    Route::resource('orders', SellerOrderController::class)->names('seller.orders');

    // Seller Products
    Route::resource('products', SellerProductController::class)->names('seller.products');

    // Payouts
    Route::resource('payouts', SellerPayoutController::class)->names('seller.payouts');

    // Profile
    Route::get('profile', [SellerProfileController::class, 'index'])->name('seller.profile');
    Route::post('profile/update', [SellerProfileController::class, 'update'])->name('seller.profile.update');
    Route::get('support', [SellerSupportController::class, 'index'])->name('seller.support.index');
});
