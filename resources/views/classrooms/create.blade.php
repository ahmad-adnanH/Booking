<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">إضافة قاعة جديدة</h2>

        <!-- عرض أخطاء التحقق إن وجدت -->
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

        <form action="{{ url('/classrooms') }}" method="POST">
            @csrf

            <!-- المبنى -->
            <div class="mb-4">
                <label for="building_id" class="block text-gray-700 font-semibold mb-2">المبنى <span class="text-red-500">*</span></label>
                <select name="building_id" id="building_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- اختر المبنى --</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ (isset($selectedBuildingId) && $selectedBuildingId == $building->id) || old('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }} ({{ $building->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- رقم القاعة (Room Number) -->
            <div class="mb-4">
                <label for="room_number" class="block text-gray-700 font-semibold mb-2">رقم القاعة (Room Number) <span class="text-red-500">*</span></label>
                <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" required placeholder="مثال: 102 أو C-12"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- الطابق / الدور (Floor) -->
            <div class="mb-4">
                <label for="floor" class="block text-gray-700 font-semibold mb-2">الطابق / الدور <span class="text-red-500">*</span></label>
                <input type="number" name="floor" id="floor" value="{{ old('floor') }}" required placeholder="مثال: 1 (للطابق الأول)"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- سعة القاعة (Capacity) -->
            <div class="mb-4">
                <label for="capacity" class="block text-gray-700 font-semibold mb-2">سعة القاعة (عدد المقاعد) <span class="text-red-500">*</span></label>
                <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" required placeholder="مثال: 50"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- حالة القاعة (Status) -->
            <div class="mb-6">
                <label for="status" class="block text-gray-700 font-semibold mb-2">حالة القاعة <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متاحة (Available)</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>صيانة (Maintenance)</option>
                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>مشغولة (Occupied)</option>
                </select>
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow">
                    حفظ القاعة
                </button>
                <a href="{{ route('buildings.index') }}" class="text-gray-600 hover:underline text-sm font-semibold">إلغاء</a>
            </div>
        </form>
    </div>
</x-app-layout>
