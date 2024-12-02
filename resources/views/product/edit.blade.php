<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <div>
                            <x-input-label for="stock" :value="__('Stock')" />
                            <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" :value="old('stock', $product->stock)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $product->address)" />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $product->city)" />
                            <x-input-error class="mt-2" :messages="$errors->get('city')" />
                        </div>

                        <div>
                            <x-input-label for="region" :value="__('Region')" />
                            <x-text-input id="region" name="region" type="text" class="mt-1 block w-full" :value="old('region', $product->region)" />
                            <x-input-error class="mt-2" :messages="$errors->get('region')" />
                        </div>

                        <div>
                            <x-input-label for="postal-code" :value="__('Postal Code')" />
                            <x-text-input id="postal-code" name="postal-code" type="text" class="mt-1 block w-full" :value="old('postal-code', $product->postal_code)" />
                            <x-input-error class="mt-2" :messages="$errors->get('postal-code')" />
                        </div>

                        <div>
                            <x-input-label for="date-info" :value="__('Date Info')" />
                            <x-text-input id="date-info" name="date-info" type="date" class="mt-1 block w-full" :value="old('date-info', $product->date_info)" />
                            <x-input-error class="mt-2" :messages="$errors->get('date-info')" />
                        </div>

                        <div>
                            <x-input-label for="grade" :value="__('Grade')" />
                            <select id="grade" name="grade" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Grade</option>
                                <option value="Grade A" {{ old('grade', $product->grade) === 'Grade A' ? 'selected' : '' }}>Grade A</option>
                                <option value="Grade B" {{ old('grade', $product->grade) === 'Grade B' ? 'selected' : '' }}>Grade B</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                        </div>

                        <div>
                            <x-input-label for="file-upload" :value="__('Product Image')" />
                            <input id="file-upload" name="file-upload" type="file" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('file-upload')" />
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
                                </div>
                            @endif
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $product->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $product->longitude) }}">

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
