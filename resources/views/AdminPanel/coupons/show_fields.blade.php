<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $coupon->id }}</p>
</div>

<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $coupon->code }}</p>
</div>

<!-- Number Of Use Field -->
<div class="col-sm-12">
    {!! Form::label('number_of_use', 'Number Of Use:') !!}
    <p>{{ $coupon->number_of_use }}</p>
</div>

<!-- Remaining Field -->
<div class="col-sm-12">
    {!! Form::label('remaining', 'Remaining:') !!}
    <p>{{ $coupon->remaining }}</p>
</div>

<!-- Value Field -->
<div class="col-sm-12">
    {!! Form::label('value', 'Value:') !!}
    <p>{{ $coupon->value }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $coupon->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $coupon->updated_at }}</p>
</div>

