<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
define("DS",DIRECTORY_SEPARATOR);

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

 Route::resource("roles","Web\RoleController");
 Route::group(["middleware" =>[ "auth","permissions"], "namespace" => "Web"],function(){


    Route::get('/', "DashboardController@index")->name("dashboard.index");
    Route::resource("branches", "BranchTableController");
    Route::get("users/app", "UsersController@index")->name("users.app.index");

    Route::get("users/driver", "UsersController@driverindex")->name("users.driver.index");

    Route::get("users/vendor", "UsersController@vendorindex")->name("users.vendor.index");


    Route::delete("users/app/{id}", "UsersController@destroy")->name("users.app.destroy");
    Route::resource("admins", "UsersDashboardController");
    Route::get("profile", "UsersDashboardController@profile")->name("profile");
    Route::post("profile", "UsersDashboardController@saveProfile")->name("profile.save");

    Route::resource("categories", "CategoryListController");
    Route::resource("items", "ItemsListController");
    Route::resource("sliders", "SliderController");
    Route::get("branch/{id}/slider","BranchTableController@slider")->name("branch.slider");
    Route::put("branch/slider","BranchTableController@saveSlider")->name("branch.slider.save");
    Route::get("items/{id}/add_ons","AddOnsController@index")->name("items.add_ons");
    Route::get("items/{id}/add_ons/create","AddOnsController@create")->name("items.add_ons.create");
    Route::post("items/{id}/add_ons","AddOnsController@store")->name("items.add_ons.store");
    Route::get("items/{item_id}/add_ons/{id}/edit","AddOnsController@edit")->name("items.add_ons.edit");
    Route::put("items/{item_id}/add_ons/{id}","AddOnsController@update")->name("items.add_ons.update");
    Route::delete("items/{item_id}/add_ons/{id}/","AddOnsController@destroy")->name("items.add_ons.destroy");

    Route::post("orders_filter","OrderController@filter")->name("orders.from.to.filter");

    Route::get("orders","OrderController@index")->name("orders.index");
    Route::get("orders/{id}/details","OrderController@details")->name("orders.details");
    Route::post("orders/export/excel","OrderController@exportExcelFile")->name("orders.export.excel");

    Route::get("settings","SettingsController@index")->name("settings.index");
    Route::post("settings","SettingsController@store")->name("settings.store");

    Route::get("reports/items_count_order", "ReportController@itemsCountOrder")->name("reports.items_count_order");

    Route::post("reports/items_count_order.filter", "ReportController@filter_items_count")->name("items_count_order.filter");


    Route::get("reports/items_count_order/export/excel",
    "ReportController@exportItemsCountOrderAsExcel")->name("reports.items_count_order.export.excel");

    Route::get("reports/users_with_count_him_orders", "ReportController@getUsersWithCountOrdersHim")->name("reports.users_with_count_him_orders");
    Route::post("reports/reports.users.filter", "ReportController@filter_user_reports")->name("reports.users.filter");


    Route::get("reports/users_with_count_him_orders/export/excel",
    "ReportController@exportUsersWithCountOrdersHimAsExcel")->name("reports.users_with_count_him_orders.export.excel");


    Route::get("reports/branches_sales", "ReportController@getBranchesSales")->name("reports.branches_sales");
    Route::get("reports/branches_sales/export/excel",
    "ReportController@exportBranchesSalesAsExcel")->name("reports.branches_sales.export.excel");

    Route::resource("promoCode", "promocodeController");

    Route::resource("WelcomeMessage", "WelcomeMessageController");



    Route::get("branchRating/{branch_id}", "branchRatingController@getBranchRating")->name("branchRating");
    Route::get("branchRating/create/{branch_id}", "branchRatingController@create")->name("branchRating.create");
    Route::post("branchRating", "branchRatingController@store")->name("branchRating.store");



    Route::get("/DeleteOption/{ID}","AddOnsOptionsController@destroyWEB")->name("add_ons_option.destroy");
    Route::get("/EditOption/{option_ID}","AddOnsOptionsController@edit")->name("add_ons_option.Edit");
    Route::put("/updateOption/{option_ID}","AddOnsOptionsController@update")->name("add_ons_option.update");



    Route::get("delivery_price/index","DeliveryPriceController@index")->name("delivery_price.index");
    Route::get("delivery_price/create","DeliveryPriceController@create")->name("delivery_price.create");
    Route::post("delivery_price","DeliveryPriceController@store")->name("delivery_price.store");
    Route::get("delivery_price/{id}/edit","DeliveryPriceController@edit")->name("delivery_price.edit");
    Route::put("delivery_price/{id}/update","DeliveryPriceController@update")->name("delivery_price.update");
    Route::delete("delivery_price/{id}/destroy","DeliveryPriceController@destroy")->name("delivery_price.destroy");


    Route::post("api/delivery_location/initialize", "DeliveryPriceController@initialize");
    Route::post("api/delivery_location/cancel", "DeliveryPriceController@cancel");

    Route::resource("city", "CityController");
    Route::get("city/{city_id}/areas", "AreaController@index")->name("area.index");


   //check status

   Route::resource("check_category_status","check_category_status_controller");




});
Route::get('/test/test1', function(){
    return request()->routeIs("test.*");
})->name("test.index");
// Route::get('/map/test', function(){

// });
