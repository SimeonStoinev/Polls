@if(Session::has($session_error))
    <span class="alert alert-danger" style="display: block;overflow: hidden;">  {{ Session::get($session_error) }}</span>
@endif
@if( $errors->has($name_error))
    <span class="alert alert-danger" style="display: block;overflow: hidden;"> {{ $errors->first($name_error)  }}</span>
@endif
