<x-layouts::app :title="__('Locadora de Carros')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="space-y-6">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Locadora de Carros</h1>
                <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Use o painel abaixo para acessar rapidamente os cadastros de clientes e funcionários.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Clientes</h2>
                    <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Cadastro e listagem de clientes.</p>
                    <div class="mt-6 flex flex-col gap-3">
                        <a href="{{ route('clientes.criar') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Cadastro de Cliente</a>
                        <a href="{{ route('clientes.listar') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Listar Clientes</a>
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Funcionários</h2>
                    <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Cadastro e listagem de funcionários.</p>
                    <div class="mt-6 flex flex-col gap-3">
                        <a href="{{ route('funcionarios.criar') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Cadastro de Funcionário</a>
                        <a href="{{ route('funcionarios.listar') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Listar Funcionários</a>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Locações</h2>
                    <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Cadastro e listagem de locações.</p>
                    <div class="mt-6 flex flex-col gap-3">
                        <a href="{{ route('locacoes.criar') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Cadastro de Locação</a>
                        <a href="{{ route('locacoes.listar') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Listar Locações</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
