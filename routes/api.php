<?php
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    
    
    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
|
    ***** DB connection ********
    if(DB::connection()->getDatabaseName())
    {
      echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
    }
*/
    
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    





    
    Route::get('/',function(){
        return "404 not found";
    });



    //creaete new App  user  
    Route::post("AddUserApp","Api\Create_user_app_controller@AddUserApp");
    
    



    Route::group(['middleware' => ['jwt.verify']], function() {
        
        


  
    


     Route::group(["namespace"=>"Api"],function(){
 
    // App  controller
    

    Route::get("getUserData/{phoneNumber}","check_phone_number@getUserData");
  
    Route::put("UpdateUserApp","check_phone_number@UpdateUserApp");


  
    

//  phone number controller
    Route::get("checkPhoneNumber/{phoneNumber}","check_phone_number@checkPhoneNumber");
    

    
    
    Route::get("getAllAddresses/{phoneNumber}","check_phone_number@getAllAddresses");
    
    Route::get("addAddressManual/{phoneNumber}/{title}/{area_name}/{street_name}/{building_number}/{floor_number}/{apartment_number}/{lat}/{long}","check_phone_number@addAddressManual");
    
    Route::get("getAddressDetails/{id}","check_phone_number@getAddressDetails");
    
    Route::post("updateAddressDetails/{title}/{area_name}/{street_name}/{building_number}/{floor_number}/{apartment_number}/{id}","check_phone_number@updateAddressDetails");
    
    
    
// get all branches controllers
    Route::get("getAllBranches","get_branches_controller@getAllBranches");
   
   
   
    Route::get("getBranchDetails","get_branches_controller@getBranchDetails");
    Route::post("contuct_us","contuct_us_controller@store");

// get all cities controller
    Route::get("getAllCities","get_all_cities_controller@getAllCities");
    Route::get("getAllAreas/{city_id}","get_all_cities_controller@getAllAreas");
    Route::get("getAllAreasAndCities","get_all_cities_controller@getAllAreasAndCities");

//check is logged in
    Route::get("checkIsLoggedIn/{mobile_number}","check_is_logged_in@checkIsLoggedIn");

// all category feild conroller
    Route::get("getAllCategory/{lang_code}","category_controller@getAllCategory");
    Route::get("getAllItemFromCategory/{categoryId}","category_controller@getAllItemFromCategory");
    Route::get("getAllCategoryName/{lang_code}","category_controller@getCategoryNames");





// item details controller


    Route::get("get_Item_Details","get_item_details_controller@get_Item_Details");
    
    
    Route::get("getItemAddOnsCategory/{itemId}","get_item_details_controller@getItemAddOnsCategory");
    Route::get("getListOfAddOns/{addOnsCatId}","get_item_details_controller@getListOfAddOns");

// app settings controller
    Route::get("getAppSettings","app_settings_controller@getAppSettings");
    Route::post("updateIsAccepting","app_settings_controller@updateIsAccepting");
    Route::get("getIsAcceptOrder","app_settings_controller@getIsAcceptOrder");

//creat order controller
    Route::post("createOrder","creat_order_controller@createOrder");

    Route::post("testPush","creat_order_controller@testPush");


    Route::get("OrderItemDetails","order_details_controller@getOrderItemDetails");
// get all payments
    Route::get("getAllPayment","get_all_payment@getAllPayment");

// get my orders
    Route::get("getMyOrders/{phone_number}","order_details_controller@getMyOrders");
    Route::get("getActiveOrders/{phone_number}","order_details_controller@getActiveOrders");

    Route::get("getMyOrderDetails/{order_id}","order_details_controller@getMyOrderDetails");

    Route::get("getAllOrderDetails","order_details_controller@getAllOrderDetails");


// get branch slider image controller
    Route::get("getBranchSlider/{branch_id}","get_branch_slider_controller@getBranchSlider");

// get slider in home page
    Route::get("getSlider","get_main_slider_controller@getSlider");
    Route::get("navigateSlider/{type}/{id}","get_main_slider_controller@navigateSlider");

// vendor controller

    Route::get("StartNewDay","app_settings_controller@StartNewDay");

    Route::group(['middleware' => ['vendor']], function() {

    Route::get("getAllItems","vendor_controller@getAllItems");
    Route::put("ChangeItemStatus","vendor_controller@ChangeItemStatus");
    Route::get("get_Orders_by_status","vendor_controller@get_Orders_by_status");
    Route::put("changeOrderStatus","vendor_controller@change_Orders_status");
   //driver vendor
    Route::get('getDrivers','DriverController@index');
    Route::get('getDriverOrders','DriverController@getDriverOrders');
    Route::get('AssainToDriver','DriverController@AssainToDriver');

    
      });
      
    //driver   
    
    Route::group(['middleware' => ['DriverMiddleware']], function() {
    
        Route::get('DriverOrders','DriverController@DriverOrders');
        
        Route::post('StartDelivery','DriverController@StartDelivery');
        Route::post('SetStatus','DriverController@SetStatus');
        Route::get('GetStatus','DriverController@GetStatus');
    
        
    });
       
    Route::get("getItemWithCategory","vendor_controller@gelAllItemsWithCategory");
    Route::get("getRandomItem","vendor_controller@getRandomItem");
    Route::get("get_most_popular_item","vendor_controller@getmostpopular");


    
    
    Route::post("location/delivery_price","DeliveryPriceController@getDeliveryPrice");
    
    Route::get("get_delivery_price","DeliveryPriceController@getDeliveryPricelatlng");


    // order vendor same vendor controller

  


  
    //promo code
    
    Route::get("AddPromocode","promoCode_controller@AddPromocode");
    Route::get("usePromocode","promoCode_controller@usePromoCode");
        Route::post("checkpromo/{phone_number}/{title}","promoCode_controller@checkpromo");

    Route::post("CheckPromoCode/{phone_number}","promoCode_controller@CheckPromoCode");


    
    //Brachs Rating
    Route::get("getBrachRating","RatingBranchController@getBrachRating");
    Route::post("setBrachRating","RatingBranchController@setBrachRating");

   //message
   
       Route::get("getWelcomeMessage","WelcomeMessageControllre@getWelcomeMessage");

  

    });

    });
    



        



    
    //Ajax Call
    
    // Change User App Status
    Route::post("users/app/change_status", "Web\UsersController@changeStatus");
    Route::post("users/app/change_type", "Web\UsersController@changeType");
    Route::post("branch/slider/delete", "Web\BranchTableController@deleteSlider");
    Route::post("addOn/option/delete", "Web\AddOnsOptionsController@destroy");


