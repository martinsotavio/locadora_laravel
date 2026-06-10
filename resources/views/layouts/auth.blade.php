@php $title = $title ?? null; @endphp

<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('partials.head')
    <title>{{ $title ? $title.' - '.config('app.name') : config('app.name') }}</title>
</head>
<body>
    <div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#f8fafc,#eef2ff);padding:32px;">
        <div style="width:100%;max-width:420px;">
            <div class="card">
                {{ $slot ?? view()->yieldContent('content') }}
            </div>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>
