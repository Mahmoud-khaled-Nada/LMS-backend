<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $book->id }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $book->image }}</p>
</div>

<!-- Document Field -->
<div class="col-sm-12">
    {!! Form::label('document', 'Document:') !!}
    <p>{{ $book->document }}</p>
</div>

<!-- Prrice Field -->
<div class="col-sm-12">
    {!! Form::label('prrice', 'Prrice:') !!}
    <p>{{ $book->prrice }}</p>
</div>

<!-- Chapters Field -->
<div class="col-sm-12">
    {!! Form::label('chapters', 'Chapters:') !!}
    <p>{{ $book->chapters }}</p>
</div>

<!-- Publish Field -->
<div class="col-sm-12">
    {!! Form::label('publish', 'Publish:') !!}
    <p>{{ $book->publish }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $book->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $book->updated_at }}</p>
</div>

