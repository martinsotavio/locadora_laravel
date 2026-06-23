<header class="loca-header">
    <div class="loca-brand">
        <div class="loca-logo">LA</div>
        <div>
            <div class="loca-title">Loca.Ai</div>
            <div class="loca-sub">Sistema de Locadora</div>
        </div>
    </div>

    <button class="nav-toggle" aria-label="Abrir menu" style="background:transparent;border:none;color:#fff;font-size:14px;padding:6px 8px;">Menu</button>

    <nav class="loca-nav">
        <a href="{{ route('dashboard') }}">Início</a>
        <a href="{{ route('clientes.listar') }}">Clientes</a>
        <a href="{{ route('funcionarios.listar') }}">Funcionários</a>
        <a href="{{ route('locacoes.listar') }}">Locações</a>
        <a href="{{ route('carros.listar') }}">Carros</a>
    </nav>

    <div class="user-menu">
        <button
            type="button"
            class="btn ghost theme-toggle"
            title="Alternar tema claro/escuro"
            aria-label="Alternar tema claro/escuro"
            onclick="window.Flux.applyAppearance(document.documentElement.classList.contains('dark') ? 'light' : 'dark')"
        ><span class="theme-icon-light">🌙</span><span class="theme-icon-dark">☀️</span></button>

        @auth
            <span class="user-name">{{ auth()->user()->name ?? auth()->user()->email }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn ghost" style="padding:6px 10px;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            @endif
        @endauth
    </div>
</header>
