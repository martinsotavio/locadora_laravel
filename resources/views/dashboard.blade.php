@php
    $title = __('Locadora de Carros');
@endphp

@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <div class="card">
            <div class="page-header">
                <h1 class="page-title">Locadora de Carros</h1>
            </div>
            <p class="muted">Use o painel abaixo para acessar rapidamente os cadastros de clientes e funcionários.</p>
        </div>

        <div style="height:12px"></div>

        <div class="grid">
            <div class="car-card">
                <h3 class="car-title">Clientes</h3>
                <p class="muted">Cadastro e listagem de clientes.</p>
                <div style="margin-top:12px;display:flex;gap:8px;">
                    <a href="{{ route('clientes.criar') }}" class="btn">Cadastro de Cliente</a>
                    <a href="{{ route('clientes.listar') }}" class="btn secondary">Listar Clientes</a>
                </div>
            </div>

            <div class="car-card">
                <h3 class="car-title">Funcionários</h3>
                <p class="muted">Cadastro e listagem de funcionários.</p>
                <div style="margin-top:12px;display:flex;gap:8px;">
                    <a href="{{ route('funcionarios.criar') }}" class="btn">Cadastro de Funcionário</a>
                    <a href="{{ route('funcionarios.listar') }}" class="btn secondary">Listar Funcionários</a>
                </div>
            </div>

            <div class="car-card">
                <h3 class="car-title">Locações</h3>
                <p class="muted">Cadastro e listagem de locações.</p>
                <div style="margin-top:12px;display:flex;gap:8px;">
                    <a href="{{ route('locacoes.criar') }}" class="btn">Cadastro de Locação</a>
                    <a href="{{ route('locacoes.listar') }}" class="btn secondary">Listar Locações</a>
                </div>
            </div>

            <div class="car-card">
                <h3 class="car-title">Carros</h3>
                <p class="muted">Cadastro e listagem de veículos disponíveis.</p>
                <div style="margin-top:12px;display:flex;gap:8px;">
                    <a href="{{ route('carros.criar') }}" class="btn">Cadastro de Carro</a>
                    <a href="{{ route('carros.listar') }}" class="btn secondary">Listar Carros</a>
                </div>
            </div>
        </div>
    </div>
@endsection
