@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Vendor table </h1>
            <p>Control and view all drivers</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">driver table</a></li>
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
                                <th>First name</th>
                      
                                <th>Phone number</th>
                                <td>User Type</td></td>
                            
                
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @foreach($users as $user)
                            <tr>

                                <td>{{$user->id}}</td>
                                <td>{{$user->firstName}}</td>
                                <td>{{$user->phone_number}}</td>
                                
                          <td>
                                <div class="toggle-flip change-type-user">
                                    <label>
                                        <select id="selectType"onchange="changeType(this,{{$user->id}})" data-userid="{{$user->id}}" class="form-control form-control-sm">
                                            @switch($user->Type)
                                            
                                               @case  ('driver'):
                                                 <option value="{{$user->Type}}">{{$user->Type}}</option>
                                                  <option value="user">user</option>
                                                  <option value="vendor">vendor</option>
                                                @break;
                                                @case ('user'):
                                                  <option value="{{$user->Type}}">{{$user->Type}}</option>
                                                  <option value="vendor">vendor</option>
                                                  <option value="driver">driver</option>
                                                @break;
                                                @case ('vendor') :
                                                  <option value="{{$user->Type}}">{{$user->Type}}</option>
                                                  <option value="user">user</option>
                                                  <option value="driver">driver</option>
                                                @break;
                                                
                                            @endswitch
                
                                        </select>
                                
                                
                                    </label>
                                </div>
                                </td>


                                <td>
                                    <form action="{{route("users.app.destroy", $user->id)}}" method="post" id="delete{{$user->id}}" style="display: none">@csrf @method("delete")</form>
                                    <span href="#" class="control-link remove" onclick='document.getElementById("delete{{$user->id}}").submit()'><i class="far fa-trash-alt"></i></span>
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



        <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">select branch </h5>
        
       
            </button>
          </div>
          <div class="modal-body">
              <form >
                  <div id="formDriver">
                         <select id="branch" class="form-control form-control-sm" >
                               <option value="empty">select one</option>
                             @foreach($Branchs as $branch)
                                <option value="{{$branch->id}}">{{$branch-> store_name_en}}</option>
                             @endforeach
                             
                         </select>
                 </div>
                 
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" onClick="work()" class="btn btn-primary" >Save</button>
            <button type="button" id="closeType"class="btn btn-secondary" data-dismiss="modal">Close</button>
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
     
     $("#closeType").click(function(){
               
               $("#selectType").val("vendor");
               
           });
              
          function changeType(select,id){
              
              
            let UserType =$(select).val();
            let userId =id;
            
            
                if(UserType == "driver" ){
                    $('#exampleModal2').modal('show');
                    $('#formDriver').append("<input type='hidden' id='userId' value="+userId+" >");
                     $('#formDriver').append("<input type='hidden' id='type'  value="+UserType+" >");
                    
                }else{
                    //user
                    
                    $.ajax({
                        type: "POST",
                        url:"/api/users/app/change_type",
                        data:{userType: UserType, userId: userId}, // serializes the form's elements.
                        success: function(response)
                        {
                        console.log(response);
                        if(response.status == 1){
                        location.reload();
                        
                        }
                        },
                        error:function(){
                        console.error("you have error");
                        }
                    });
                    
                }
            
   
          }
          
          function work(){
              
              
              let branch =$('#branch').val();
              let userId =$('#userId').val();
              let UserType=$("#type").val();
           
              
              
              
                  if( branch == "empty"){
                      $("#selectType").val("vendor");
                      $('#exampleModal2').modal('hide');
                  }else{
                      
                     
                    
                        $.ajax({
                            type: "POST",
                            url:"/api/users/app/change_type",
                            data:{userType: UserType, userId: userId,branch:branch}, // serializes the form's elements.
                            success: function(response)
                            {
                                console.log(response);
                                if(response.status == 1){
                                location.reload();
                                
                                }
                            },
                            error:function(){
                            console.error("you have error");
                            }
                        });
                        
                        
                        
                
                
                  }
              
              
              
              
              
          }
   
    </script>
   
@endsection
