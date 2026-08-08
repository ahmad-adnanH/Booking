<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'نظام حجز القاعات الجامعية' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-blue-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">

            <!-- الجزء الأيمن: العنوان والروابط -->
            <div class="flex items-center space-x-6 space-x-reverse">
                <h1 class="text-xl font-bold">🏫 نظام حجز القاعات الجامعية</h1>
                <nav class="flex space-x-4 space-x-reverse">
                    <a href="{{ route('dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded-md font-medium">الرئيسية</a>
                    <a href="{{ url('/buildings') }}" class="hover:bg-blue-700 px-3 py-2 rounded-md font-medium">المباني والقاعات</a>
                    <a href="{{ route('reservations.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded-md font-medium">حجوزاتي</a>
                </nav>
            </div>

            <!-- الجزء الأيسر: اسم المستخدم + تسجيل الخروج أو الدخول -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- اسم المستخدم وشارة الأدمن -->
                    <span class="text-sm font-semibold text-blue-100">
                        مرحباً، {{ auth()->user()->name }}
                        @if(auth()->user()->is_admin)
                            <span class="bg-amber-500 text-white text-xs px-2 py-0.5 rounded-full mr-1 font-bold">Admin</span>
                        @endif
                    </span>

                    <!-- زر تسجيل الخروج -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-1.5 px-3 rounded-lg transition duration-200 flex items-center gap-1">
                            🚪 تسجيل الخروج
                        </button>
                    </form>
                @else
                    <!-- رابط تسجيل الدخول إذا كان زائر -->
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-1.5 px-4 rounded-lg transition duration-200">
                        تسجيل الدخول
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- Main Content Wrapper -->
    <main class="container mx-auto px-6 py-8 flex-grow">
        <!-- Messages/Alerts -->
        @if(session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Dynamic Content Slot -->
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto py-4 text-center text-gray-600 text-sm">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} - نظام حجز القاعات الجامعية
    </footer>

</body>
</html>
