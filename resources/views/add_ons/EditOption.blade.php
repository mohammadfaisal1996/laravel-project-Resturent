@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Edit Option</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Edit Option</h3>
                <div class="tile-body">
                    

                    
                    <form method="post" action="{{route("add_ons_option.update", $add_ons_list->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="row">
            
                    
                           <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">English Name</label>
                                            <input class="form-control @if($errors->has('add_ons_list_en')) is-invalid @endif" type="text" name="add_ons_list_en" placeholder="Enter English name" value="{{inputValue("add_ons_list_en",$add_ons_list)}}">
                                        </div>
                                        @error("add_ons_list_en")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Arabic Name</label>
                                            <input class="form-control @if($errors->has('add_ons_list_ar')) is-invalid @endif" type="text" name="add_ons_list_ar" placeholder="Enter English name" value="{{inputValue("add_ons_list_ar",$add_ons_list)}}">
                                        </div>
                                        @error("add_ons_list_ar")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Adding Price</label>
                                            <input class="form-control @if($errors->has('price')) is-invalid @endif" type="text" name="price" placeholder="Enter Price" value="{{inputValue("price",$add_ons_list)}}">
                                        </div>
                                        @error("price")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                            
                            
                            
                    
                         <div class="col-lg-12">
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>
                        </div>
                        </div>
                        
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
