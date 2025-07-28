<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        {{-- BLOCO DE SCRIPT ÚNICO E CONSOLIDADO --}}
        <script>
            function confirmarGuardar() {
                if (confirm("Tem a certeza que deseja guardar as alterações?")) {
                    Livewire.dispatch('call-save');
                }
            }

            document.addEventListener('livewire:initialized', () => {
                
                // OUVINTES GERAIS
                Livewire.on('close-modal', (modalId) => {
                    const modal = document.getElementById(modalId);
                    if (modal) { modal.close(); }
                });

                Livewire.on('open-modal', (modalId) => {
                    const modal = document.getElementById(modalId);
                    if(modal) { modal.showModal(); }
                });
                
                // OUVINTES DE EXPORTAÇÃO
                Livewire.on('exportar-livros', (event) => { /* ... */ });
                Livewire.on('exportar-autores', (event) => { /* ... */ });
                Livewire.on('exportar-editoras', (event) => { /* ... */ });

                // OUVINTES DE NOTIFICAÇÃO
                Livewire.on('livro-salvo-com-sucesso', (event) => {
                    document.getElementById('add_livro_modal').close();
                    alert(event.mensagem);
                });

                Livewire.on('erro-apagar', (mensagem) => {
                    alert(mensagem);
                });

                // ================================================================
                // OUVINTES  PARA O SISTEMA DE REQUISIÇÕES
                // ================================================================
                Livewire.on('erro', (mensagem) => {
                    alert('Erro: ' + mensagem);
                });

                Livewire.on('sucesso', (mensagem) => {
                    alert('Sucesso: ' + mensagem);
                });

            });
        </script>
        
    </body>
</html>