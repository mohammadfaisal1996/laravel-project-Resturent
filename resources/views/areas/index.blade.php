@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Ons</h1>
            <p>Control and view all Add Ons</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">City</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $city->city_name }}</a></li>
            <li class="breadcrumb-item"><a href="#">Areas</a></li>
        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn"><a href="{{route('area.create', $city->id)}}" class="btn btn-primary">Create New Area</a></div>
                <div class="tile-title">Areas of {{ $city->city_name }}</div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Area name</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($city->areas as $area)
                                <tr>
                                    <td>{{$area->id}}</td>
                                    <td>{{$area->area_name}}</td>
                                    <td>
                                        {{-- <a href="{{route("area.edit", [ "id" => $addOn->id, $city->id])}}" class="control-link edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{route("area.destroy", [$item->id, $addOn->id])}}" method="post" id="delete{{$addOn->id}}" style="display: none" data-swal-title="Delete Add On" data-swal-text="Are Your Sure To Delete This Add On ?" data-yes="Yes" data-no="No" data-success-msg="the Add On has been deleted succssfully">@csrf @method("delete")</form>
                                        <span href="#" class="control-link remove form-confirm"  data-form-id="#delete{{$addOn->id}}"><i class="far fa-trash-alt"></i></span> --}}
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
