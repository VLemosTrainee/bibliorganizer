<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 p-4">
        
        {{-- O card principal que imita o estilo da página de boas-vindas --}}
<div class="flex items-stretch w-full max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden min-h-[44rem]">            
            <!-- Coluna Esquerda: Formulário de Registro -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12">
                {{-- Logotipo completo --}}
                <a href="/">
                    <img src="{{ asset('images/logoCompletoBookOrganizer.svg') }}" 
                         alt="Logo Book Organizer" 
                         class="h-[4.5rem] w-auto mb-8"
                    >
                </a>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Crie a sua conta</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Junte-se a nós e comece a organizar sua biblioteca hoje.</p>

                {{-- Erros de Validação --}}
                <x-validation-errors class="mb-4 mt-4" />

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-4">
                    @csrf

                    <!-- Campo Nome -->
                    <div>
                        <x-label for="name" value="Nome" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <!-- Campo Email -->
                    <div>
                        <x-label for="email" value="Email" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <!-- Campo Palavra-passe -->
                    <div>
                        <x-label for="password" value="Palavra-passe" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <!-- Campo Confirmar Palavra-passe -->
                    <div>
                        <x-label for="password_confirmation" value="Confirmar Palavra-passe" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    {{-- Termos de Serviço e Política de Privacidade --}}
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="pt-2">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2 text-sm">
                                        {!! __('Eu concordo com os :terms_of_service e a :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-gray-600 hover:text-gray-900 dark:text-gray-400">'.__('Termos de Serviço').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-gray-600 hover:text-gray-900 dark:text-gray-400">'.__('Política de Privacidade').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <!-- Botão de Registrar -->
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary w-full text-base">
                            Registrar
                        </button>
                    </div>
                    
                    <!-- Link para Login -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Já tem uma conta? 
                            <a href="{{ route('login') }}" class="underline font-semibold text-primary hover:text-primary-focus">
                                Faça login aqui.
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Coluna Direita: Imagem Ilustrativa (só aparece em telas grandes) -->
            <div class="hidden lg:flex w-1/2 items-center justify-center bg-primary/5 dark:bg-primary/20 p-12">
                <svg class="w-2/3 h-auto text-primary opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>

        </div>
    </div>
</x-guest-layout>