<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Homepage") }}
                    <br>
                    <button class="botoncito">soy un button de tailwind</button>
                </div>
            </div>
        </div>
        <div class="p-6 max-w-md mx-auto bg-white rounded-lg shadow-lg text-center">

        <livewire:saludo />
            <br>
        <livewire:contador />
            <br>
            {{--alpine.js--}}
            <div x-data="{ open: false }">
                <button class="botoncito" @click="open = !open">Expand</button>
                <br>
                <span x-show="open">
                Content...
            </span>
            </div>
        </div>
    </div>
</x-app-layout>
