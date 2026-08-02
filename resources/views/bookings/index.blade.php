<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dir-rtl">
            {{ __('سجل حجوزاتي') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50 text-gray-700">
                            <th class="p-3">القاعة</th>
                            <th class="p-3">التاريخ</th>
                            <th class="p-3">التوقيت</th>
                            <th class="p-3">الغرض</th>
                            <th class="p-3">الحالة</th>
                            <th class="p-3">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-semibold">{{ $booking->hall->name }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                                <td class="p-3">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $booking->purpose }}</td>
                                <td class="p-3">
                                    @if($booking->status === 'approved')
                                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded font-bold">مقبول</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-0.5 rounded font-bold">قيد الانتظار</span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs px-2.5 py-0.5 rounded font-bold">مرفوض</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded">ملغي</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إلغاء هذا الطلب؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">إلغاء الطلب</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-gray-500">لا يوجد لديك أي حجوزات حتى الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
