<div class="bg-[#D2ECD2] font-dana min-h-screen py-8 px-4">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header with Filters -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-xl font-bold text-gray-800">مدیریت رویدادها</h2>
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <div class="flex gap-3">
                    <select wire:model="statusFilter" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="upcoming">آینده</option>
                        <option value="ongoing">در حال برگزاری</option>
                        <option value="completed">تکمیل شده</option>
                    </select>
                    <button 
                        wire:click="openModal"
                        class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold flex items-center gap-2 transition-all transform hover:scale-105"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>رویداد جدید</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="bg-[#A7D7A7] border border-[#75AC78] text-gray-800 px-4 py-3 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Events Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#E1F4E1]">
                        <tr>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">عنوان رویداد</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">مقصد</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">تاریخ شروع</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">تاریخ پایان</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($events as $event)
                        <tr class="hover:bg-[#E1F4E1] transition-all">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($event->image_url)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ $event->image_url }}" alt="{{ $event->title }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-bold text-gray-800">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-600">{{ $event->organizer }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $event->destination->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $event->start_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $event->end_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    @if($event->status === 'ongoing') bg-[#A7D7A7] text-gray-800
                                    @elseif($event->status === 'upcoming') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $event->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="openModal({{ $event->id }})" class="text-[#75AC78] hover:text-[#6C9E6E] transition">ویرایش</button>
                                <button wire:click="deleteEvent({{ $event->id }})" class="text-red-600 hover:text-red-900 mr-4 transition" onclick="return confirm('آیا از حذف این رویداد اطمینان دارید؟')">حذف</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-600">هیچ رویدادی یافت نشد</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500/75 transition-opacity duration-300">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full transform transition-all duration-300">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">{{ $modalTitle }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">عنوان رویداد *</label>
                                    <input wire:model="title" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">توضیحات *</label>
                                    <textarea wire:model="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition"></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="destination_id" class="block text-sm font-medium text-gray-700">مقصد *</label>
                                    <select wire:model="destination_id" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        <option value="">انتخاب مقصد</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('destination_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">تاریخ شروع *</label>
                                        <input wire:model="start_date" type="date" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">تاریخ پایان *</label>
                                        <input wire:model="end_date" type="date" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="capacity" class="block text-sm font-medium text-gray-700">ظرفیت *</label>
                                        <input wire:model="capacity" type="number" min="1" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700">قیمت (تومان)</label>
                                        <input wire:model="price" type="number" min="0" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">آدرس</label>
                                    <input wire:model="address" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="organizer" class="block text-sm font-medium text-gray-700">برگزار کننده</label>
                                    <input wire:model="organizer" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('organizer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="contact_info" class="block text-sm font-medium text-gray-700">اطلاعات تماس</label>
                                    <input wire:model="contact_info" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('contact_info') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">وضعیت</label>
                                    <select wire:model="status" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        <option value="upcoming">آینده</option>
                                        <option value="ongoing">در حال برگزاری</option>
                                        <option value="completed">تکمیل شده</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">تصویر رویداد</label>
                                    <input wire:model="image" type="file" class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#A7D7A7] file:text-gray-800 hover:file:bg-[#75AC78] transition">
                                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    @if($imageUrl)
                                        <div class="mt-3">
                                            <img src="{{ $imageUrl }}" class="h-48 w-full object-contain rounded-lg border">
                                            <button wire:click="removeImage" type="button" class="mt-2 text-red-600 hover:text-red-900 text-sm transition">حذف تصویر</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                            <button wire:click="saveEvent" type="button" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                                ذخیره
                            </button>
                            <button wire:click="$set('showModal', false)" type="button" class="bg-white border border-gray-300 text-gray-700 px-5 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all transform hover:scale-105">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>