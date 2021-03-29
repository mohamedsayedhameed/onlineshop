@if(Session::has('success'))
    <div class="row mr-2 ml-2">
        <button class="btn btn-lg btn-block btn-outline-success"
                id ="type-error" type="text">{{Session::get('success')}}</button>
    </div>
@endif