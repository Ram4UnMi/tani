<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <!-- Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif --}}
                @if ($errors->any())
                    <div
                        class="alert alert-error bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg mx-2 mt-2">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4">
                        <div class="">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 p-2 sm:grid-cols-8">
                                <div class="sm:col-span-4 mx-2">
                                    <label for="name" class="block text-sm/6 font-medium text-gray-900">
                                        Name Product</label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="product-input" required
                                            value="{{ old('name') }}" autocomplete="given-name"
                                            class=" w-full block rounded-md border-0 py-1.5 pr-20 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="price" class="mx-2 block text-sm/6 font-medium text-gray-900">
                                        Price</label>
                                    <div class="relative mt-2">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp.</span>
                                        </div>
                                        <input type="text" name="price" id="price-input" required
                                            value="{{ old('price') }}"
                                            class="x-2 mx-2 w-3/5 sm:w-full block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="stock" class="mx-2 block text-sm/6 font-medium text-gray-900">
                                        Stock</label>
                                    <div class="mt-2 mx-2">
                                        <input type="number" name="stock" id="stock-input"
                                            class="w-full block rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>
                                <div class="sm:col-span-full mx-2">
                                    <label for="description"
                                        class="block text-sm/6 font-medium text-gray-900">Description</label>
                                    <div class="mt-2">
                                        <textarea id="description-input" name="description" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"></textarea>
                                    </div>
                                    <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about yourself.</p>
                                </div>
                                <div class="col-span-full mx-2">
                                    <label for="address" class="block text-sm/6 font-medium text-gray-900">Street
                                        address</label>
                                    <div class="mt-2">
                                        <input type="text" name="address" id="address-input" autocomplete="address"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"
                                            placeholder="Masukkan alamat">
                                    </div>
                                    
                                    <!-- Hidden fields for coordinates -->
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">

                                    <!-- Map container -->
                                    <div id="map" class="w-full h-96 rounded-lg mt-4"></div>
                                </div>
                                <div class="sm:col-span-3 sm:col-start-1 mx-2">
                                    <label for="city" class="block text-sm/6 font-medium text-gray-900">City</label>
                                    <div class="mt-2">
                                        <input type="text" name="city" id="city-input"
                                            autocomplete="address-level2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="region" class="block text-sm/6 font-medium text-gray-900">State /
                                        Province</label>
                                    <div class="mt-2">
                                        <input type="text" name="region" id="region-input"
                                            autocomplete="address-level1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>
                                <div class="sm:col-span-2 mx-2">
                                    <label for="postal-code" class="block text-sm/6 font-medium text-gray-900">ZIP /
                                        Postal code</label>
                                    <div class="mt-2">
                                        <input type="text" name="postal-code" id="postal-code-input"
                                            autocomplete="postal-code"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>

                                <div class="sm:col-span-full mx-2">
                                    <label for="date-info" class="block text-sm/6 font-medium text-gray-900">
                                        Date</label>
                                    <div class="mt-2">
                                        <input type="date" name="date-info" id="date-info" autocomplete="postal-code"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2 mx-2">
                                    <fieldset>
                                        <legend class="text-sm/6 font-semibold text-gray-900">Grade</legend>
                                        <p class="mt-1 text-sm/6 text-gray-600">Grade Product desc</p>
                                        <div class="mt-6 space-y-6">
                                            <div class="flex items-center gap-x-3">
                                                <input id="grade-a" name="grade" type="radio" value="Grade A"
                                                    class="size-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <label for="grade-a"
                                                    class="block text-sm/6 font-medium text-gray-900">Grade A
                                                    (premium)</label>
                                            </div>
                                            <div class="flex items-center gap-x-3">
                                                <input id="grade-b" name="grade" type="radio" value="Grade B"
                                                    class="size-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <label for="grade-b"
                                                    class="block text-sm/6 font-medium text-gray-900">Grade B
                                                    (standard)</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-span-full mx-2 ">
                                    <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover
                                        photo</label>
                                    <div
                                        class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                        <div class="text-center">
                                            <!-- Preview Image -->
                                            <img id="preview-image" src="#" alt="Preview" class="mx-auto mb-4 hidden max-h-48 object-cover">
                                            <svg id="upload-icon" class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24"
                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd"
                                                    d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <div class="mt-4 flex text-sm/6 text-gray-600">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" accept="image/*" onchange="previewImage(this);">
                                                    <!-- <input id="file-upload" name="file-upload" type="file" 
                                                        class="sr-only"> -->
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-x-6 p-4">
                        <button type="reset" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                    <script>
                        function previewImage(input) {
                            const preview = document.getElementById('preview-image');
                            const icon = document.getElementById('upload-icon');
                            
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.classList.remove('hidden');
                                    icon.classList.add('hidden');
                                }
                                
                                reader.readAsDataURL(input.files[0]);
                            } else {
                                preview.src = '#';
                                preview.classList.add('hidden');
                                icon.classList.remove('hidden');
                            }
                        }

                        // Initialize Leaflet map
                        let map;
                        let marker;
                        const defaultLocation = [-6.200000, 106.816666]; // Jakarta coordinates

                        function initMap() {
                            // Initialize map
                            map = L.map('map').setView(defaultLocation, 13);

                            // Add OpenStreetMap tiles
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            // Add marker
                            marker = L.marker(defaultLocation, {
                                draggable: true
                            }).addTo(map);

                            // Add geocoder control
                            const geocoder = L.Control.geocoder({
                                defaultMarkGeocode: false
                            })
                            .on('markgeocode', function(e) {
                                const bbox = e.geocode.bbox;
                                const poly = L.polygon([
                                    bbox.getSouthEast(),
                                    bbox.getNorthEast(),
                                    bbox.getNorthWest(),
                                    bbox.getSouthWest()
                                ]);
                                map.fitBounds(poly.getBounds());
                                
                                const center = e.geocode.center;
                                marker.setLatLng(center);
                                updateFields(center);
                                
                                // Update address input
                                document.getElementById('address-input').value = e.geocode.name;
                            })
                            .addTo(map);

                            // Update fields when marker is dragged
                            marker.on('dragend', function(e) {
                                const position = marker.getLatLng();
                                updateFields(position);
                                
                                // Reverse geocode
                                geocoder.options.geocoder.reverse(position, map.options.crs.scale(map.getZoom()), function(results) {
                                    if (results.length > 0) {
                                        document.getElementById('address-input').value = results[0].name;
                                        
                                        // Try to extract and update city, region, postal code
                                        if (results[0].properties) {
                                            const props = results[0].properties;
                                            if (props.city) document.getElementById('city-input').value = props.city;
                                            if (props.state) document.getElementById('region-input').value = props.state;
                                            if (props.postcode) document.getElementById('postal-code-input').value = props.postcode;
                                        }
                                    }
                                });
                            });

                            // Click on map to move marker
                            map.on('click', function(e) {
                                marker.setLatLng(e.latlng);
                                updateFields(e.latlng);
                                
                                // Reverse geocode
                                geocoder.options.geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
                                    if (results.length > 0) {
                                        document.getElementById('address-input').value = results[0].name;
                                        
                                        // Try to extract and update city, region, postal code
                                        if (results[0].properties) {
                                            const props = results[0].properties;
                                            if (props.city) document.getElementById('city-input').value = props.city;
                                            if (props.state) document.getElementById('region-input').value = props.state;
                                            if (props.postcode) document.getElementById('postal-code-input').value = props.postcode;
                                        }
                                    }
                                });
                            });

                            // Search when address input changes
                            document.getElementById('address-input').addEventListener('change', function(e) {
                                geocoder.options.geocoder.geocode(e.target.value, function(results) {
                                    if (results.length > 0) {
                                        const result = results[0];
                                        const center = result.center;
                                        map.setView(center, 16);
                                        marker.setLatLng(center);
                                        updateFields(center);
                                        
                                        // Try to extract and update city, region, postal code
                                        if (result.properties) {
                                            const props = result.properties;
                                            if (props.city) document.getElementById('city-input').value = props.city;
                                            if (props.state) document.getElementById('region-input').value = props.state;
                                            if (props.postcode) document.getElementById('postal-code-input').value = props.postcode;
                                        }
                                    }
                                });
                            });
                        }

                        // Helper function to update latitude/longitude fields
                        function updateFields(latlng) {
                            document.getElementById('latitude').value = latlng.lat;
                            document.getElementById('longitude').value = latlng.lng;
                        }

                        // Initialize map when page loads
                        document.addEventListener('DOMContentLoaded', initMap);
                    </script>
                </form>
                

            </div>
        </div>
    </div>
</x-app-layout>
