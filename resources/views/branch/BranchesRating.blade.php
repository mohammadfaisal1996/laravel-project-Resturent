@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard "></i> Branches Rating</h1><br>
                        @if(isset($branchs[0]->id))  
            <a class="btn btn-primary" href="{{route("branchRating.create",[$branchs[0]->id])}}">Add new Rating</a>
            @endif
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
 
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
                                            
                            @if(isset($branchs[0]->branch_name))                
                             <span class="h3 mb-4">Branch Name :{{$branchs[0]->branch_name}}</span>
                            @endif
                    <table class="mt-5 table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                
                                <th>branch rating type</th>
                                 <th>Rating </th>
                       
                             
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($branchs) > 0)    
                        @foreach($branchs as $branch)
                            <tr>
                                <td>{{$branch->RatingTitel}}      </td>

                                
                                <td>
                                
                                        @php $rating = $branch->AvgRating; @endphp  
                                        
                                                @foreach(range(1,5) as $i)
                                                <span class="fa-stack" style="width:1em">
                                                <i class="far fa-star fa-stack-1x"></i>
                                                
                                                @if($rating >0)
                                                    @if($rating >0.5)
                                                        <i class="fas fa-star fa-stack-1x"></i>
                                                    @else
                                                        <i class="fas fa-star-half fa-stack-1x"></i>
                                                    @endif
                                                @endif
                                                @php $rating--; @endphp
                                        </span>
                                        @endforeach
            
            
                               </td>
            

                            </tr>
                        @endforeach
                        @else
                        <tr>
                                <td colspan=2>
                                    Empty Data
                                </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("scripts")


    <script type="text/javascript">$('#sampleTable').DataTable();</script>

@endsection
