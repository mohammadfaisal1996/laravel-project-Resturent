<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="orders";
    protected $fillable=['order_number','paymentMethod','totalQty','Total_Amount','DropOffAddressLat','phone_number','instruction','tax','LoyaltyPointsSpent','PromoCode','StreetName','PickupType','DropOffAddressLong','branchSelected',"deliveryFee",'FCM_TOKEN'];




    public function items(){
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }
}
