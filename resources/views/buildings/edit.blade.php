<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">تعديل بيانات المبنى</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('buildings.update', $building) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">اسم المبنى</label>
                        <input type="text" name="name" value="{{ old('name', $building->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('buildings.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">إلغاء</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
