<div class="flex justify-between items-center px-6 py-4">

    <h1 class="text-xl font-semibold text-gray-700">
        Panel del Sistema
    </h1>

    <div class="flex items-center space-x-4">

        <span class="text-gray-600 font-medium">
            {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Salir
            </button>
        </form>

    </div>

</div>
