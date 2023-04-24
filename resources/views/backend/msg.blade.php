@if($errors->any())
    <div class="alert alert-danger mg-b-0 my-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
        <li>{{$error}}</li>
                @endforeach
        </ul>
    </div>
@endif
