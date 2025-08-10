<nav class="flex justify-between items-center p-6">
    <div class="flex items-center space-x-2">
        <img src="img/logo.png" alt="Logo Oanes Pools" class="h-16 w-20" />
        <span class="text-blue-700 font-bold text-2xl italic">Oanes Pools</span>
    </div>
    @auth
    <a href="{{route('dashboard')}}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
    Dashboard
    </a>
    @endauth
    <a href="#"
        class="font-semibold bg-blue-700 text-white px-5 py-3 rounded-full text-sm hover:bg-blue-800">Hubungi Kami</a>
</nav>
