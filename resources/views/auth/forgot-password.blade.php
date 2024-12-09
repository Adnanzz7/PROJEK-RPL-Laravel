<x-guest-layout>
    <div class="flex justify-center items-center bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500">
        <div class="w-full max-w-m rounded-lg p-6 transform transition duration-500 hover:scale-105">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800">Forgot Password?</h2>
                <p class="text-sm text-gray-500">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-green-600 text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        placeholder="Enter your email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Back to login') }}
                    </a>
                    <x-primary-button class="ms-4 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        {{ __('Send Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Background gradient effect */
        body {
            background: linear-gradient(135deg, #4c6ef5, #3b82f6, #9333ea);
        }
        
        /* Button hover effect */
        .primary-btn:hover {
            background-color: #4c6ef5;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Input focused and error states */
        .input-error {
            border-color: #f87171;
        }

        .input-error:focus {
            border-color: #f87171;
            box-shadow: 0 0 0 2px rgba(248, 113, 113, 0.5);
        }
    </style>
</x-guest-layout>
