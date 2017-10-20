@if(count($errors)>0)
    <div class="ibox-content">
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            @foreach($errors->all() as $error)
                <ul>{{$error}}</ul>
            @endforeach
        </div>
    </div>
@endif
@if(Session::has('success'))
    <div class="ibox-content">
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{Session::get('success')}}
        </div>
    </div>
@endif
@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{Session::get('warning')}}
    </div>
@endif