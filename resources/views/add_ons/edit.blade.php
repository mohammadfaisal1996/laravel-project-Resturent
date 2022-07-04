@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add On Category</h1>
            <p>edit add on category</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Items</a></li>
            <li class="breadcrumb-item"><a href="#">{{$item->item_name_en}} ( {{$item->item_name_ar}} )</a></li>
            <li class="breadcrumb-item"><a href="#">Add Ons</a></li>
            <li class="breadcrumb-item"><a href="#">{{$addOn->add_ons_name_en}} ( {{$addOn->add_ons_name_ar}} )</a></li>
            <li class="breadcrumb-item"><a href="#">edit</a></li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <form method="post" action="{{route("items.add_ons.update",[$item->id,$addOn->id])}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="tile">
                    <h3 class="tile-title">Edit Add On Category</h3>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">English Name</label>
                                    <input class="form-control @if($errors->has('add_ons_name_en')) is-invalid @endif" type="text" name="add_ons_name_en" placeholder="Enter English name" value="{{inputValue("add_ons_name_en",$addOn)}}">
                                </div>
                                @error("add_ons_name_en")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Arabic Name</label>
                                    <input class="form-control @if($errors->has('add_ons_name_ar')) is-invalid @endif" type="text" name="add_ons_name_ar" placeholder="Enter Arabic name" value="{{inputValue("add_ons_name_ar",$addOn)}}">
                                </div>
                                @error("add_ons_name_ar")
                                <div class="input-error">{{$message}}</div>
                                @enderror
                            </div>
  
                            <div class="col-lg-12  mb-4"><span class="ml-1 ">Enter min and max number of used option </span></div>
                            <div class="col-lg-2">
                                    <div class="form-group">
                                            <label class="control-label">Min Value</label>
                                            <input class="form-control @if($errors->has('add_ons_name_ar')) is-invalid @endif" type="text" name="min" placeholder="Enter min value" value="{{$addOn->min}}">
                                    </div>
                                    @error("min")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                            </div>
                            
                            
                            
                            
                            <div class="col-lg-2">
                                    <div class="form-group">
                                            <label class="control-label">Max Value</label>
                                            <input class="form-control @if($errors->has('add_ons_name_ar')) is-invalid @endif" type="text" name="max" placeholder="Enter max value" value="{{inputValue("max",$addOn)}}">
                                    </div>
                                    @error("max")
                                    <div class="input-error">{{$message}}</div>
                                    @enderror
                            </div>
                            
                            
                            
                        </div>

                    </div>
                </div>
                <div class="tile">
                    <h3 class="tile-title">Options</h3>
                    <div class="tile-body options-container">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>English name</th>
                                    <th>Arabic name</th>
                                    <th>Price</th>
                                    <th>Control</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($addOn->addOnsList as $option)
                                    <tr class="option-row">
                                        <td>{{$option->id}}</td>
                                        <td>{{$option->add_ons_list_en}}</td>
                                        <td>{{$option->add_ons_list_ar}}</td>
                                        <td>{{$option->price}}</td>
                                        <td>
                                                <a href="{{route("add_ons_option.Edit", [$option->id])}}" class=" btn  btn-success  edit"><i class="fas fa-edit"></i></a>
                                                <a href="{{route("add_ons_option.destroy", [$option->id])}}" class=" btn  btn-danger  edit"><i class=" far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(isset($options_selected))
                            @for($i=0; $i < $options_selected; $i++)
                            <div class="option-box">
                                <div class='text-right mt-3 mb-3'>
                                    <span class='btn btn-primary remove-option'>Remove</span>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">English Name</label>
                                            <input class="form-control @if($errors->has('add_ons_list_en.' . $i)) is-invalid @endif" type="text" name="add_ons_list_en[]" placeholder="Enter English name" value="{{isset(old("add_ons_list_en")[$i]) ? old("add_ons_list_en")[$i] : null}}">
                                        </div>
                                        @error("add_ons_list_en." . $i)
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Arabic Name</label>
                                            <input class="form-control @if($errors->has('add_ons_list_en.' . $i)) is-invalid @endif" type="text" name="add_ons_list_ar[]" placeholder="Enter Arabic name" value="{{isset(old("add_ons_list_ar")[$i]) ? old("add_ons_list_ar")[$i] : null}}">
                                        </div>
                                        @error("add_ons_list_ar." . $i)
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Adding Price</label>
                                            <input class="form-control @if($errors->has('price.' . $i)) is-invalid @endif" type="text" name="price[]" placeholder="Enter Price" value="{{isset(old("price")[$i]) ? old("price")[$i] : null}}">
                                        </div>
                                        @error("price." . $i)
                                        <div class="input-error">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <span class="btn btn-primary add-option"><i class="fas fa-plus"></i>  Add Option</span>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                    </div>
                </div>
            </form>
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

    <script type="text/javascript">
        $(".add-option").on("click",function(){
            let container = $(".options-container");
            let row = $("<div class='row'></div>");
            let box = $("<div class='option-box'></div>");


            let group1 = $("<div class='form-group'></div>");
            group1.append($("<label class='control-label'></label>").text("English name"));
            group1.append($('<input class="form-control" type="text" name="add_ons_list_en[]" placeholder="Enter English name"">'));
            row.append($("<div class='col-lg-6'></div>").append(group1));


            let group2 = $("<div class='form-group'></div>");
            group2.append($("<label class='control-label'></label>").text("Arabic name"));
            group2.append($('<input class="form-control" type="text" name="add_ons_list_ar[]" placeholder="Enter Arabic name"">'));
            row.append($("<div class='col-lg-6'></div>").append(group2));

            let group3 = $("<div class='form-group'></div>");
            group3.append($("<label class='control-label'></label>").text("Adding Price"));
            group3.append($('<input class="form-control" type="text" name="price[]" placeholder="Enter Adding Price"">'));
            row.append($("<div class='col-lg-6'></div>").append(group3));

            box.append($("<div class='text-right mt-3 mb-3'></div>").
            append($("<span class='btn btn-primary remove-option'>Remove</span>")));
            box.append(row);
            container.append(box.append(box));
            container.append($("hr"));
        });

        $(document).on("click",".remove-option",function (){
           $(this).parents(".option-box").remove();
        });

        $(document).on("click",".delete-option",function (){
           let optionId = $(this).data("option");
           let row = $(this).parents(".option-row");
            $.ajax({
                type: "POST",
                url:"https://goldenmealpro.digisolapps.com/golden_meal_backend/public/api/addOn/option/delete",
                data:{optionId: optionId}, // serializes the form's elements.
                success: function(response)
                {
                    if(response.status == 1){
                        row.remove();
                    }
                },
                error:function(){
                    console.error("you have error");
                }
            });
        });
    </script>

@endsection
