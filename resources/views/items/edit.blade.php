@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Items</h1>
            <p>edit item</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("items.index")}}">Items</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
            <li class="breadcrumb-item"><a href="#">{{$item->item_name_en}} ({{$item->item_name_ar}})</a></li>

        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New Item</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("items.update",$item->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">English Item Name</label>
                                    <input class="form-control @if($errors->has('item_name_en')) is-invalid @endif" type="text" name="item_name_en" placeholder="Enter English Item name" value="{{inputValue("item_name_en",$item)}}">
                                </div>
                                @error("item_name_en")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Arabic Item Name</label>
                                    <input class="form-control @if($errors->has('item_name_ar')) is-invalid @endif" type="text" name="item_name_ar" placeholder="Enter Arabic Item name" value="{{inputValue("item_name_ar",$item)}}">
                                </div>
                                @error("item_name_ar")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">Category</label>
                                    <select class="form-control" id="exampleSelect1" name="category_id">
                                        <option value="">None</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{selected("category_id", $category->id, $item)}}>{{$category->category_name_en}} ( {{$category->category_name_ar}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error("category_id")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Item Price</label>
                                    <input class="form-control @if($errors->has('item_name_en')) is-invalid @endif" type="text" name="item_price" placeholder="Enter Item Price" value="{{inputValue("item_price",$item)}}">
                                </div>
                                @error("item_price")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Arabic Item Description</label>
                                    <textarea class="form-control @if($errors->has('item_description_ar')) is-invalid @endif" type="text" name="item_description_ar" style="height: 120px" placeholder="Enter Arabic Description">{{inputValue("item_description_ar",$item)}}</textarea>
                                </div>
                                @error("item_description_ar")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">English Item Description</label>
                                    <textarea class="form-control @if($errors->has('item_description_en')) is-invalid @endif" type="text" name="item_description_en" style="height: 120px" placeholder="Enter English Description" >{{inputValue("item_description_en",$item)}}</textarea>
                                </div>
                                @error("item_description_en")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Item Photo</label>
                                    <div>
                                        <button class="btn btn-primary form-control button-upload-file" >
                                            <input class="input-file" type="file" name="item_image"  accept="image/x-png,image/gif,image/jpeg">
                                            <span class="upload-file-content">
                                                <i class="fas fa-upload fa-lg upload-file-content-icon left"></i>
                                                <span class="upload-file-content-text">Upload Photo</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                @error("item_image")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label">Item Status</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input type="checkbox" name="item_status" {{checked("item_status", 1, $item)}}  ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                    </label>
                                </div>
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
