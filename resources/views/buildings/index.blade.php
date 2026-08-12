<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">إدارة المباني والقاعات</h2>
            <div class="flex gap-3">
                <!-- زر إضافة قاعة جديدة عام -->
                <a href="{{ route('classrooms.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    + إضافة قاعة
                </a>
                <!-- زر إضافة مبنى جديد -->
                <a href="{{ route('buildings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    + إضافة مبنى
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-600 text-sm">

                        <th class="p-4">#</th>

                        <th class="p-4">اسم المبنى</th>
                        <th class="p-4">القاعات التابعة</th>
                        <th class="p-4 text-center">الإجراءات</th>
                          <th class="p-4">ahmad</th>

                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($buildings as $building)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold text-gray-700">{{ $loop->iteration }}</td>
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $building->name }}
                                <span class="text-xs text-gray-400 block font-normal">({{ $building->code }})</span>
                            </td>

                            <!-- عرض أسماء القاعات -->
                            <td class="p-4">
                                @if($building->classrooms->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($building->classrooms as $classroom)
                                            <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-blue-200">
                                                {{ $classroom->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm italic">لا يوجد قاعات</span>
                                @endif
                            </td>

                            <!-- أزرار الإجراءات لكل مبنى -->
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- زر إضافة قاعة مخصصة لهذا المبنى -->
                                    <a href="{{ route('classrooms.create', ['building_id' => $building->id]) }}"
                                       class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold py-1.5 px-3 rounded-md border border-emerald-300 transition duration-150 flex items-center gap-1">
                                        ➕ إضافة قاعة
                                    </a>

                                    <a href="{{ route('buildings.edit', $building->id) }}" class="text-blue-600 hover:underline text-sm font-semibold">تعديل</a>

                                    <form action="{{ route('buildings.edit', $building->id) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-semibold">حذف</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                alsa
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">لا يوجد مباني حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
