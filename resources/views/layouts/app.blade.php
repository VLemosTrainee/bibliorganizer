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
                {{-- 
                ================================================================
                CORREÇÃO DO LAYOUT
                ================================================================
                - Adicionada a div com padding para garantir margens em mobile.
                --}}
                <div class="py-12">
    <div class="max-w-7xl mx-auto pl-4 pr-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</div>

            </main>
        </div>

        @stack('modals')

        @livewireScripts

        {{-- 
        ================================================================
        BLOCO DE SCRIPT ÚNICO E CONSOLIDADO
        ================================================================
        --}}
        <script>
            // Função global para confirmação, fora do event listener para garantir que está sempre disponível.
            function confirmarGuardar() {
                if (confirm("Tem a certeza que deseja guardar as alterações?")) {
                    Livewire.dispatch('call-save');
                }
            }

            document.addEventListener('livewire:initialized', () => {

                
                
                // Ouvinte para fechar qualquer modal
                Livewire.on('close-modal', (modalId) => {
                    const modal = document.getElementById(modalId);
                    if (modal) { modal.close(); }
                });

                // Ouvinte para abrir qualquer modal
                Livewire.on('open-modal', (modalId) => {
                    const modal = document.getElementById(modalId);
                    if(modal) { modal.showModal(); }
                });

                // Ouvinte para a exportação de LIVROS
                Livewire.on('exportar-livros', (event) => {
                    if (event.ids.length === 0) { alert('Nenhum livro para exportar.'); return; }
                    const idsQuery = event.ids.join(',');
                    const url = `{{ route('livros.export') }}?ids=${idsQuery}`;
                    window.location.href = url;
                });

                // Ouvinte para a exportação de AUTORES
                Livewire.on('exportar-autores', (event) => {
                    if (event.ids.length === 0) { alert('Nenhum autor para exportar.'); return; }
                    const idsQuery = event.ids.join(',');
                    const url = `{{ route('autores.export') }}?ids=${idsQuery}`;
                    window.location.href = url;
                });

                // Ouvinte para a exportação de EDITORAS
                Livewire.on('exportar-editoras', (event) => {
                    if (event.ids.length === 0) { alert('Nenhuma editora para exportar.'); return; }
                    const idsQuery = event.ids.join(',');
                    const url = `{{ route('editoras.export') }}?ids=${idsQuery}`;
                    window.location.href = url;
                });

                // Ouvinte para quando um LIVRO é guardado com sucesso
                Livewire.on('livro-salvo-com-sucesso', (event) => {
                    document.getElementById('add_livro_modal').close();
                    alert(event.mensagem);
                });

                // Ouvinte para mostrar ERRO AO APAGAR (ex: editora com livros)
                Livewire.on('erro-apagar', (mensagem) => {
                    alert(mensagem);
                });

            });
        </script>
        
    </body>
</html>