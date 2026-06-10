@php $title = $title ?? null; @endphp

<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('partials.head')
    <title>{{ $title ? $title.' - '.config('app.name') : config('app.name') }}</title>
</head>
<body>
    @include('partials.header')

    <main style="padding:24px; max-width:1100px; margin: 24px auto;">
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    @include('partials.footer')
</body>
</html>
