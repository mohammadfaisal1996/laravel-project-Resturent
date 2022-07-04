<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\Helper;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;


class OrderController extends Controller
{
    use Helper;

    public function index(){
        $data["orders"] = Order::all();
        return view("orders.index",$data);
    }

    public function details($id){

        $data["order"] = Order::findOrFail($id);
        return view("orders.details",$data);


    }

    public function filter(Request  $request){

        $validator = Validator::make($request->all(), [
            "FromDate"=>["before_or_equal:ToDate"],
            "ToDate" => ["required"]
        ]);

        if ($validator->fails()) {

            return redirect()->route("orders.index")
                ->withErrors($validator)
                ->withInput();
        }



        $fromDate=$request->FromDate;
        $toDate=$request->ToDate;

        $data["orders"] = Order::whereBetween("created_at",[$fromDate, $toDate])->get();


        return view("orders.index",$data);


    }

        public function exportExcelFile(Request $request){
        $columns = [
            "order_number", "phone_number", "paymentMethod", "totalQty", "tax", "DropOffAddress", "Total_Amount",
            "custom" => [
                "name" => "Status",
                "values" =>
                    [
                        1 => "Pending",
                        2 => "Accept",
                        3 => "Prepare",
                        4 => "Ready",
                        5 => "Delivered",
                        6 => "Reject"
                    ]
            ],
        ];

        $headings = ["number", "phone number", "payment method",
            "total quantity", "tax", "address", "total amount", "status"];
        if(!isset($request->status) || $request->status == 0){
            $orders = Order::all();
        }else{
            $orders = Order::where("Status", $request->status)->get();
        }

        if($orders->isNotEmpty())

            return $this->downloadExcelFile($columns, $orders, $headings,"orders.xlsx");
        else
            return redirect()->back();

    }

}
