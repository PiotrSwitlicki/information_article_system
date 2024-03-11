<style>
.card-body {
  transform:
    perspective(750px)
    translate3d(-10px, -10px, -10px)
    rotateX(7deg)
    scale(0.9, 0.9);
  border-radius: 10px;
  border: 3px solid #e6e6e6;
  box-shadow: 0 70px 40px -20px rgba(0, 0, 0, 0.2);
  background: white;
  transition: 0.4s ease-in-out transform;

  &:hover {
    transform: translate3d(0px, 0px, -250px);
  }
}
.container1 {
  transform:
    perspective(750px)
    translate3d(-3px, -3px, -3px)
    rotateX(7deg)
    scale(0.9, 0.9);
  border-radius: 20px;
  border: 0px solid #e6e6e6;
  box-shadow: 0 7px 4px -2px rgba(0, 0, 0, 0.2);
  transition: 0.4s ease-in-out transform;

  &:hover {
    transform: translate3d(0px, 0px, -250px);
  }
}

@keyframes move-it {
  0% {
    background-position: initial;
  }
  100% {
    background-position: 100px 0px;
  }
}

body {  
  background: repeating-linear-gradient(
  45deg,
  #ffffff,
  #fff2cc 25%,
  #464 15%,
  #100 10%
);
  background-size: 100px 100px;
  animation: move-it 5s linear infinite;
}

</style>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Additional CSS styles can be included here -->
</head>
<body>
    <div class="content">
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container1">
                <a class="navbar-brand" href="{{ route('articles.index') }}">Information Article System</a>
                <!-- Navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('articles.index') }}">Wszystkie artykuły</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('articles.create') }}">Dodaj artykuł</a>
                    </li>
                    <!-- Add more navbar links as needed -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('authors.create') }}">Dodaj nowego autora</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main role="main" class="main">
        <!-- Main content -->
        <div class="container-mt-4">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light" style="opacity: 0.6">
        <div class="container">
            <span style="color: black;" class="text-muted">© 2024 Information Article System. All rights reserved.</span>
        </div>
    </footer>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>





