@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Ons</h1>
            <p>Control and view all Add Ons</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Items</a></li>
            <li class="breadcrumb-item"><a href="#">{{$item->item_name_en}} ( {{$item->item_name_ar}} )</a></li>
            <li class="breadcrumb-item"><a href="#">Add Ons</a></li>
        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")
    <div class="row">
        <div class="col-lg-12">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-3">
                        <img src="{{$item->item_image}}" alt="" class="full-box-img">
                    </div>
                    <div class="col-lg-9">
                        <h3 class="tile-title">{{$item->item_name_en}} </h3>
                        <h3 class="tile-title">{{$item->item_name_ar}}</h3>
                        <h3 class="tile-title">${{$item->item_price}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn"><a href="{{route('items.add_ons.create', $item->id)}}" class="btn btn-primary">Create New Add On's Category</a></div>
                <div class="tile-title">Add Ons Categories</div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>English name</th>
                                <th>Arabic name</th>
                                
                                <th>Min Choice option </th>
                                <th>Max Choice option </th>
                                
                                
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addOns as $addOn)
                                <tr>
                                    <td>{{$addOn->id}}</td>
                                    <td>{{$addOn->add_ons_name_en}}</td>
                                    <td>{{$addOn->add_ons_name_ar}}</td>
                                    <td>{{$addOn->min}}</td>
                                    <td>{{$addOn->max}}</td>

                                    <td>
                                        <a href="{{route("items.add_ons.edit", [$item->id, $addOn->id])}}" class="control-link edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{route("items.add_ons.destroy", [$item->id, $addOn->id])}}" method="post" id="delete{{$addOn->id}}" style="display: none" data-swal-title="Delete Add On" data-swal-text="Are Your Sure To Delete This Add On ?" data-yes="Yes" data-no="No" data-success-msg="the Add On has been deleted succssfully">@csrf @method("delete")</form>
                                        <span href="#" class="control-link remove form-confirm"  data-form-id="#delete{{$addOn->id}}"><i class="far fa-trash-alt"></i></span>
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
