@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card1">
                    <div class="card-body">
                        <div class="card-header">Dodaj nowego autora</div><br>
                        <form method="POST" action="{{ route('authors.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="first_name">Imię:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Nazwisko:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name">
                            </div>

                            <button type="submit" class="btn btn-primary">Dodaj autora</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection