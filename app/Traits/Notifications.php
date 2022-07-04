<?php
namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait Notifications{

    public $notifications_en_text = [
        "pending_order" => [
            "title" => "Your Order ID #%d Has Been Received Successfully",
            "body" => "Your order is now under review"
        ],
        "accept_order" => [
            "title" => "Your Order ID is #%d Has Been Accepted",
            "body" => "the order will be preparing soon .."
        ],
        "prepare_order" => [
            "title" => "Your Order ID #%d Has Been Prepared",
            "body" => "the order will be ready soon .."
        ],
        "ready_order" => [
            "title" => "Your Order ID #%d Is Ready Now",
            "body" => "the order will be delivered to you soon .."
        ],
        "delieverd_order" => [
            "title" => "Your Order ID #%d Has Been Delieverd",
            "body" => "thank your for your choice of Fatteh&Sanawbar restaurant"
        ],
        "reject_order" => [
            "title" => "Your Order ID #%d Has Been Rejected",
            "body" => "your order has been rejected for some reasons , please contact with order management team"
        ],

    ];
    public $notifications_ar_text = [
        "pending_order" => [
            "title" => "تم إستلام طلبك رقم %d بنجاح",
            "body" => "طلبك قيد المراجعة الآن"
        ],
        "accept_order" => [
            "title" => "تمت الموافقة على طلبك رقم %d",
            "body" => "سيتم تحضيره في أقرب وقت"
        ],
        "prepare_order" => [
            "title" => "تم تحضير طلبك رقم %d",
            "body" => "سيتم تجهيزه في أقرب وقت"
        ],
        "ready_order" => [
            "title" => "طلبك رقم %d جاهز الآن",
            "body" => "سيتم توصيله إليك لاحقا"
        ],
        "delieverd_order" => [
            "title" => "تم توصيل طلبك رقم %d",
            "body" => " شكرا لأختيارك مطعم الوجبة الذهبية فتة و صنوبر"
        ],
        "reject_order" => [
            "title" => "تم رفض طلبك رقم %d",
            "body" => "لسبب ما ، يرجى التواصل مع فريق إدارة الطلبات"
        ],
    ];

    public function getNotificationTextDetails($key, array $params = []){
        if(array_key_exists($key, $this->notifications_en_text)){
            $notification = $this->getOrderNotificationDetails($key, $params);
            return [
                "title" => [
                    "en" => $notification["title"]["en"],
                    "ar" => $notification["title"]["ar"],
                ],
                "body" => [
                    "en" => $notification["body"]["en"],
                    "ar" => $notification["body"]["ar"],
                ],
            ];
        }
        return [];
    }

    public function getOrderNotificationDetails($key, $params = []){
        $notification = [];
        if(empty($params)){
            $notification["title"]["en"] = $this->notifications_en_text[$key]["title"];
            $notification["title"]["ar"] = $this->notifications_ar_text[$key]["title"];
            $notification["body"]["en"] = $this->notifications_en_text[$key]["body"];
            $notification["body"]["ar"] = $this->notifications_ar_text[$key]["body"];
        }else {
            $notification["title"]["en"] = sprintf($this->notifications_en_text[$key]["title"], $params["order_id"]);
            $notification["title"]["ar"] = sprintf($this->notifications_ar_text[$key]["title"], $params["order_id"]);
            $notification["body"]["en"] = sprintf($this->notifications_en_text[$key]["body"], $params["order_id"]);
            $notification["body"]["ar"] = sprintf($this->notifications_ar_text[$key]["body"], $params["order_id"]);
        }
        return $notification;

    }
}
