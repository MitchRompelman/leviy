<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Leviy Home</title>
        <link href="{{ asset('css/leviy.css') }}" rel="stylesheet">
    </head>
    <body>

        <nav class="nav-top">
            <figure class="logo">
                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.svg') }}"></a>
            </figure>
            <div class="main-nav">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                @endif
            </div>
        </nav>

        <main class="welcome-main">
            <div class="welcome-center">
                <h1>Het Platform voor Schoonmaak en Facility Management</h1>
                Wij geloven in en faciliteren een betere wereld waar mensen en technologie met elkaar zijn verbonden. Een app en online dashboard voor specialisten in schoonmaak en facility management. Een wereld van perfecte synergie!
                <div class="btn-row">
                    <a href="https://leviy.com/ons-product/?lang=nl" class="btn full">Over ons product</a>
                    <a href="https://leviy.com/ons-geloof/?lang=nl" class="btn full">Waar we in geloven</a>
                </div>
            </div>
        </main>

    </body>
</html>
