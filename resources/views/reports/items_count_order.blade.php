@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Count Items have Ordered</h1>
            <p>items</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Count Items have Ordered</a></li>
        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")
    <div class="row bg-white">

        <div class="col-lg-6 m-2">
            <div class="row">
                <div class="col-lg-4 m-5">
                    <label>Filter By Date</label>
                    <form method="post" id="Fromto" name="Fromto" action="{{Route("items_count_order.filter")}}">@csrf
                        from : <input class="form-control" name="FromDate" type="date">
                        to: <input class="form-control" id="to"  name="ToDate" type="date"  onchange='document.getElementById("Fromto").submit();' >
                    </form>
                </div>
            </div>
            @foreach ($errors->all() as $error)
                <div class="ml-4 input-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="col-lg-5 mt-5 text-right">
            <a href="{{route("reports.items_count_order.export.excel")}}"  class="btn btn-primary"><i class="far fa-fw fa-lg  fa-file-excel text-left"></i> Export As Excel</a>
        </div>


        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Item Image</th>
                                <th>English Item name</th>
                                <th>Arabic Item name</th>
                                <th>Item price</th>
                                <th>Arabic Category name</th>
                                <th>English Category name</th>
                                <th>Number Times Orderd</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td><img src="{{$item->item_image}}" alt="" style="width: 90px"></td>
                                    <td>{{$item->item_name_en}}</td>
                                    <td>{{$item->item_name_ar}}</td>
                                    <td>{{$item->item_price}}</td>
                                    <td>{{$item->category_name_ar}}</td>
                                    <td>{{$item->category_name_en}}</td>

                                    <td>{{$item->itemsNumber}}</td>
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
