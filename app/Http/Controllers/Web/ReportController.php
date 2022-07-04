<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use Helper;
    public function itemsCountOrder()
    {
        $data["items"] = DB::table("items_list")
            ->select(["items_list.*" , "category_list.category_name_en", "category_list.category_name_ar",
                DB::raw("COUNT(order_items.id) as 'itemsNumber'")])
            ->leftJoin("order_items", "items_list.id", "=", "order_items.item_id")
            ->join("category_list","category_list.id", "=", "items_list.category_id")
            ->groupBy("items_list.id")->orderBy("itemsNumber",'desc')->get();
        return view("reports.items_count_order", $data);

    }


    public function filter_items_count(Request $request){

        $validator = Validator::make($request->all(), [
            "FromDate"=>["before_or_equal:ToDate"],
            "ToDate" => ["required"]
        ]);

        if ($validator->fails()) {

            return redirect()->route("reports.items_count_order")
                ->withErrors($validator)
                ->withInput();
        }
        $fromDate=$request->FromDate;
        $toDate=$request->ToDate;

        $data["items"] = DB::table("items_list")
            ->select(["items_list.*" , "category_list.category_name_en", "category_list.category_name_ar",
                DB::raw("COUNT(order_items.id) as 'itemsNumber'")])
            ->leftJoin("order_items", "items_list.id", "=", "order_items.item_id")
            ->leftJoin("orders", "orders.id", "=", "order_items.order_id")
            ->join("category_list","category_list.id", "=", "items_list.category_id")
            ->groupBy("items_list.id")->orderBy("itemsNumber",'desc')->whereBetween("orders.created_at",[$fromDate, $toDate])->get();
        return view("reports.items_count_order", $data);


    }


    public function exportItemsCountOrderAsExcel(){



        $items = DB::table("items_list")
            ->select(["items_list.*" , "category_list.category_name_en", "category_list.category_name_ar",
                DB::raw("COUNT(order_items.id) as 'itemsNumber'")])
            ->leftJoin("order_items", "items_list.id", "=", "order_items.item_id")
            ->join("category_list","category_list.id", "=", "items_list.category_id")
            ->groupBy("items_list.id")->orderBy("itemsNumber",'desc')->get();

        return $this->downloadExcelFile(
            ["id","item_name_en", "item_name_ar", "item_price",
                "category_name_en" , "category_name_ar", "itemsNumber"
            ], $items,
            ["id","english name", "arabic name", "price",
                "category english name","category arabic name", "number times ordered"]);
    }

    public function getUsersWithCountOrdersHim(){

        $data["users"] = DB::table("users")
            ->select(["users.*" , DB::raw("COUNT(orders.id) as 'countOrders'")])
            ->leftJoin("orders", "orders.phone_number", "=", "users.phone_number")
            ->groupBy("users.id")->orderBy("countOrders",'desc')->get();
        return view("reports.users_count_orders", $data);

    }

    public function filter_user_reports(Request $request){

        $validator = Validator::make($request->all(), [
            "FromDate"=>["before_or_equal:ToDate"],
            "ToDate" => ["required"]
        ]);

        if ($validator->fails()) {

            return redirect()->route("reports.users_with_count_him_orders")
                ->withErrors($validator)
                ->withInput();
        }
        $fromDate=$request->FromDate;
        $toDate=$request->ToDate;

        $data["users"] = DB::table("users")
            ->select(["users.*" , DB::raw("COUNT(orders.id) as 'countOrders'")])
            ->leftJoin("orders", "orders.phone_number", "=", "users.phone_number")
            ->groupBy("users.id")->orderBy("countOrders",'desc')->whereBetween("orders.created_at",[$fromDate, $toDate])->get();
        return view("reports.users_count_orders", $data);


    }


    public function exportUsersWithCountOrdersHimAsExcel(){



        $users = DB::table("users")
            ->select(["users.*" , DB::raw("COUNT(orders.id) as 'countOrders'")])
            ->leftJoin("orders", "orders.phone_number", "=", "users.phone_number")
            ->groupBy("users.id")->orderBy("countOrders",'desc')->get();

        return $this->downloadExcelFile(
            ["id","firstName", "phone_number", "countOrders"] , $users,
            ["id","first name", "Phone number","Orders"], "users_orders.xlsx");
    }




}
