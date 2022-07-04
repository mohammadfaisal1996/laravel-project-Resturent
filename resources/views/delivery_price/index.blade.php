@extends("layouts.dashboard.app")
@section("page-title")
    Delivery Price
@endSection
@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> All Delivery Price Locations</h1>
            <p>Control and view all Delivery Price Locations</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Delivery Price</a></li>
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
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Support</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $location)
                            <tr>

                                <td>{{$location->id}}</td>
                                <td>
                                    {{ $location->country .
                                     (!empty($location->governorate)    ?   " - "  . $location->governorate     : null) . 
                                     (!empty($location->locality)       ?   " - "  .  $location->locality       : null) . 
                                     (!empty($location->sub_locality)   ?   " - "  .  $location->sub_locality   : null) . 
                                     (!empty($location->neighborhood)   ?   " - "  .  $location->neighborhood   : null)
                                    }}
                                </td>
                                <td>{{$location->price >=0 ? $location->price . " JOD" : null}}</td>
                                <td>{{$location->supported == 1 ? "Yes" : "No"}}</td>
                                <td>
                                    <a href="{{route("delivery_price.edit", $location->id)}}" class="control-link edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{route("delivery_price.destroy", $location->id)}}" method="post" id="delete{{$location->id}}" style="display: none" data-swal-title="Delete Location" data-swal-text="Are Your Sure To Delete This Location ?" data-yes="Yes" data-no="No" data-success-msg="the location has been deleted succssfully">@csrf @method("delete")</form>
                                    <span href="#" class="control-link remove form-confirm" data-form-id="#delete{{$location->id}}"><i class="far fa-trash-alt"></i></span>
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
