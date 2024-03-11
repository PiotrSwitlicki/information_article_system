@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card1">
                    <div class="card-body">
                        <div class="carda-header">Dodaj artykuł</div><br>
                        <form method="POST" action="{{ route('articles.store') }}">
                            @csrf

                            <div class="form-group">
                                @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            
                                <label for="title">Tytuł:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            @error('title')    
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>                            
                            <div class="form-group">
                                <label for="content">Treść:</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
                            @error('content')  
                                <div class="text-danger">{{ $message }}</div>  
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="authors">Autorzy:</label>
                                <select class="form-control" id="authors" name="authors[]" multiple>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                    @endforeach
                                    <option value="new">Dodaj nowego autora</option>
                                </select>                            
                                @error('authors')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pola dla nowego autora -->
                            <div id="new-author-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="new_author_first_name">Imię nowego autora:</label>
                                    <input type="text" class="form-control" id="new_author_first_name" name="new_author_first_name">
                                </div>
                                <div class="form-group">
                                    <label for="new_author_last_name">Nazwisko nowego autora:</label>
                                    <input type="text" class="form-control" id="new_author_last_name" name="new_author_last_name">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Dodaj artykuł</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var select = document.getElementById('authors');

        //  event listener do zmiany w select'cie
        select.addEventListener('change', function () {
            var selectedOptions = Array.from(select.selectedOptions).map(option => option.value);
            if (selectedOptions.includes('new')) {
                // Jeśli wybrano "Dodaj nowego autora", pokażą się pola dla nowego autora
                document.getElementById('new-author-fields').style.display = 'block';
            } else {
                // Jeśli nie, schowają się pola dla nowego autora
                document.getElementById('new-author-fields').style.display = 'none';
            }
        });
    });
</script>