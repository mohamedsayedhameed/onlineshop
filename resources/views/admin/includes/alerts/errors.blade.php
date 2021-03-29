@if(Session::has('error'))
    <div class="row mr-2 ml-2">
        <button class="btn btn-lg btn-block btn-outline-danger"
                id ="type-error" type="text">{{Session::get('error')}}</button>
    </div>
@endif