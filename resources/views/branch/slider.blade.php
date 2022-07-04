@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Branch Slider</h1>
            <p>Control and view all Branches of Store</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("branches.index")}}">Branches</a></li>
            <li class="breadcrumb-item"><a href="#">Slider</a></li>
            <li class="breadcrumb-item"><a href="#">{{$branch->store_name}}</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Edit Branch Slider</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("branch.slider.save")}}" enctype="multipart/form-data">
                        @if(count($errors) > 0)
                        <div class="alert-danger alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @csrf
                        @method("put")
                        @if(!$branch->sliders->isEmpty())
                        <div class="row mt-4 mb-5">
                            @foreach($branch->sliders as $slider)
                            <div class="col-lg-2 slider">
                                <div class="text-center">
                                    <img src="{{$slider->image_url}}" alt="" class="full-box-img">
                                </div>
                                <span
                                    class="btn btn-primary d-block delete-slider"
                                    data-branchId="{{$branch->id}}"
                                    data-imageId="{{$slider->id}}">Delete Image</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Images</label>
                                    <div>
                                        <button class="btn btn-primary form-control button-upload-file" >
                                            <input class="input-file" type="file" name="images[]" multiple>
                                            <span class="upload-file-content">
                                            <i class="fas fa-upload fa-lg upload-file-content-icon left"></i>
                                            <span class="upload-file-content-text">Upload Images</span>
                                        </span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="branch_id" value="{{$branch->id}}">

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
