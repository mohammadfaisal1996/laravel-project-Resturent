<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table="orders";

    protected $fillable=['order_number','paymentMethod','totalQty','Total_Amount','DropOffAddressLat','phone_number','instruction','tax','LoyaltyPointsSpent','PromoCode','StreetName','PickupType','DropOffAddressLong','branchSelected',"deliveryFee","FCM_TOKEN"];
}


