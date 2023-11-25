<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavAltMarkup">
            <div>
                <div class="navbar-nav">
                    <a class="nav-link active" href="{{ route('jobOffer.index') }}">Job offers</a>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                @guest
                    <div class="navbar-nav">
                        <a class="nav-link active" href="{{ route('auth.loginForm') }}">Log in</a>
                    </div>
                    <div class="navbar-nav">
                        <a class="nav-link active" href="{{ route('auth.registerForm') }}">Register</a>
                    </div>
                @endguest
                @auth
                    <div class="navbar-nav">
                        <a class="nav-link active" href="{{ route('auth.edit') }}">{{ Auth::user()->name }} </a>
                    </div>
                    <div class="navbar-nav">
                        <form action="{{ route('auth.logout') }}" method="POST" name="logoutForm">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="nav-link active" href="{{ route('auth.logout') }}">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
