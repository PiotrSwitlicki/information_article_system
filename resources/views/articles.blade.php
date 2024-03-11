
@extends('layouts.app')

@section('title', 'All Articles')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Wszystkie artykuły</h1>
<!--            <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Create Article</a> -->
            @foreach($articles as $article)
              
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                        <h3>Authors:</h3>
                        <ul>
                            @foreach ($article->authors as $author)
                                <li>{{ $author->first_name }} {{ $author->last_name }} <br> <div style="font-size: 12"> Author ID: {{ $author->id }} </div></li>
                            @endforeach
                        </ul>
                        <p class="card-text">Created at: {{ $article->created_at }}</p>
                        <p style="font-size: 12" class="card-text">Article ID: {{ $article->id }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Read More</a>
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning">Edit</a>
                    </div>
            
            @endforeach
        </div>
    </div>
@endsection