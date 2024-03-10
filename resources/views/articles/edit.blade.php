@extends('layouts.app')

@section('title', 'Edit Article')

@section('content')
    <div class="card-body">
        <h1>Edytuj artykuł</h1>
        <form method="POST" action="{{ route('articles.update', $article->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Tytuł:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}">
            </div>
            <div class="form-group">
                <label for="content">Treść:</label>
                <textarea class="form-control" id="content" name="content">{{ $article->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
@endsection