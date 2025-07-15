<div class="bg-[#D2ECD2] font-dana min-h-screen py-8 px-4">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header with Search and Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-xl font-bold text-gray-800">مدیریت مقاصد</h2>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <input 
                        wire:model.debounce.300ms="search"
                        type="text" 
                        placeholder="جستجوی مقاصد..."
                        class="w-full pr-10 pl-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition"
                    >
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <button 
                    wire:click="openModal"
                    class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold flex items-center gap-2 transition-all transform hover:scale-105"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>مقصد جدید</span>
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="bg-[#A7D7A7] border border-[#75AC78] text-gray-800 px-4 py-3 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Destinations Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#E1F4E1]">
                        <tr>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                                نام مقصد
                                @if($sortField === 'name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    @endif
                                @endif
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">شهر</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">استان</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">امتیاز</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($destinations as $destination)
                        <tr class="hover:bg-[#E1F4E1] transition-all">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($destination->image_url)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ $destination->image_url }}" alt="{{ $destination->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-bold text-gray-800">{{ $destination->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $destination->address }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $destination->city }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $destination->province }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-[#EC9F48]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="mr-1">{{ $destination->rating }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($destination->is_featured)
                                    <span class="px-3 py-1 text-xs rounded-full bg-[#A7D7A7] text-gray-800">ویژه</span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">عادی</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="openModal({{ $destination->id }})" class="text-[#75AC78] hover:text-[#6C9E6E] transition">ویرایش</button>
                                <button wire:click="deleteDestination({{ $destination->id }})" class="text-red-600 hover:text-red-900 mr-4 transition" onclick="return confirm('آیا از حذف این مقصد اطمینان دارید؟')">حذف</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-600">هیچ مقصدی یافت نشد</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $destinations->links() }}
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500/75 transition-opacity duration-300">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full transform transition-all duration-300">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">{{ $modalTitle }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">نام مقصد *</label>
                                    <input wire:model="name" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">توضیحات *</label>
                                    <textarea wire:model="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition"></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">شهر *</label>
                                        <input wire:model="city" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="province" class="block text-sm font-medium text-gray-700">استان *</label>
                                        <input wire:model="province" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        @error('province') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">آدرس</label>
                                    <input wire:model="address" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="best_time_to_visit" class="block text-sm font-medium text-gray-700">بهترین زمان بازدید</label>
                                    <input wire:model="best_time_to_visit" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                    @error('best_time_to_visit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">امتیاز (۱-۵)</label>
                                    <select wire:model="rating" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition">
                                        <option value="1">1 ★</option>
                                        <option value="2">2 ★★</option>
                                        <option value="3">3 ★★★</option>
                                        <option value="4" selected>4 ★★★★</option>
                                        <option value="5">5 ★★★★★</option>
                                    </select>
                                    @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center">
                                    <input wire:model="is_featured" type="checkbox" id="is_featured" class="h-4 w-4 text-[#75AC78] focus:ring-[#A7D7A7] border-gray-300 rounded">
                                    <label for="is_featured" class="mr-2 text-sm text-gray-700">مقصد ویژه</label>
                                    @error('is_featured') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">تصویر مقصد</label>
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
                            <button wire:click="saveDestination" type="button" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
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