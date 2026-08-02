<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dir-rtl">
            {{ __('القاعات المتاحة للطلب') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- رسائل الخطأ والنجاح --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->has('time'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errors->first('time') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- قائمة القاعات --}}
                @forelse($halls as $hall)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-xl font-bold mb-2">{{ $hall->name }}</h3>
                            <p class="text-gray-600 mb-1">🏛️ **المبنى:** {{ $hall->building }}</p>
                            <p class="text-gray-600 mb-1">👥 **السعة:** {{ $hall->capacity }} شخص</p>

                            <div class="mt-3">
                                <span class="font-semibold text-sm">التجهيزات:</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @if($hall->amenities)
                                        @foreach($hall->amenities as $amenity)
                                            <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded border border-blue-200">
                                                {{ $amenity }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- نموذج حجز هذه القاعة --}}
                            <hr class="my-4">
                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="hall_id" value="{{ $hall->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">تاريخ الحجز</label>
                                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">من الساعة</label>
                                        <input type="time" name="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">إلى الساعة</label>
                                        <input type="time" name="end_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">الغرض من الحجز</label>
                                    <textarea name="purpose" rows="2" required placeholder="مثال: محاضرة تعويضية، ورشة عمل..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                </div>

                                <x-primary-button class="w-full justify-center">
                                    {{ __('تقديم طلب الحجز') }}
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded-lg text-center text-gray-500">
                        لا توجد قاعات متاحة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
