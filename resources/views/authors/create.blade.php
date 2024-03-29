@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="carda">
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('authors.store') }}">
                            @csrf

                            <div class="form-group">
                                <div class="carda-header"><h1>Dodaj nowego autora</h1></div>
                                <br>
                                @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <label for="first_name">Imię:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name">
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">Nazwisko:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name">
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Dodaj autora</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection