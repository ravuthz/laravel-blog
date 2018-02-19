@if(Session::has('success'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif