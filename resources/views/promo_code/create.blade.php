@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Promo Code</h1>
            <p>Control Promo Code </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("branches.index")}}">Promo Code</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New Promo Code</h3>
                <div class="tile-body">
                    
                    <!--`id`, `title`, `type`, `value`, `status`, `start_time`, `End_time`, `min`, `max`,-->
                    
                    
                    <form method="post" action="{{route("promoCode.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Promo code Title</label>
                                    <input class="form-control @if($errors->has('title')) is-invalid @endif" type="text" name="title" placeholder="Enter title" value="{{inputValue("title")}}">
                                </div>
                                @error("title")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Enter Max use number </label>
                                    <input class="form-control @if($errors->has('max')) is-invalid @endif" type="number" name="max" placeholder="Enter Max Use" value="{{inputValue("max")}}">
                                </div>
                                @error("max")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="col-lg-6 " >
                                        <div class="form-group">
                                                <label for="exampleSelect1" >Promo Code Type</label>
                                                <select class="form-control @if($errors->has('type')) is-invalid @endif"  id="NavigateList" name="type"  >
                                                    @if(inputValue("type") == "value")
                                                    
                                                    <option value="value">Value</option>
                                                    <option value="percentage">percentage</option>
                                                    
                                                    @elseif(inputValue("type") == "percentage")
                                                    
                                                    <option value="percentage">percentage</option>
                                                    <option value="value">Value</option>

                                                    @else
                                                    <option value="">None</option>
                                                    <option value="value">Value</option>
                                                    <option value="percentage">percentage</option>
                                                    @endif
                                                </select>
                                                
                                                
                                        </div>
                                    @error("type")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                            </div>
                                
                                
                                   <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Enter Value </label>
                                    <input class="form-control @if($errors->has('value')) is-invalid @endif" type="number" name="value" placeholder="Enter value" value="{{inputValue("value")}}">
                                </div>
                                @error("value")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                                
                                
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Select Start Time</label>
                                        <input class="form-control @if($errors->has('start_time')) is-invalid @endif" type="date" name="start_time"  value="{{inputValue("start_time")}}">
                                        </div>
                                        @error("start_time")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                            </div>
                            
                            
                            
                         
                            
                            
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Select End  Time</label>
                                        <input class="form-control @if($errors->has('End_time')) is-invalid @endif" type="date" name="End_time"  value="{{inputValue("End_time")}}">
                                        </div>
                                        @error("End_time")
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                            </div>
                            
                           
                        </div>

                   
                   
               

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
