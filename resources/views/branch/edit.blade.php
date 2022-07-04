@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Branches</h1>
            <p>Control and view all Branches of Store</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("branches.index")}}">Branches</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
            <li class="breadcrumb-item"><a href="#">{{$branch->store_name}}</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Edit Branch</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("branches.update", $branch->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="row">


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">English Branch Name</label>
                                    <input class="form-control @if($errors->has('branch_place')) is-invalid @endif" type="text" name="branch_name" placeholder="Branch place" value="{{inputValue("branch_name", $branch, "store_name_en")}}">
                                </div>
                                @error("branch_name")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Arbic Branch Name</label>
                                    <input class="form-control @if($errors->has('branch_place')) is-invalid @endif" type="text" name="branch_name_ar" placeholder="Branch place" value="{{inputValue("branch_name_ar", $branch, "store_name_ar")}}">
                                </div>
                                @error("branch_name_ar")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>


                                       <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">English Location  Name</label>
                                    <input class="form-control @if($errors->has('location_name_en')) is-invalid @endif" type="text" name="location_name_en" placeholder="Branch name" value="{{inputValue("location_name_en",$branch)}}">
                                </div>
                                @error("location_name_en")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Arbic Location Name </label>
                                        <input class="form-control @if($errors->has('location_name_ar')) is-invalid @endif" type="text" name="location_name_ar" placeholder="Branch name" value="{{inputValue("location_name_ar",$branch)}}">
                                        </div>
                                        @error("location_name_ar")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input class="form-control @if($errors->has('phone_number')) is-invalid @endif" type="text" name="phone_number" placeholder="example : 0791234567" value="{{inputValue("phone_number", $branch)}}">
                                </div>
                                @error("phone_number")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Tax</label>
                                    <input class="form-control @if($errors->has('Tax')) is-invalid @endif" type="number" name="Tax"  step="0.01"  value="{{inputValue("tax",$branch)}}">
                                </div>
                                @error("Tax")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Image URL</label>
                                    <div>
                                        <button class="btn btn-primary form-control button-upload-file" >
                                            <input class="input-file" type="file" name="img">
                                            <span class="upload-file-content">
                                            <i class="fas fa-upload fa-lg upload-file-content-icon left"></i>
                                            <span class="upload-file-content-text">Upload Image</span>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                                @error("img")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <label class="control-label">Location</label>
                                    <div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#openMap">
                                            Locate on the Map
                                        </button>
                                        <div class="modal fade" id="openMap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Locate on The Map</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="map"></div>
                                                        <input type="hidden" name="latitude" id="lat" value="{{inputValue("latitude",$branch)}}">
                                                        <input type="hidden" name="longitude" id="lng" value="{{inputValue("longitude",$branch)}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error("location")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{asset("assets/js/maps.js")}}"></script>
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_API_KEY")}}&callback=initMap&libraries=&v=weekly"
        async
    ></script>
@endsection
