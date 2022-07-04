@extends("layouts.dashboard.app")

@section('css-links')
    <style>
        #info-box{display: none;}
    </style>
@endsection

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Delivery Price</h1>
            <p>should by define the location to add the delivery price</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("branches.index")}}">Delivery Price</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row parent-box">
        <div class="col-lg-10 m-auto map-box">
            <div class="tile">
                <h3 class="tile-title">Add New Delivery Location Price</h3>
                <div class="tile-body" id="parent-box">

                    <!--- Map Section --->

                    <div id="map-box">
                        <div id="map"></div>
                        <input type="hidden" name="latitude" id="lat" value="{{inputValue("latitude")}}">
                        <input type="hidden" name="longitude" id="lng" value="{{inputValue("longitude")}}">

                        <div class="tile-footer text-right">
                            <button class="btn btn-primary fetchAddressInfo" >Next<i class="fa fa-fw fa-lg fa-arrow-right" style="margin-left: 7px;margin-right:0"></i></button>
                        </div>
                    </div>

                    <!--- Info Section --->

                    <div id="info-box">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div id="location" class="text-with-icon">
                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="text"></span>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input class="form-control @if($errors->has('price')) is-invalid @endif" type="text" name="price" placeholder="Enter The Delivery Location Price" value="{{inputValue("price")}}">
                                    </div>
                                    @error("price")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tile-footer text-right">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
                            </div>
                        </form>
                    </div>


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
