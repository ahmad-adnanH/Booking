<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            حجز قاعة جديدة
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- إظهار رسائل الأخطاء إن وجدت -->
                @if ($errors->any())
                    <div class="bg-red-50 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                        <p class="font-bold mb-1">يرجى تصحيح الأخطاء التالية:</p>
                        <ul class="list-disc pr-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/reservations') }}" method="POST">
                    @csrf

                    <!-- اختيار القاعة -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">اختر القاعة <span class="text-red-500">*</span></label>
                        <select name="classroom_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                            <option value="">-- اختر قاعة --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                    قاعة {{ $classroom->room_number }} (المبنى: {{ $classroom->building->name ?? 'غير محدد' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

 <!-- تاريخ الحجز -->
<div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">تاريخ الحجز <span class="text-red-500">*</span></label>
    <input
        type="date"
        name="date"
        id="date"
        value="{{ old('date', date('Y-m-d')) }}"
        required
        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
    >
</div>

                    <!-- أوقات الحجز -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">وقت البداية <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">وقت النهاية <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- الغرض من الحجز (تمت إضافته هنا) -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">الغرض من الحجز / سبب الحجز <span class="text-red-500">*</span></label>
                        <textarea name="purpose" rows="3" required placeholder="أدخل سبب الحجز هنا (مثال: محاضرة برمجية، ورشة عمل)..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">{{ old('purpose') }}</textarea>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('reservations.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">إلغاء</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">تأكيد الحجز</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
