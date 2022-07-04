@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard mb-4"></i>Control Category Status Table</h1>
            
          <a  class="btn btn-primary mt-3" href="{{Route('check_category_status.create')}}">Track Category Status </a>
    
            </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Categories</a></li>

        </ul>
    </div>
@endsection
@section("content")
    @include("layouts.main-parts.page-message")
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                        

                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Category Image</th>
                                <th>Category name</th>
                                <th>Start Time check </th>
                                <th>End Time check </th>

                                <th>converting status to</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td><img src="{{$category->category_image_url}}" alt="" style="width: 90px"></td>
                                    <td>{{$category->category_name_en}}</td>
                                    
                                    <td>{{$category->execute_time}}</td>
                                    <td>{{$category->end_execute_time}}</td>
                                    
                                    <td>{{$category->newStatus == 1 ? "Active" : "Non-Active"}}</td>
                                    <td>
                                        <form action="{{route("check_category_status.destroy", $category->id)}}" method="post" id="delete{{$category->id}}" style="display: none" data-swal-title="Delete Category" data-swal-text="Are Your Sure To Delete This Category ?" data-yes="Yes" data-no="No" data-success-msg="the category has been deleted succssfully">@csrf @method("delete")</form>
                                        <span href="#" class="control-link remove form-confirm" data-form-id="#delete{{$category->id}}"><i class="far fa-trash-alt"></i></span>
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

@endsection
@section("scripts")
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{asset("assets/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("assets/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <!-- Google analytics script-->
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
