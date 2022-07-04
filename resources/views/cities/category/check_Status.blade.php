
@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Check Categories Status</h1>
        
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("categories.index")}}">Categories</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New Category</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("categories.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Start check time </label>
                                    <input class="form-control @if($errors->has('start_check_status')) is-invalid @endif" type="time" name="start_check_status" placeholder="Enter English Category name" value="{{inputValue("start_check_status")}}">
                                </div>
                                @error("start_check_status")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            
                            
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">End check time</label>
                                    <input class="form-control @if($errors->has('end_check_status')) is-invalid @endif" type="tiem" name="end_check_status" placeholder="Enter Arabic Category name" value="{{inputValue("end_check_status")}}">
                                </div>
                                @error("end_check_status")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            
                            
                            
    
                        </div>
                        <hr>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
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
