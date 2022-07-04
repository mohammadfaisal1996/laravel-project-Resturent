<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\ItemsList;
use App\Models\BranchTable;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{


    public function index(){
        $data["totalUsersApp"] = User::count();
        $data["totalOrders"] = Order::count();
        $data["totalItems"] = ItemsList::count();
        $data["totalBranches"] = BranchTable::count();
        $rows = Order::select([DB::raw("COUNT(*) as total_orders"),DB::raw("SUM(Total_Amount) as sales"), DB::raw("Month(created_at) as month")])
                    ->where(DB::raw("YEAR(created_at)"), DB::raw("YEAR(CURRENT_TIMESTAMP)"))
                    ->groupby(DB::raw("Month(created_at)"))->get();
        $cuurentMonth = date("n",time());
        for ($month=1; $month <= $cuurentMonth ; $month++) { 
            $orders[date("F", mktime(0,0,0,$month,10))] = ["total_orders"=> 0 , "sales" => 0];
        }
        foreach($rows as $row){
            $orders[date("F", mktime(0,0,0, $row["month"], 10))]["total_orders"] = $row["total_orders"];
            $orders[date("F", mktime(0,0,0, $row["month"], 10))]["sales"] = $row["sales"];
        }
        $data["orders"] = $orders;
        
        return view("dashboard.index", $data);
    }
}
