<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $contact->id }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $contact->phone }}</p>
</div>

<!-- Facebook Field -->
<div class="col-sm-12">
    {!! Form::label('facebook', 'Facebook:') !!}
    <p>{{ $contact->facebook }}</p>
</div>

<!-- Linkedin Field -->
<div class="col-sm-12">
    {!! Form::label('linkedin', 'Linkedin:') !!}
    <p>{{ $contact->linkedin }}</p>
</div>

<!-- X Field -->
<div class="col-sm-12">
    {!! Form::label('x', 'X:') !!}
    <p>{{ $contact->x }}</p>
</div>

<!-- Instgram Field -->
<div class="col-sm-12">
    {!! Form::label('instgram', 'Instgram:') !!}
    <p>{{ $contact->instgram }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $contact->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $contact->updated_at }}</p>
</div>

