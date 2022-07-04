@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> promo code</h1>
            <p>Control and view all promo code</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">promo codes</a></li>
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
                                <th>Title</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>max number of used</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($promoCodes as $promoCode)
                            <tr>

                                <td>{{$promoCode->id}}</td>
                                <td>{{$promoCode->title}}</td>
                                <td>{{$promoCode->type}}</td>
                                <td>{{$promoCode->value}}</td>
                                <td>{{$promoCode->start_time}}</td>
                                <td>{{$promoCode->End_time}}</td>
                                <td>{{$promoCode->max}}</td>
                                
                                <td>
                                <a href="{{route("promoCode.edit", $promoCode->id)}}" class="control-link edit"><i class="fas fa-edit"></i></a>
                                <form action="{{route("promoCode.destroy", $promoCode->id)}}" method="post" id="delete{{$promoCode->id}}" style="display: none" data-swal-title="Delete Promo Code" data-swal-text="Are Your Sure To Delete This promo code ?" data-yes="Yes" data-no="No" data-success-msg="the branch has been deleted succssfully">@csrf @method("delete")</form>
                                <span href="#" class="control-link remove form-confirm" data-form-id="#delete{{$promoCode->id}}"><i class="far fa-trash-alt"></i></span>
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

@endsection
