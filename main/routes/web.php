<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CashierManagement;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryPdfController;
use App\Http\Controllers\AdminManagement;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\CashierAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryArchiveController;
use App\Http\Controllers\ReceiptPDF;
use App\Http\Controllers\SalesLogsPdf;
use App\Http\Controllers\SuperAdminLogin;
use App\Http\Controllers\UserLogin;
use App\Http\Controllers\WhiteListController;
use App\Http\Middleware\SuperAdminAuth;
use App\Http\Middleware\WhiteListAuth;
use App\Livewire\InventoryArchive;
use App\Models\SuperAdmin;
use App\Http\Controllers\PieChart;

//superadmin
Route::get('/superadmin', function () {
    return view('superadmin/superadmin-login');
});
//customers
Route::get('/', function () {
    return view('index');
});
Route::get('/customize', function () {
    return view('customize');
});
//customers
Route::get('/', [AnnouncementController::class, 'displayOnCustomers']);


//secured routes

Route::middleware([WhiteListAuth::class])->group(function() {
    Route::get('/login', function () {
        return view('login');
    }); 
    Route::post('/login', [UserLogin::class, 'login'])->name('user.login') ;
    Route::get('/logout', [UserLogin::class, 'logout'])->name('user.logout');
    
    Route::middleware(['auth:admin'])->group(function() {
        // Admin Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'index'], function () {
            return view('admin/admin-home');
        });
        
        // Products Management
        Route::get('/admin/products', [ProductsController::class, 'display'])->name('products.display');
        Route::post('/admin/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    
    
        // Sales Logs
        Route::get('/admin/sales', [AdminController::class, 'displayLogs'])->name('admin.logs');
        Route::get('/admin/sales/pdf',[SalesLogsPdf::class, 'exportToPdf'])->name('logs.export');
    
        // User Management
        Route::get('/admin/user_management', [CashierManagement::class, 'display'])->name('cashier.display');
        Route::post('/admin/user_management', [CashierManagement::class, 'store'])->name('cashier.store');
        Route::post('/admin/user_management/{id}', [CashierManagement::class, 'update'])->name('cashier.update');
        Route::delete('/admin/user_management/{id}', [CashierManagement::class, 'destroy'])->name('cashier.destroy');
        Route::post('/admin/user_management/archived/{id}', [CashierManagement::class, 'archive'])->name('cashier.archive');
        Route::post('/admin/user_management/restore/{id}', [CashierManagement::class, 'restore'])->name('cashier.restore');
    
        // Announcements Management
        Route::get('/admin/announcements', [AnnouncementController::class, 'display'])->name('announcement.display');
        Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('announcement.store');
        
        Route::put('/admin/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/admin/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
    
        // Inventory Management
        Route::get('/admin/inventory', [InventoryController::class, 'display'])->name('inventory.display');
        Route::get('/admin/inventory/archived', [InventoryArchiveController::class,'index'])->name('inventory.archived');
        Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
        Route::put('/admin/inventory', [InventoryController::class, 'setCriticalLevel'])->name('inventory.critical');
        Route::get('/inventory/export-pdf', [InventoryPdfController::class, 'exportToPdf'])->name('inventory.export');
        Route::get('/inventory/export-excel', [InventoryController::class, 'exportToExcel'])->name('inventory.exportToExcel');
    
    
    });

    //cashier auth routes
    Route::middleware(['auth:cashier'])->group(function() {
    Route::get('/cashier/pos', [ProductsController::class, 'display'])->name('products.display');
    Route::post('/cashier/pos/{id}', [ProductsController::class, 'addToOrder'])->name('order.store');
    Route::get('/cashier/pos', [OrderController::class, 'display'])->name('order.display');
    Route::put('/cashier/pos/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/cashier/pos/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/cashier/pos', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/cashier/pos/receipt{id}', [ReceiptPDF::class, 'exportToPdf'])->name('order.receipt');
});


});

// super admin function store account admin
Route::middleware([SuperAdminAuth::class])->group(function() {
    Route::get('/superadmin/system_config', function () {
        return view('superadmin/superadmin-config');
    });
    Route::get('/superadmin/user_management', [AdminManagement::class, 'display'])->name('admin.display');
    Route::post('/superadmin/user_management', [AdminManagement::class, 'store'])->name('admin.store');
    Route::post('/superadmin/user_management/{id}', [AdminManagement::class, 'update'])->name('admin.update');
    Route::delete('/superadmin/user_management/{id}', [AdminManagement::class, 'destroy'])->name('admin.destroy');
    ROute::post('/superadmin/user_management/archived/{id}', [AdminManagement::class, 'archive'])->name('admin.archive');
    Route::post('/superadmin/user_management/restore/{id}', [AdminManagement::class, 'restore'])->name('admin.restore');

    Route::post('/superadmin/system_config', [WhiteListController::class, 'store'])->name('whitelist.store');
    Route::get('/superadmin/system_config', [WhiteListController::class, 'display'])->name('whitelist.display');
    Route::put('/superadmin/system_config/{id}', [WhiteListController::class, 'update'])->name('whitelist.update');
    Route::delete('/superadmin/system_config/{id}', [WhiteListController::class, 'destroy'])->name('whitelist.destroy');
});
Route::post('/superadmin/login', [SuperAdminLogin::class, 'login'])->name('superadmin.login');

// submit forgot password
Route::post('/superadmin/forgot-password', [SuperAdminLogin::class, 'forgotPassword'])->name('superadmin.forgot-password');

// get token password
Route::get('/superadmin/password/reset/{token}', [SuperAdminLogin::class, 'showResetForm'])->name('password.reset');

// reset password
Route::post('/superadmin/password/reset', [SuperAdminLogin::class, 'resetPassword'])->name('password.update') ;


Route::get('/superadmin/login', [SuperAdminLogin::class, 'logout'])->name('superadmin.logout') ;










