<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
        
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-100">Clientes</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Gerencie os clientes.</p>
                </div>
                
                <div style="margin-top: 15px;">
                    <a href="{{ route('clientes.criar') }}" style="display: block; background-color: #2563eb; color: #ffffff; padding: 10px; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px; margin-bottom: 8px;">
                         Cadastrar Novo Cliente
                    </a>

                    <a href="{{ route('clientes.listar') }}" style="display: block; background-color: #10b981; color: #ffffff; padding: 10px; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px;">
                         Listar Clientes Cadastrados
                    </a>
                </div>
            </div>

            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>