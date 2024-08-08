<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $setting->id }}</p>
</div>

<!-- App Name Field -->
<div class="col-sm-12">
    {!! Form::label('app_name', 'App Name:') !!}
    <p>{{ $setting->app_name }}</p>
</div>

<!-- Logo Field -->
<div class="col-sm-12">
    {!! Form::label('logo', 'Logo:') !!}
    <p>{{ $setting->logo }}</p>
</div>

<!-- Footer Logo Field -->
<div class="col-sm-12">
    {!! Form::label('footer_logo', 'Footer Logo:') !!}
    <p>{{ $setting->footer_logo }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $setting->location }}</p>
</div>

<!-- Points Price Field -->
<div class="col-sm-12">
    {!! Form::label('points_price', 'Points Price:') !!}
    <p>{{ $setting->points_price }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $setting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $setting->updated_at }}</p>
</div>

