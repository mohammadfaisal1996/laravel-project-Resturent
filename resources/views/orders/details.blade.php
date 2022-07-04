@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Order Details</h1>
            <p>Control and view all Add Ons</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("orders.index")}}">Orders</a></li>
            <li class="breadcrumb-item"><a href="#">{{$order->id}}</a></li>
            <li class="breadcrumb-item"><a href="#">Details</a></li>
        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")
    <div class="row">
        <div class="col-lg-12">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="order-info">
                            <label>Order number</label>
                            <div class="value">#{{$order->id}}</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="order-info">
                            <label>Order Date</label>
                            <div class="value">{{$order->created_at}}</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="order-info">
                            <label>Total Price</label>
                            <div class="value">{{$order->Total_Amount}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title">Items</div>
                <div class="tile-body">
                    @foreach($order->items as $item)
                    <div class="tile">
                        <div class="row">
                            <div class="col-lg-2">
                                <img src="{{$item->item_image}}" alt="" class="full-box-img">
                            </div>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <h5>{{$item->item->item_name_ar}}</h5>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="order-info mb-3">
                                            <label style="font-size: 18px">Item Price</label>
                                            <div class="value" style="font-size: 16px">{{$item->itemPrice}} JOD</div>
                                        </div>

                                        <div class="order-info">
                                            <label style="font-size: 18px">quantity </label>
                                            <div class="value" style="font-size: 16px">{{$item->quantity}}</span></div>
                                        </div>


                                        <div class="order-info mt-3">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong{{$item->id}}">
                                                Show Addons
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalLong{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            @foreach($item->addOns as $addOn)

                                                                <div class="mt-4">
                                                                    Addons category : <span class="h5">{{$addOn->AddOns_Category_name}}</span>
                                                                    <table class="table table-hover table-bordered" id="sampleTable">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#ID</th>
                                                                            <th>Addon Name </th>
                                                                            <th>Addon price </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                       @foreach($addOn->AddOnsTitle->addOnsList AS $addonsData)
                                                                           <tr>
                                                                           <td>{{$addonsData->id}}</td>
                                                                           <td>{{$addonsData->add_ons_list_ar}}</td>
                                                                           <td>{{$addonsData->price}}</td>
                                                                           </tr>                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            @endforeach

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@section("scripts")
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset("assets/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("assets/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
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
@endsection
