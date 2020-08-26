@if (count($errors))
    <div class="m-b-15 m-l-15 m-r-15 alert alert-fadeOut alert-danger alert-dismissible">
        <button class="close noOutlineX" data-dismiss="alert" aria-hidden="true">x</button>
        <strong>Whoops!</strong> Ada beberapa masalah dengan masukan anda.
        {{ Session::get('message') }}
        <ul>
            @foreach($errors->all() as $error)
                <strong>
                    <li>{{ $error }}</li>
                </strong>
            @endforeach
        </ul>
    </div>
@endif