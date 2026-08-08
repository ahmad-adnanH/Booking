<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة التحكم الرئيسية
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- كارت المباني -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-r-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-medium">إدارة المباني</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">المباني الكلية</p>
                    <a href="{{ route('buildings.index') }}" class="mt-4 inline-block text-blue-600 hover:underline text-sm font-semibold">عرض كافة المباني &larr;</a>
                </div>

                <!-- كارت القاعات -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-r-4 border-green-500">
                    <h3 class="text-gray-500 text-sm font-medium">إدارة القاعات</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">القاعات الدراسية</p>
                    <a href="{{ route('classrooms.index') }}" class="mt-4 inline-block text-green-600 hover:underline text-sm font-semibold">عرض القاعات &larr;</a>
                </div>

                <!-- كارت الحجوزات -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-r-4 border-purple-500">
                    <h3 class="text-gray-500 text-sm font-medium">حجز القاعات</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">سجل الحجوزات</p>
                    <a href="{{ route('reservations.index') }}" class="mt-4 inline-block text-purple-600 hover:underline text-sm font-semibold">عرض الحجوزات &larr;</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
