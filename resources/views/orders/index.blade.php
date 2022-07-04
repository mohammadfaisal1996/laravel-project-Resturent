@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Orders</h1>
            <p>Control and view Orders</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">

                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-12">
                                    <label for="">Filter By Status</label>
                                    <div class="form-group">
                                        <select name="" id="status-filter" class="form-control">
                                            <option data-value="0" value="" selected>All</option>
                                            <option data-value="1" value="pending">Pending</option>
                                            <option data-value="2" value="Accept">Accept</option>
                                            <option data-value="3" value="Prepare">Prepare</option>
                                            <option data-value="4" value="Ready">Ready</option>
                                            <option data-value="5" value="Delieverd">Delieverd</option>
                                            <option data-value="6" value="Reject">Reject</option>
                                        </select>
                                    </div>


                                </div>
                                <div class="col-lg-8 p-4 text-right">
                                    <form action="{{route("orders.export.excel")}}" method="post"  id="form-excel">
                                        @csrf
                                        <input type="hidden" name="status" value="0">
                                        <span  class="download-excel btn btn-primary"><i class="far fa-fw fa-lg  fa-file-excel text-left"></i> Export As Excel</span>

                                    </form>
                                </div>



                                <div class="col-lg-12 col-md-8 col-sm-12 mb-4">
                                    <label for="">Filter By Date</label>
                                    <div class="row">
                                        <div class ="col-lg-4 col-sm-8">
                                            <form method="post" id="Fromto" name="Fromto" action="{{Route("orders.from.to.filter")}}">@csrf

                                                from : <input class="form-control" name="FromDate" type="date">
                                                to: <input class="form-control" id="to"  name="ToDate" type="date"  onchange='document.getElementById("Fromto").submit();' >
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($errors->all() as $error)
                                    <div class="ml-4 input-error">{{ $error }}</div>
                                @endforeach




                            </div>
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Order number</th>
                                <th>Phone number</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                                <th>Total Quantity</th>
                                <th>Tax</th>
                                <th>Total Amount</th>
                                <th>Address</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>instruction</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->order_number}}</td>
                                <td>{{$order->phone_number}}</td>
                                <td>
                                 @switch($order->Status)
                                        @case(1) Pending @break
                                        @case(2) Accept @break
                                        @case(3) Prepare @break
                                        @case(4) Ready @break
                                        @case(5) Delieverd @break
                                        @case(6) Reject @break
                                    @endswitch

                                </td>
                                <td>{{$order->paymentMethod}}</td>
                                <td>{{$order->totalQty}}</td>
                                <td>{{$order->tax}}</td>
                                <td>{{$order->Total_Amount}}</td>
                                <td>{{$order->DropOffAddress}}</td>
                                <td>{{$order->created_at->diffForhumans()}}</td>
                                <td>{{$order->updated_at->diffForhumans()}}</td>
                                <td>{{$order->instruction}}</td>
                                <td>
                                    <a href="{{route("orders.details", $order->id)}}" class="control-link"><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("scripts")
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset("assets/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("assets/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">
        let table = $('#sampleTable').DataTable();


        $("#status-filter").on("change",function (){
             console.log($(this).val());
           table.column(3).search($(this).val()).draw();
        });

    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
        if(document.location.hostname == 'pratikborsadiya.in') {
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    </script>
    <script type="text/javascript">
        $(".download-excel").click(function (e){
            e.preventDefault();

            let status = $("#status-filter option:selected").data("value");
            $(this).siblings("input[name='status']").val(status);


            $("#form-excel").submit();

        });




    </script>
@endsection

