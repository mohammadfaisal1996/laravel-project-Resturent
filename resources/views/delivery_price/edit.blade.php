@extends("layouts.dashboard.app")
@section("page-title")
    Delivery Price
@endSection
@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Delivery Price</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("delivery_price.index")}}">Delivery Price</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ul>
    </div>
@endsection
@section("content")
@include("layouts.main-parts.page-message")
    <div class="row parent-box">
        <div class="col-lg-10 m-auto map-box">
            <div class="tile">
                <h3 class="tile-title">Edit Delivery  Price</h3>
                <div class="tile-body" id="parent-box">
                    <!--- Info Section --->

                    <div id="info-box">
                        <form method="post" action="{{ route("delivery_price.update",$Delivery->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method("put")

                            <div class="form-group">
                                
                                
                                       
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="control-label">From Km</label>
                                        <input class="form-control @if($errors->has('from_km')) is-invalid @endif" type="text" name="from_km" placeholder="Enter The Delivery Location Price" value="{{inputValue("from_km",$Delivery) > 0 ? inputValue("from_km",$Delivery) : null}}">
                                    </div>
                                    @error("price")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                  </div>
                                       
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="control-label">To Km</label>
                                        <input class="form-control @if($errors->has('to_km')) is-invalid @endif" type="text" name="to_km" placeholder="Enter The Delivery Location Price" value="{{inputValue("to_km",$Delivery) > 0 ? inputValue("to_km",$Delivery) : null}}">
                                    </div>
                                    @error("price")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                
                                
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input class="form-control @if($errors->has('price')) is-invalid @endif" type="text" name="price" placeholder="Enter The Delivery Location Price" value="{{inputValue("price",$Delivery) > 0 ? inputValue("price",$Delivery) : null}}">
                                    </div>
                                    @error("price")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                
                                
                                
                                <div class="col-lg-6">
                                    <label class="control-label">Supported</label>
                                    <div class="toggle-flip">
                                        <label>
                                               <input type="checkbox" name="support" {{ checked("support", ['on',1], $Delivery)}}><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                        </label>
                                    </div>
                                </div>
                          
                          
                            <div class="tile-footer">
                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")


@endsection
