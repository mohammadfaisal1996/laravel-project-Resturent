
@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> track Categories status</h1>
            <p>create new category</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route("check_category_status.index")}}">track list</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ul>
    </div>
@endsection
@section("content")


    
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New track Category</h3>
                

                                        
                         @if ($errors->any())
                           @foreach ($errors->all() as $error)
                    
                            
                            <div class="alert alert-danger" >{{$error}}</div>
                        
                        
                            @endforeach
                        @endif
                        
                        
                        
              
                                
                <div class="tile-body">
                    <form method="post" action="{{route("check_category_status.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                         
             
                                <div class="col-md-12">
                                    <div class="tile">
                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered" id="sampleTable">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Category Image</th>
                                                        <th>English Category name</th>
                                                        <th>Arabic Category name</th>
                                                        <th>From time</th>
                                                        <th>To time</th>
                                                        <th>converting status to </th>
                                                     
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($categories as $category)
                                                        <tr>
                                                            <td><input type="checkBox" name="trackID[]" value="{{$category->id}}"></td>
                                                            <td><img src="{{$category->category_image_url}}" alt="" style="width: 90px"></td>
                                                            <td>{{$category->category_name_en}}</td>
                                                            <td>{{$category->category_name_ar}}</td>
                                                            <td><input type="text" name="FromTime[{{$category->id}}]" class="form-control bs-timepicker" ></td>
                                                            <td><input type="text" name="ToTime[{{$category->id}}]" class="form-control bs-timepicker"></td>
                                                            
                                                            
                                                    

                                                            
                                                            <td>
                                                                <select name="Status[{{$category->id}}]"class="form-control"> 
                                                                <option value=1>Active</option>
                                                                <option value=2>InActive</option>
                                                                </select>
                                                            </td>
                                                 
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                
                       
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset("assets/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("assets/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    
       <script type="text/javascript">$('#sampleTable').DataTable();</script>

    <!-- Google analytics script-->
    <script>
    
      $(function () {
        $('.bs-timepicker').timepicker();
      });
      

    </script>
    
@endsection

