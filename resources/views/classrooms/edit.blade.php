<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">تعديل بيانات القاعة</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('classrooms.update', $classroom) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">المبنى</label>
                        <select name="building_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ $classroom->building_id == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">رقم / اسم القاعة</label>
                        <input type="text" name="room_number" value="{{ old('room_number', $classroom->room_number) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        @error('room_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">السعة الاستيعابية</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $classroom->capacity) }}" min="1" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        @error('capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('classrooms.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">إلغاء</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
