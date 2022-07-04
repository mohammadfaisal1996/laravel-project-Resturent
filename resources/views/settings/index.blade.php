@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> App Settings</h1>
            <p>App Settings</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">App Settings</a></li>
        </ul>
    </div>
@endsection
@section("content")
@include("layouts.main-parts.page-message")

    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">App Settings</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("settings.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input class="form-control @if($errors->has('phone_number')) is-invalid @endif" type="text" name="phone_number" placeholder="Phone number" value="{{inputValue("phone_number", $settings)}}">
                                </div>
                                @error("phone_number")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Website URL</label>
                                    <input class="form-control @if($errors->has('web_url')) is-invalid @endif" type="text" name="web_url" placeholder="Website URL" value="{{inputValue("web_url", $settings)}}">
                                </div>
                                @error("web_url")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Whatsapp number</label>
                                    <input class="form-control @if($errors->has('whats_app_number')) is-invalid @endif" type="text" name="whats_app_number" placeholder="07..." value="{{inputValue("whats_app_number", $settings)}}">
                                </div>
                                @error("whats_app_number")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Default Whatsapp Message</label>
                                    <textarea class="form-control @if($errors->has('whats_app_message')) is-invalid @endif" type="text" name="whats_app_message" placeholder="Message ...">{{inputValue("whats_app_message", $settings)}}</textarea>
                                </div>
                                @error("whats_app_message")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                        

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Facebook URL</label>
                                    <input class="form-control @if($errors->has('facebook_url')) is-invalid @endif" type="text" name="facebook_url" placeholder="https//facebook.com/..." value="{{inputValue("facebook_url", $settings)}}">
                                </div>
                                @error("facebook_url")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Instagram URL</label>
                                    <input class="form-control @if($errors->has('instagram_url')) is-invalid @endif" type="text" name="instagram_url" placeholder="" value="{{inputValue("instagram_url", $settings)}}">
                                </div>
                                @error("instagram_url")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Google Play URL</label>
                                    <input class="form-control @if($errors->has('google_play_url')) is-invalid @endif" type="text" name="google_play_url" placeholder="" value="{{inputValue("google_play_url", $settings)}}">
                                </div>
                                @error("google_play_url")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">App Store URL</label>
                                    <input class="form-control @if($errors->has('app_store_url')) is-invalid @endif" type="text" name="app_store_url" placeholder="" value="{{inputValue("app_store_url", $settings)}}">
                                </div>
                                @error("app_store_url")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div> 
                            
                            
                             <div class="col-lg-6">
                                    
                                <div class="form-group">
                                    <label class="control-label">Minimum order</label>
                                    <input class="form-control @if($errors->has('minimum_order')) is-invalid @endif" type="text" name="minimum_order" placeholder="" value="{{inputValue("minimum_order", $settings)}}">
                                </div>
                                @error("minimum_order")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                                
                            </div> 
                            
                            
                                                 
              
                            
                            
                        </div>
                        <hr>
                 

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

{{-- <div class="col-lg-6">
    <div class="form-group">
        <label class="control-label"></label>
        <input class="form-control @if($errors->has('')) is-invalid @endif" type="text" name="" placeholder="" value="{{inputValue("")}}">
    </div>
    @error("")
    <div class="input-error">{{$message}}</div>
    @enderror
</div> --}}

@endsection
