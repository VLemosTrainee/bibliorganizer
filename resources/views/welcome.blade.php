<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Título da sua aplicação --}}
        <title>Book Organizer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center min-h-screen antialiased">
        
        <div class="w-full max-w-4xl p-6 lg:p-8">
            <main class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl flex flex-col lg:flex-row overflow-hidden">
                
                {{-- Lado Esquerdo: Apresentação --}}
                <div class="p-8 lg:p-12 flex-1">
                    <img src="{{ asset('images/logoCompletoBookOrganizer.svg') }}" 
                        alt="Logo Book Organizer" 
                        class="h-20 w-auto"
                    >
                                        
                    <h1 class="mt-8 text-3xl font-bold text-gray-900 dark:text-white">
                        Sua biblioteca, organizada.
                    </h1>

                    <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                        Bem-vindo ao <strong>Book Organizer</strong>, a ferramenta definitiva para gerenciar sua biblioteca. Adicione livros, autores, editoras e tenha controle total do seu acervo de forma simples e intuitiva.
                    </p>

                    {{-- Caixa de Ação com Botões --}}
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Pronto para começar?</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Acesse sua conta ou crie uma agora mesmo.</p>
                        
                        {{-- BOTÕES DE LOGIN E REGISTRO --}}
                        <div class="mt-4 flex flex-col sm:flex-row gap-4">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-primary flex-1">
                                    Entrar
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary flex-1">
                                    Criar Conta
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Lado Direito: Imagem Ilustrativa --}}
                <div class="hidden lg:flex flex-1 bg-primary/5 dark:bg-primary/10 p-12 items-center justify-center">
                    {{-- Ícone grande e simples representando uma biblioteca --}}
                    <svg class="w-2/3 h-auto text-primary opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                </div>
            </main>

            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
    </body>
</html>