@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Items</h1>
            <p>create new item</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("sliders.index")}}">Sliders</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New Slider</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("sliders.update", $slider->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("put")

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Slider Photo</label>
                                    <div>
                                        <button class="btn btn-primary form-control button-upload-file" >
                                            <input class="input-file" type="file" name="Silder_image">
                                            <span class="upload-file-content">
                                                    <i class="fas fa-upload fa-lg upload-file-content-icon left"></i>
                                                    <span class="upload-file-content-text">Upload Photo</span>
                                                </span>
                                        </button>
                                    </div>
                                </div>
                                @error("Silder_image")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label">Status</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input type="checkbox" name="Status" {{ checked("Status", ['on',1], $slider)}}><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" >
                                <div class="form-group">
                                    <label for="">Navigate Type</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" name="type" class="custom-control-input navigateType" value="1" data-select="#categoires" {{checked("type", '1',$slider)}}>
                                        <label class="custom-control-label" for="customRadio1">Category</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" name="type" class="custom-control-input navigateType" value="2" data-select="#items" {{checked("type", '2',$slider)}}>
                                        <label class="custom-control-label" for="customRadio2">Item</label>
                                    </div>

                                </div>
                                @error("type")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 selects" id="categoires" style="@if($errors->has('category') || ($slider->type == 1  && !$errors->has('item'))) display:block @endif">
                                <div class="form-group">
                                    <label for="exampleSelect1" >Category</label>
                                    <select class="form-control @if($errors->has('category')) is-invalid @endif" id="NavigateList" name="category">
                                        <option value="">None</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{old('type') == 1 ? selected("navigate_id", $category->id) : ($slider-> type == 1 ? selected("navigate_id", $category->id, $slider) : null)}}>{{$category->category_name_en}} ( {{$category->category_name_ar}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error("category")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 selects" id="items" style="@if($errors->has('item') || ($slider->type == 2 && !$errors->has('category'))) display:block @endif">
                                <div class="form-group">
                                    <label for="exampleSelect1" >Items</label>
                                    <select class="form-control @if($errors->has('item')) is-invalid @endif" id="NavigateList" name="item">
                                        <option value="">None</option>
                                        @foreach($items as $item)
                                            <option value="{{$item->id}}" {{old('type') == 2 ? selected("navigate_id", $item->id) : ($slider-> type == 2 ? selected("navigate_id", $item->id, $slider) : null)}} >{{$item->item_name_en}} ( {{$item->item_name_ar}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error("item")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>
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
