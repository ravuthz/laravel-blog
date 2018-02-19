<div class="row">
    <div class="col-md-6">
        {!! BootForm::text('name') !!}
    </div>
    <div class="col-md-6">
        {!! BootForm::text('guard_name') !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-center">
        {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
    </div>
</div>