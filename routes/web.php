<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellStockController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DayOffController;
use App\Http\Controllers\ExpenseStatementsController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\StockLimitController;
use App\Http\Controllers\StockTransfer;
use App\Http\Controllers\VeresiyeController;

/*
|--------------------------------------------------------------------------
| LİVE Routes
|--------------------------------------------------------------------------
|
|
*/  Route::prefix("auth")->name("auth")->group(function () {
    Route::post("login", [AuthenticationController::class, 'loginUser'])->name(".loginUser");
    Route::get("login", [AuthenticationController::class, 'login'])->name(".login");
    Route::get("logout", [AuthenticationController::class, 'logout'])->name(".logout");
});
Route::group(["middleware" => "auth"], function () {
Route::group(['prefix' => 'activity', 'namespace' => 'jeremykenedy\LaravelLogger\App\Http\Controllers',"middleware" => "auth"], function () {

    // Dashboards
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});

Route::group(['middleware' => ['web', 'activity']], function () {

    // Auth prefix


    Route::group(["middleware" => "auth"], function () {
        Route::prefix("objective")->name("objective")->group(function () {
            Route::get("/", [ObjectiveController::class, "index"])->name(".index");
            Route::post("/add", [ObjectiveController::class, "store"])->name(".store");
            Route::put("/update", [ObjectiveController::class, "update"])->name(".update");
            Route::delete("/delete", [ObjectiveController::class, "delete"])->name(".delete");
        });

        Route::prefix("product")->name("product")->group(function () {
            Route::get("/", [ProductController::class, "index"])->name(".index");
            Route::get("/products", [ProductController::class, "products"])->name(".products");
            Route::get("/add", [ProductController::class, "create"])->name(".create");
            Route::post("/add", [ProductController::class, "store"])->name(".store");
            Route::get("/edit/{id}", [ProductController::class, "edit"])->name(".edit");
            Route::post("/update", [ProductController::class, "update"])->name(".update");
            Route::delete("/delete/{id}", [ProductController::class, "destroy"])->name(".delete");
            Route::post("/delete", [ProductController::class, "imageDestroy"])->name(".imageDestroy");
            Route::post("/filter", [ProductController::class, "filter"])->name(".filter");
        });

        Route::prefix("user")->name("user")->group(function () {
            Route::get("/list", [UserController::class, "list"])->name(".list");
            Route::get("/userList", [UserController::class, "userList"])->name(".userList");
            Route::post("/add", [UserController::class, "store"])->name(".store");
            Route::post("/wage/{id}", [UserController::class, "payWage"])->name(".payWage");
            Route::get("/", [UserController::class, "index"])->name(".index");
            Route::delete("/delete/{id}", [UserController::class, "destroy"])->name(".delete");
            Route::put("/edit/{id}", [UserController::class, "update"])->name(".update");
            Route::get("/detail/{id?}", [UserController::class, "detail"])->name(".detail");
            Route::get("/wage/{id}", [UserController::class, "wageDetail"])->name(".wageDetail");
        });

        // Rol prefix
        Route::prefix("roles")->name("roles")->group(function () {
            Route::get("/", [RoleController::class, "index"])->name(".index");
            Route::get("/{id}", [RoleController::class, "detail"])->name(".detail")->whereNumber("id");
            Route::post("/", [RoleController::class, "store"])->name(".store");
            Route::post("/{id}", [RoleController::class, "update"])->name(".update")->whereNumber("id");
            Route::delete("/{id}", [RoleController::class, "delete"])->name(".delete")->whereNumber("id");
        });

        // Firma prefix
        Route::prefix("company")->name("company")->group(function () {
            Route::get("/", [CompanyController::class, "index"])->name(".index");
            Route::get("/company", [CompanyController::class, "companies"])->name(".company");
            Route::get("/add", [CompanyController::class, "create"])->name(".create");
            Route::get("/{id}", [CompanyController::class, "edit"])->name(".edit")->whereNumber("id");

            Route::post("/", [CompanyController::class, "store"])->name(".store");
            Route::post("/update", [CompanyController::class, "update"])->name(".update");

            Route::delete("/{id}", [CompanyController::class, "delete"])->name(".delete")->whereNumber("id");
        });
        // Stok prefix
        Route::prefix("stockTransfer")->name("stockTransfer")->group(function () {
            // Stok anasayfa
            Route::get("/", [StockTransfer::class, "index"])->name(".index");
            Route::get("/list", [StockTransfer::class, "list"])->name(".list");
            Route::post("/transfer", [StockTransfer::class, "transfer"])->name(".transfer");
        });
        // Stok prefix
        Route::prefix("sellstock")->name("sellstock")->group(function () {
            // Stok anasayfa
            Route::get("/", [SellStockController::class, "index"])->name(".sellstock");
            Route::post("/sell", [SellStockController::class, "store"])->name(".store");
        });
        // reporting
        Route::prefix("reporting")->name("reporting")->group(function () {

            Route::get("/", [ReportingController::class, "index"])->name(".index");
            Route::post("/sell", [ReportingController::class, "store"])->name(".store");
            Route::post("/filter", [ReportingController::class, "filter"])->name(".filter");
            Route::post("/filter2", [ReportingController::class, "filter2"])->name(".filter2");
            Route::get("/expense", [ReportingController::class, "expense"])->name(".expense");
            Route::get("/income", [ReportingController::class, "income"])->name(".income");
        });
        // income prefix
        Route::prefix("expenseStatements")->name("expenseStatements")->group(function () {
            // Stok anasayfa
            Route::get("/", [ExpenseStatementsController::class, "index"])->name(".index");
            Route::post("/select", [ExpenseStatementsController::class, "select"])->name(".selectee");
            Route::post("/filter", [ExpenseStatementsController::class, "filter"])->name(".filter");
            Route::post("/store", [ExpenseStatementsController::class, "store"])->name(".store");
            Route::get("/destroy/{id}", [ExpenseStatementsController::class, "destroy"])->name(".destroy");
        });

        // income prefix
        Route::prefix("income")->name("income")->group(function () {
            // Stok anasayfa
            Route::get("/", [IncomeController::class, "index"])->name(".index");
            Route::post("/select", [IncomeController::class, "select"])->name(".selectee");
            Route::post("/filter", [IncomeController::class, "filter"])->name(".filter");
            Route::post("/store", [IncomeController::class, "store"])->name(".store");
            Route::get("/destroy/{id}", [IncomeController::class, "destroy"])->name(".destroy");
        });
        // Stok prefix
        Route::prefix("stock")->name("stock")->group(function () {
            Route::get("/", [StockController::class, "index"])->name(".index");
            Route::post("/", [StockController::class, "store"])->name(".store");
            Route::post("/filter-products", [StockController::class, "filterProducts"])->name(".filterProducts");
        });
    // Stok prefix
    Route::prefix("veresiye")->name("veresiye")->group(function () {
        Route::get("/", [VeresiyeController::class, "index"])->name(".index");
        Route::post("/store", [VeresiyeController::class, "store"])->name(".store");
    });
        // Müşteri prefix
        Route::prefix("customer")->name("customer")->group(function () {
            Route::get("/", [CustomerController::class, "index"])->name(".index");
            Route::get("/add", [CustomerController::class, "add"])->name(".add");
            Route::get("/customers", [CustomerController::class, "customers"])->name(".customers");
            Route::get("/{id}", [CustomerController::class, "edit"])->name(".edit");

            Route::post("/", [CustomerController::class, "store"])->name(".store");
            Route::post("/{id}", [CustomerController::class, "update"])->name(".update")->whereNumber("id");
            Route::post("/filter", [CustomerController::class, "filter"])->name(".filter");

            Route::delete("/{id}", [CustomerController::class, "delete"])->name(".delete");
        });

        // Stok limitleri prefix
        Route::prefix("stock-limit")->name("stockLimit")->group(function () {
            Route::get("/add", [StockLimitController::class, "add"])->name(".add");
            Route::get("/", [StockLimitController::class, "index"])->name(".index");
            Route::get("/{id}", [StockLimitController::class, "edit"])->name(".edit")->whereNumber("id");
            Route::get("/limits", [StockLimitController::class, "limits"])->name(".limits");

            Route::post("/update/{id}", [StockLimitController::class, "update"])->name(".update");
            Route::post("/filter", [StockLimitController::class, "filter"])->name(".filter");
            Route::post("/", [StockLimitController::class, "store"])->name(".store");
            Route::delete("/{id}", [StockLimitController::class, "delete"])->name(".delete");
        });

        // Hatırlatıcı prefix
        Route::prefix("reminder")->name("reminder")->group(function () {
            Route::get("/", [ReminderController::class, "index"])->name(".index");
            Route::post("/add", [ReminderController::class, "store"])->name(".store");
            Route::post("/update", [ReminderController::class, "update"])->name(".update");
            Route::post("/delete", [ReminderController::class, "destroy"])->name(".delete");
            Route::post("/events", [ReminderController::class, "events"])->name(".events");
            Route::get("/notifications", [ReminderController::class, "notifications"])->name(".notifications");
            Route::get("/change-status/{id}", [ReminderController::class, "changeStatus"])->name(".changeStatus")->whereNumber("id");
        });

        // İzinler prefix
        Route::prefix("dayoff")->name("dayoff")->group(function () {
            // İzin ekleme ekranı
            Route::get("/add", [DayOffController::class, "create"])->name(".create");
            // İzinler listeleme ekranı
            Route::get("/", [DayOffController::class, "index"])->name(".index");
            // İzinleri döndür
            Route::get("/dayoff", [DayOffController::class, "dayOffs"])->name(".dayOffs");
            // İzin güncelle
            Route::get("/{id}", [DayOffController::class, "edit"])->name(".edit")->whereNumber("id");

            // İzin ekle
            Route::post("/", [DayOffController::class, "store"])->name(".store");
            // İzin filtrele
            Route::post("/filter", [DayOffController::class, "filter"])->name(".filter");
            // İzin güncelle
            Route::post("/{id}", [DayOffController::class, "update"])->name(".update");

            // İzin sil
            Route::delete("/{id}", [DayOffController::class, "delete"])->name(".delete");
        });
    });

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

    // Main Page Route
    Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');

    /* Route Dashboards */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('analytics', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
        Route::get('ecommerce', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');
    });
    /* Route Dashboards */

    /* Route Apps */
    Route::group(['prefix' => 'app', "name" => "app"], function () {
        // ** TEMA
        Route::get('email', [AppsController::class, 'emailApp'])->name('app-email');
        Route::get('chat', [AppsController::class, 'chatApp'])->name('app-chat');
        Route::get('todo', [AppsController::class, 'todoApp'])->name('app-todo');
        Route::get('calendar', [AppsController::class, 'calendarApp'])->name('app-calendar');
        Route::get('kanban', [AppsController::class, 'kanbanApp'])->name('app-kanban');
        Route::get('invoice/list', [AppsController::class, 'invoice_list'])->name('app-invoice-list');
        Route::get('invoice/preview', [AppsController::class, 'invoice_preview'])->name('app-invoice-preview');
        Route::get('invoice/edit', [AppsController::class, 'invoice_edit'])->name('app-invoice-edit');
        Route::get('invoice/add', [AppsController::class, 'invoice_add'])->name('app-invoice-add');
        Route::get('invoice/print', [AppsController::class, 'invoice_print'])->name('app-invoice-print');
        Route::get('ecommerce/shop', [AppsController::class, 'ecommerce_shop'])->name('app-ecommerce-shop');
        Route::get('ecommerce/details', [AppsController::class, 'ecommerce_details'])->name('app-ecommerce-details');
        Route::get('ecommerce/wishlist', [AppsController::class, 'ecommerce_wishlist'])->name('app-ecommerce-wishlist');
        Route::get('ecommerce/checkout', [AppsController::class, 'ecommerce_checkout'])->name('app-ecommerce-checkout');
        Route::get('file-manager', [AppsController::class, 'file_manager'])->name('app-file-manager');
        Route::get('access-roles', [AppsController::class, 'access_roles'])->name('app-access-roles');
        Route::get('access-permission', [AppsController::class, 'access_permission'])->name('app-access-permission');
        Route::get('user/list', [AppsController::class, 'user_list'])->name('app-user-list');
        Route::get('user/view/account', [AppsController::class, 'user_view_account'])->name('app-user-view-account');
        Route::get('user/view/security', [AppsController::class, 'user_view_security'])->name('app-user-view-security');
        Route::get('user/view/billing', [AppsController::class, 'user_view_billing'])->name('app-user-view-billing');
        Route::get('user/view/notifications', [AppsController::class, 'user_view_notifications'])->name('app-user-view-notifications');
        Route::get('user/view/connections', [AppsController::class, 'user_view_connections'])->name('app-user-view-connections');
    });
    /* Route Apps */

    /* Route UI */
    Route::group(['prefix' => 'ui'], function () {
        Route::get('typography', [UserInterfaceController::class, 'typography'])->name('ui-typography');
    });
    /* Route UI */

    /* Route Icons */
    Route::group(['prefix' => 'icons'], function () {
        Route::get('feather', [UserInterfaceController::class, 'icons_feather'])->name('icons-feather');
    });
    /* Route Icons */

    /* Route Cards */
    Route::group(['prefix' => 'card'], function () {
        Route::get('basic', [CardsController::class, 'card_basic'])->name('card-basic');
        Route::get('advance', [CardsController::class, 'card_advance'])->name('card-advance');
        Route::get('statistics', [CardsController::class, 'card_statistics'])->name('card-statistics');
        Route::get('analytics', [CardsController::class, 'card_analytics'])->name('card-analytics');
        Route::get('actions', [CardsController::class, 'card_actions'])->name('card-actions');
    });
    /* Route Cards */

    /* Route Components */
    Route::group(['prefix' => 'component'], function () {
        Route::get('accordion', [ComponentsController::class, 'accordion'])->name('component-accordion');
        Route::get('alert', [ComponentsController::class, 'alert'])->name('component-alert');
        Route::get('avatar', [ComponentsController::class, 'avatar'])->name('   -avatar');
        Route::get('badges', [ComponentsController::class, 'badges'])->name('component-badges');
        Route::get('breadcrumbs', [ComponentsController::class, 'breadcrumbs'])->name('component-breadcrumbs');
        Route::get('buttons', [ComponentsController::class, 'buttons'])->name('component-buttons');
        Route::get('carousel', [ComponentsController::class, 'carousel'])->name('component-carousel');
        Route::get('collapse', [ComponentsController::class, 'collapse'])->name('component-collapse');
        Route::get('divider', [ComponentsController::class, 'divider'])->name('component-divider');
        Route::get('dropdowns', [ComponentsController::class, 'dropdowns'])->name('component-dropdowns');
        Route::get('list-group', [ComponentsController::class, 'list_group'])->name('component-list-group');
        Route::get('modals', [ComponentsController::class, 'modals'])->name('component-modals');
        Route::get('pagination', [ComponentsController::class, 'pagination'])->name('component-pagination');
        Route::get('navs', [ComponentsController::class, 'navs'])->name('component-navs');
        Route::get('offcanvas', [ComponentsController::class, 'offcanvas'])->name('component-offcanvas');
        Route::get('tabs', [ComponentsController::class, 'tabs'])->name('component-tabs');
        Route::get('timeline', [ComponentsController::class, 'timeline'])->name('component-timeline');
        Route::get('pills', [ComponentsController::class, 'pills'])->name('component-pills');
        Route::get('tooltips', [ComponentsController::class, 'tooltips'])->name('component-tooltips');
        Route::get('popovers', [ComponentsController::class, 'popovers'])->name('component-popovers');
        Route::get('pill-badges', [ComponentsController::class, 'pill_badges'])->name('component-pill-badges');
        Route::get('progress', [ComponentsController::class, 'progress'])->name('component-progress');
        Route::get('spinner', [ComponentsController::class, 'spinner'])->name('component-spinner');
        Route::get('toast', [ComponentsController::class, 'toast'])->name('component-bs-toast');
    });
    /* Route Components */

    /* Route Extensions */
    Route::group(['prefix' => 'ext-component'], function () {
        Route::get('sweet-alerts', [ExtensionController::class, 'sweet_alert'])->name('ext-component-sweet-alerts');
        Route::get('block-ui', [ExtensionController::class, 'block_ui'])->name('ext-component-block-ui');
        Route::get('toastr', [ExtensionController::class, 'toastr'])->name('ext-component-toastr');
        Route::get('sliders', [ExtensionController::class, 'sliders'])->name('ext-component-sliders');
        Route::get('drag-drop', [ExtensionController::class, 'drag_drop'])->name('ext-component-drag-drop');
        Route::get('tour', [ExtensionController::class, 'tour'])->name('ext-component-tour');
        Route::get('clipboard', [ExtensionController::class, 'clipboard'])->name('ext-component-clipboard');
        Route::get('plyr', [ExtensionController::class, 'plyr'])->name('ext-component-plyr');
        Route::get('context-menu', [ExtensionController::class, 'context_menu'])->name('ext-component-context-menu');
        Route::get('swiper', [ExtensionController::class, 'swiper'])->name('ext-component-swiper');
        Route::get('tree', [ExtensionController::class, 'tree'])->name('ext-component-tree');
        Route::get('ratings', [ExtensionController::class, 'ratings'])->name('ext-component-ratings');
        Route::get('locale', [ExtensionController::class, 'locale'])->name('ext-component-locale');
    });
    /* Route Extensions */

    /* Route Page Layouts */
    Route::group(['prefix' => 'page-layouts'], function () {
        Route::get('collapsed-menu', [PageLayoutController::class, 'layout_collapsed_menu'])->name('layout-collapsed-menu');
        Route::get('full', [PageLayoutController::class, 'layout_full'])->name('layout-full');
        Route::get('without-menu', [PageLayoutController::class, 'layout_without_menu'])->name('layout-without-menu');
        Route::get('empty', [PageLayoutController::class, 'layout_empty'])->name('layout-empty');
        Route::get('blank', [PageLayoutController::class, 'layout_blank'])->name('layout-blank');
    });
    /* Route Page Layouts */

    /* Route Forms */
    Route::group(['prefix' => 'form'], function () {
        Route::get('input', [FormsController::class, 'input'])->name('form-input');
        Route::get('input-groups', [FormsController::class, 'input_groups'])->name('form-input-groups');
        Route::get('input-mask', [FormsController::class, 'input_mask'])->name('form-input-mask');
        Route::get('textarea', [FormsController::class, 'textarea'])->name('form-textarea');
        Route::get('checkbox', [FormsController::class, 'checkbox'])->name('form-checkbox');
        Route::get('radio', [FormsController::class, 'radio'])->name('form-radio');
        Route::get('custom-options', [FormsController::class, 'custom_options'])->name('form-custom-options');
        Route::get('switch', [FormsController::class, 'switch'])->name('form-switch');
        Route::get('select', [FormsController::class, 'select'])->name('form-select');
        Route::get('number-input', [FormsController::class, 'number_input'])->name('form-number-input');
        Route::get('file-uploader', [FormsController::class, 'file_uploader'])->name('form-file-uploader');
        Route::get('quill-editor', [FormsController::class, 'quill_editor'])->name('form-quill-editor');
        Route::get('date-time-picker', [FormsController::class, 'date_time_picker'])->name('form-date-time-picker');
        Route::get('layout', [FormsController::class, 'layouts'])->name('form-layout');
        Route::get('wizard', [FormsController::class, 'wizard'])->name('form-wizard');
        Route::get('validation', [FormsController::class, 'validation'])->name('form-validation');
        Route::get('repeater', [FormsController::class, 'form_repeater'])->name('form-repeater');
    });
    /* Route Forms */

    /* Route Tables */
    Route::group(['prefix' => 'table'], function () {
        Route::get('', [TableController::class, 'table'])->name('table');
        Route::get('datatable/basic', [TableController::class, 'datatable_basic'])->name('datatable-basic');
        Route::get('datatable/advance', [TableController::class, 'datatable_advance'])->name('datatable-advance');
    });
    /* Route Tables */

    /* Route Pages */
    Route::group(['prefix' => 'page'], function () {
        Route::get('account-settings-account', [PagesController::class, 'account_settings_account'])->name('page-account-settings-account');
        Route::get('account-settings-security', [PagesController::class, 'account_settings_security'])->name('page-account-settings-security');
        Route::get('account-settings-billing', [PagesController::class, 'account_settings_billing'])->name('page-account-settings-billing');
        Route::get('account-settings-notifications', [PagesController::class, 'account_settings_notifications'])->name('page-account-settings-notifications');
        Route::get('account-settings-connections', [PagesController::class, 'account_settings_connections'])->name('page-account-settings-connections');
        Route::get('profile', [PagesController::class, 'profile'])->name('page-profile');
        Route::get('faq', [PagesController::class, 'faq'])->name('page-faq');
        Route::get('knowledge-base', [PagesController::class, 'knowledge_base'])->name('page-knowledge-base');
        Route::get('knowledge-base/category', [PagesController::class, 'kb_category'])->name('page-knowledge-base');
        Route::get('knowledge-base/category/question', [PagesController::class, 'kb_question'])->name('page-knowledge-base');
        Route::get('pricing', [PagesController::class, 'pricing'])->name('page-pricing');
        Route::get('api-key', [PagesController::class, 'api_key'])->name('page-api-key');
        Route::get('blog/list', [PagesController::class, 'blog_list'])->name('page-blog-list');
        Route::get('blog/detail', [PagesController::class, 'blog_detail'])->name('page-blog-detail');
        Route::get('blog/edit', [PagesController::class, 'blog_edit'])->name('page-blog-edit');

        // Miscellaneous Pages With Page Prefix
        Route::get('coming-soon', [MiscellaneousController::class, 'coming_soon'])->name('misc-coming-soon');
        Route::get('not-authorized', [MiscellaneousController::class, 'not_authorized'])->name('misc-not-authorized');
        Route::get('maintenance', [MiscellaneousController::class, 'maintenance'])->name('misc-maintenance');
        Route::get('license', [PagesController::class, 'license'])->name('page-license');
    });

    /* Modal Examples */
    Route::get('/modal-examples', [PagesController::class, 'modal_examples'])->name('modal-examples');

    /* Route Pages */
    Route::get('/error', [MiscellaneousController::class, 'error'])->name('error');

    /* Route Authentication Pages */
    Route::group(['prefix' => 'authDev', ["middleware" => "auth"]], function () {

        Route::post("login", [AuthenticationController::class, 'loginUser'])->name("login");

        Route::get("login", [AuthenticationController::class, 'login'])->name("login");

        Route::get("logout", [AuthenticationController::class, 'logout'])->name("logout");

        // ** Tema
        Route::get('login-basic', [AuthenticationController::class, 'login_basic'])->name('auth-login-basic');
        Route::get('login-cover', [AuthenticationController::class, 'login_cover'])->name('auth-login-cover');
        Route::get('register-basic', [AuthenticationController::class, 'register_basic'])->name('auth-register-basic');
        Route::get('register-cover', [AuthenticationController::class, 'register_cover'])->name('auth-register-cover');
        Route::get('forgot-password-basic', [AuthenticationController::class, 'forgot_password_basic'])->name('auth-forgot-password-basic');
        Route::get('forgot-password-cover', [AuthenticationController::class, 'forgot_password_cover'])->name('auth-forgot-password-cover');
        Route::get('reset-password-basic', [AuthenticationController::class, 'reset_password_basic'])->name('auth-reset-password-basic');
        Route::get('reset-password-cover', [AuthenticationController::class, 'reset_password_cover'])->name('auth-reset-password-cover');
        Route::get('verify-email-basic', [AuthenticationController::class, 'verify_email_basic'])->name('auth-verify-email-basic');
        Route::get('verify-email-cover', [AuthenticationController::class, 'verify_email_cover'])->name('auth-verify-email-cover');
        Route::get('two-steps-basic', [AuthenticationController::class, 'two_steps_basic'])->name('auth-two-steps-basic');
        Route::get('two-steps-cover', [AuthenticationController::class, 'two_steps_cover'])->name('auth-two-steps-cover');
        Route::get('register-multisteps', [AuthenticationController::class, 'register_multi_steps'])->name('auth-register-multisteps');
        Route::get('lock-screen', [AuthenticationController::class, 'lock_screen'])->name('auth-lock_screen');
    });
    /* Route Authentication Pages */

    /* Route Charts */
    Route::group(['prefix' => 'chart'], function () {
        Route::get('apex', [ChartsController::class, 'apex'])->name('chart-apex');
        Route::get('chartjs', [ChartsController::class, 'chartjs'])->name('chart-chartjs');
        Route::get('echarts', [ChartsController::class, 'echarts'])->name('chart-echarts');
    });
    /* Route Charts */

    // map leaflet
    Route::get('/maps/leaflet', [ChartsController::class, 'maps_leaflet'])->name('map-leaflet');

    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
});
});
