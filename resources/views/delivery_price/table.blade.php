@extends("layouts.dashboard.app")
@section("page-title")
    Delivery Price
@endSection
@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> All Delivery Price </h1>
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
                                <th>From </th>
                                <th>To </th>
                                <th>Price</th>
                                <th>Support</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $Deliverykm)
                            <tr>

                                <td>{{$Deliverykm -> id}}</td>
                                <td>{{$Deliverykm -> from_km}} Km</td>
                                <td>{{$Deliverykm -> to_km}} Km</td>
                                <td>{{$Deliverykm -> price}}</td>
                                <td>{{$Deliverykm->support == 1 ? "Active" : "Non-Active"}}</td>
                                <td>
                                       <a href="{{route("delivery_price.edit", $Deliverykm->id)}}" class="control-link edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{route("delivery_price.destroy",$Deliverykm->id)}}" method="post" id="delete{{$Deliverykm->id}}" style="display: none" data-swal-title="Delete Location" data-swal-text="Are Your Sure To Delete This Record ?" data-yes="Yes" data-no="No" data-success-msg="the Record has been deleted succssfully">@csrf @method("delete")</form>
                                    <span href="#" class="control-link remove form-confirm" data-form-id="#delete{{$Deliverykm->id}}"><i class="far fa-trash-alt"></i></span>
                                    
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

    
@endsection
