@if(session('error'))
    <p class="alert alert-danger">
        {{ session('error') }}
    </p>
@endif

@if(session('message'))
    <p class="alert alert-success">
        {{ session('message') }}
    </p>
@endif
