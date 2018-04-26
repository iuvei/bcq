@if(count($errors))
    <div class="row cl">
        <div class="Huialert Huialert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
    </div>
@endif


