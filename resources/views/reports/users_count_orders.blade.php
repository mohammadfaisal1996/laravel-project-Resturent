@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Users With Count of Orders</h1>
            <p>Users</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Users With Count of Orders</a></li>
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
                    <form method="post" id="Fromto" name="Fromto" action="{{Route("reports.users.filter")}}">@csrf
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
            <a href="{{route("reports.users_with_count_him_orders.export.excel")}}" class="mt-5 btn btn-primary"><i class="far fa-fw fa-lg  fa-file-excel text-left"></i> Export As Excel</a>
        </div>







        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Full Name</th>
                                <th>Phone number</th>
                                <th>Orders</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->firstName}}</td>
                                    <td>{{$user->phone_number}}</td>
                                    <td>{{$user->countOrders}}</td>
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
