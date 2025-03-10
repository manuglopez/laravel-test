<div class="p-6 max-w-md mx-auto bg-white rounded-lg shadow-lg text-center">
    <h1 class="text-xl font-medium text-black">Contador</h1>
    <div class="text-3xl font-bold p-4 rounded"
         style="background-color: {{ $contador >= 10 ? 'red' : 'green' }}; color: white;">
        {{ $contador }}
    </div>
    <div class="mt-4 space-x-4">
        <button wire:click="incrementar"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
                @if($contador >= 10) disabled @endif>
            +
        </button>

        <button wire:click="decrementar"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">
            -
        </button>
    </div>
</div>
