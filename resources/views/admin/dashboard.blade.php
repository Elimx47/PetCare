<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pet Adoption Overview and Medication Inventory -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Overview Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Pet Adoption Overview</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-blue-600">{{$petCounts['totalPets']}}</p>
                                <p class="text-sm text-gray-600">Total Pets</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-green-600">{{$petCounts['adoptedPets']}}</p>
                                <p class="text-sm text-gray-600">Adopted Pets</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-semibold mb-2 text-gray-700">Pending Adoptions</h4>
                            <!-- Scrollable list container -->
                            <div class="max-h-32 overflow-y-auto">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($petsPending as $pet)
                                    <li class="py-2">
                                        {{ "{$pet->name} - {$pet->type} ({$pet->breed}), " . ($pet->age == 1 ? "{$pet->age} year old" : "{$pet->age} years old") }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medication Inventory Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Pet Medication Inventory</h3>
                        <!-- Three Columns Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-blue-600">6</p>
                                <p class="text-sm text-gray-600">Total Medications</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-yellow-600">3</p>
                                <p class="text-sm text-gray-600">Low Stock Items</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-red-600">1</p>
                                <p class="text-sm text-gray-600">Expiring Soon</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-md font-semibold mb-2 text-gray-700">Critical Stock</h4>
                            <ul class="divide-y divide-gray-200">
                                <li class="py-2 flex justify-between">
                                    <span>Amoxicillin</span>
                                    <span class="text-yellow-600">Low Stock</span>
                                </li>
                                <li class="py-2 flex justify-between">
                                    <span>Frontline Plus</span>
                                    <span class="text-yellow-600">Low Stock</span>
                                </li>
                                <li class="py-2 flex justify-between">
                                    <span>Prednisone</span>
                                    <span class="text-yellow-600">Low Stock</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Activities</h3>
                    <ul class="divide-y divide-gray-200">
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">Pet Adopted</p>
                                <p class="text-sm text-gray-600">Dabi - Toy Poodle, 1 year old</p>
                            </div>
                            <span class="text-sm text-gray-500">Recently</span>
                        </li>
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">Medication Low Stock</p>
                                <p class="text-sm text-gray-600">Frontline Plus - 20 vials remaining</p>
                            </div>
                            <span class="text-sm text-gray-500">Recently</span>
                        </li>
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">New Pet Added</p>
                                <p class="text-sm text-gray-600">Leo - Aspin, 6 years old</p>
                            </div>
                            <span class="text-sm text-gray-500">Recently</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>