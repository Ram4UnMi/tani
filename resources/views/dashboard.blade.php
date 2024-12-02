<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Geocoder JavaScript -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        #modalMap {
            height: 400px;
            width: 100%;
            z-index: 1000;
            border-radius: 0.5rem;
        }
        .leaflet-container {
            z-index: 1000;
        }
        .search-input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }
    </style>
    <!-- Product List -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-lg shadow-md p-4 cursor-pointer hover:shadow-lg transition-shadow"
                                 onclick="showProductModal({{ json_encode($product) }})">
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="text-gray-600">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4">
            <div class="flex justify-between items-start mb-4">
                <h2 id="modalTitle" class="text-2xl font-bold"></h2>
                <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <img id="modalImage" class="w-full h-64 object-cover rounded-lg" src="" alt="">
                
                <div class="space-y-2">
                    <p class="text-xl font-semibold">Harga:</p>
                    <p id="modalPrice" class="text-gray-600"></p>
                </div>

                <div class="space-y-2">
                    <p class="text-xl font-semibold">Deskripsi:</p>
                    <p id="modalDescription" class="text-gray-600"></p>
                </div>

                <div class="space-y-2">
                    <p class="text-xl font-semibold">Lokasi:</p>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari lokasi..." readonly>
                    <p id="modalAddress" class="text-gray-600 mb-2"></p>
                    <div id="modalMap"></div>
                </div>

                @if (auth()->user()->role === 'owner')
                <div class="flex justify-end space-x-4 mt-4">
                    <a href="{{ route('product.edit', ['product' => ':id']) }}" id="editButton" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        let map = null;
        let marker = null;
        let geocoder = null;
        let currentProduct = null;

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Clean up map instance
            if (map) {
                map.remove();
                map = null;
            }
        }

        function showProductModal(product) {
            currentProduct = product;
            console.log('Product data:', product);
            
            // Update modal content
            document.getElementById('modalTitle').textContent = product.name;
            document.getElementById('modalImage').src = '/storage/images/' + product.image;
            document.getElementById('modalPrice').textContent = 'Rp. ' + new Intl.NumberFormat('id-ID').format(product.price);
            document.getElementById('modalDescription').textContent = product.description || '-';
            document.getElementById('modalAddress').textContent = product.address || '-';
            document.getElementById('searchInput').value = product.address || '';

            // Update edit link and delete form if user is owner
            if (document.getElementById('editButton')) {
                document.getElementById('editButton').href = document.getElementById('editButton').href.replace(':id', product.id);
                document.getElementById('deleteForm').action = `/product/${product.id}`;
            }

            // Show modal
            const modal = document.getElementById('productModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Initialize map
            setTimeout(() => {
                if (map) {
                    map.remove();
                    map = null;
                }

                try {
                    map = L.map('modalMap', {
                        center: [-6.200000, 106.816666],
                        zoom: 5
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: ' OpenStreetMap contributors'
                    }).addTo(map);

                    // Initialize geocoder
                    geocoder = L.Control.geocoder({
                        defaultMarkGeocode: false
                    }).addTo(map);

                    // If product has address or coordinates, show them
                    if (product.address) {
                        geocoder.geocode(product.address, function(results) {
                            if (results.length > 0) {
                                const result = results[0];
                                updateMapLocation(result.center.lat, result.center.lng, result.name);
                            } else if (product.latitude && product.longitude) {
                                updateMapLocation(parseFloat(product.latitude), parseFloat(product.longitude), product.address);
                            }
                        });
                    } else if (product.latitude && product.longitude) {
                        updateMapLocation(parseFloat(product.latitude), parseFloat(product.longitude), product.name);
                    }

                    console.log('Map initialized successfully');
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }, 300);
        }

        function updateMapLocation(lat, lng, address = '') {
            if (!map) return;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 13);

            if (address) {
                marker.bindPopup(address).openPopup();
            }
        }
    </script>
</x-app-layout>