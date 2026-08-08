<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- عنوان الصفحة وزر الإضافة -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">سجل الحجوزات</h2>
            <a href="{{ route('reservations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                + حجز قاعة جديدة
            </a>
        </div>

        <!-- رسائل النجاح إن وجدت -->
        @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- جدول الحجوزات -->
        <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50 text-gray-700">
                        <th class="p-3">القاعة</th>
                        <th class="p-3">المستخدِم</th>
                        <th class="p-3">تاريخ الحجز</th>
                        <th class="p-3">وقت البداية</th>
                        <th class="p-3">وقت النهاية</th>
                        <th class="p-3">الغرض</th>
                        <th class="p-3 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 font-bold text-gray-900">{{ $reservation->classroom->room_number ?? '-' }}</td>
                            <td class="p-3 text-gray-700">{{ $reservation->user->name ?? '-' }}</td>

                            <!-- تعديل اسم الحق إلى date بدلاً من reservation_date -->
                            <td class="p-3 text-gray-700 font-semibold">{{ $reservation->date }}</td>

                            <td class="p-3 text-green-600 font-bold">{{ $reservation->start_time }}</td>
                            <td class="p-3 text-red-600 font-bold">{{ $reservation->end_time }}</td>

                            <!-- إضافة عرض الغرض من الحجز -->
                            <td class="p-3 text-gray-600 text-sm max-w-xs truncate" title="{{ $reservation->purpose }}">
                                {{ $reservation->purpose ?? '-' }}
                            </td>

                            <td class="p-3 text-center">
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('هل أنت تأكد من إلغاء الحجز؟')" class="text-red-600 hover:text-red-800 font-semibold">
                                        إلغاء الحجز
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500 font-medium">
                                لا توجد حجوزات مسجلة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
