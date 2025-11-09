<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flask text-white"></i>
                </div>
                <span class="text-xl font-bold text-gray-800 uppercase">Silab</span>
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="{{ route('student.dashboard') }}"
                   class="font-medium transition 
                          {{ request()->routeIs('student.dashboard') 
                             ? 'text-blue-600 border-b-2 border-blue-600' 
                             : 'text-gray-700 hover:text-blue-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('student.peminjaman') }}" 
                   class="font-medium text-gray-700 hover:text-blue-600 transition">
                    Peminjaman
                </a>
                <a href="{{ route('student.alat.index') }}"
                   class="font-medium transition 
                          {{ request()->routeIs('student.alat.*') 
                             ? 'text-blue-600 border-b-2 border-blue-600' 
                             : 'text-gray-700 hover:text-blue-600' }}">
                    Alat
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    @if(Auth::user()->isStudent())
                        <a href="{{ route('student.profile.edit') }}" class="text-gray-700 font-medium hover:text-blue-600 transition" title="Kelola Pengguna">{{ Auth::user()->name }}</a>
                    @else
                        <a href="{{ route('student.peminjaman.index') }}" class="text-gray-700 font-medium hover:text-blue-600 transition" title="Profil">{{ Auth::user()->name }}</a>
                    @endif
                </div>
                <span class="text-gray-300">|</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-gray-500 hover:text-red-600 transition"
                        title="Logout">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
