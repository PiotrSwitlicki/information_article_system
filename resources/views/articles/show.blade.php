@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="container">
        <div class="card1">
            <div class="card-body">
                <h1>{{ $article->title }}</h1>
                <p>{{ $article->content }}</p>
                @foreach ($article->authors as $author)
                    <p>Author: {{ $author->first_name }} {{ $author->last_name }}</p>
                @endforeach
                <p>Created at: {{ $article->created_at }}</p>
            </div>
        </div>
    </div>
@endsection
