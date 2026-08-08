<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">إضافة مبنى جديد</h2>

        <!-- استخدام url('/buildings') هنا يمنع أي تداخل مع الـ API نهائياً -->
        <form action="{{ url('/buildings') }}" method="POST">
            @csrf

            <!-- اسم المبنى -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">اسم المبنى:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- رمز المبنى -->
            <div class="mb-6">
                <label for="code" class="block text-gray-700 font-semibold mb-2">رمز المبنى (Code):</label>
                <input type="text" name="code" id="code" value="{{ old('code') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    حفظ المبنى
                </button>
                <a href="{{ route('buildings.index') }}" class="text-gray-600 hover:underline">إلغاء</a>
            </div>
        </form>
    </div>
</x-app-layout>
