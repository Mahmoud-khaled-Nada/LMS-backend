<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $offer->id }}</p>
</div>

<!-- Course Id Field -->
<div class="col-sm-12">
    {!! Form::label('course_id', 'Course Id:') !!}
    <p>{{ $offer->course_id }}</p>
</div>

<!-- Expire Date Field -->
<div class="col-sm-12">
    {!! Form::label('expire_date', 'Expire Date:') !!}
    <p>{{ $offer->expire_date }}</p>
</div>

<!-- New Price Field -->
<div class="col-sm-12">
    {!! Form::label('new_price', 'New Price:') !!}
    <p>{{ $offer->new_price }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $offer->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $offer->updated_at }}</p>
</div>

