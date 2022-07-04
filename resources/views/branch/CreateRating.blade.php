@extends("layouts.dashboard.app")

@section("page-nav-title")
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Create Rating Branches</h1>
        
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class=" breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="tile">
                <h3 class="tile-title">Create New Rating</h3>
                <div class="tile-body">
                    <form method="post" action="{{route("branchRating.store")}}" >
                        @csrf
                       
                        <input type="hidden" value="{{$branch_id}}" name="branch_id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Rating Title Branch </label>
                                    <input class="form-control @if($errors->has('RatingTitel')) is-invalid @endif" type="text" name="RatingTitel" placeholder="enter Title Name" value="{{inputValue("RatingTitel")}}">
                                </div>
                                @error("RatingTitel")
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
