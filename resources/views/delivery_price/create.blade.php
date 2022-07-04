@extends("layouts.dashboard.app")
@section("page-title")
    Delivery Price
@endSection
@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Delivery Price</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("delivery_price.index")}}">Delivery Price</a></li>
            <li class="breadcrumb-item"><a href="#">Add</a></li>
        </ul>
    </div>
@endsection
@section("content")
@include("layouts.main-parts.page-message")
    <div class="row parent-box">
        <div class="col-lg-10 m-auto map-box">
            <div class="tile">
                <h3 class="tile-title">Add Delivery  Price</h3>
                <div class="tile-body" id="parent-box">
                    <!--- Info Section --->

                    <div id="info-box">
                        <form method="post" action="{{ route("delivery_price.store")}}" enctype="multipart/form-data">
                            @csrf
                          

                            <div class="form-group">
                                
                                
                                       
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="control-label">From Km</label>
                                        <input class="form-control @if($errors->has('from_km')) is-invalid @endif" type="number" name="from_km" placeholder="Enter The Delivery From Km "  min="0"  value="{{ inputValue("from_km") }}">
                                    </div>
                                    @error("from_km")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                  </div>
                                       
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="control-label">To Km</label>
                                        <input class="form-control @if($errors->has('to_km')) is-invalid @endif" type="number" name="to_km" placeholder="Enter The Delivery To Km "  min="0" value="{{ inputValue("to_km") }}">
                                    </div>
                                    @error("to_km")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                
                                
                                
                                <div class="col-lg-6 mb-1">
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input class="form-control @if($errors->has('price')) is-invalid @endif" type="number" step="0.01" name="price"  min="0" placeholder="Enter The Delivery  Price" value="{{ inputValue("price") }}">
                                    </div>
                                    @error("price")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                                
            
                            <div class="tile-footer mt-5">
                                <button class="btn btn-success" type="submit">ADD</button>
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
