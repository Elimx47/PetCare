<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pet Adoption Overview and Orders -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Overview Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Pet Adoption Overview</h3>
                            <!-- Clickable Link -->
                            <a href="{{ route('pet-manage') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                View All Pets
                            </a>
                        </div>
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
                            <div class="max-h-48 overflow-y-auto">
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

                <!-- Orders Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Order Overview</h3>
                            <!-- Clickable Link -->
                            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                View All Orders
                            </a>
                        </div>
                        <!-- Three Columns Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $orderCounts['total'] }}</p>
                                <p class="text-sm text-gray-600">Total Orders</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $orderCounts['delivered'] }}</p>
                                <p class="text-sm text-gray-600">Delivered</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg text-center">
                                <p class="text-3xl font-bold text-red-600">{{ $orderCounts['pending'] }}</p>
                                <p class="text-sm text-gray-600">Pending</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-md font-semibold mb-2 text-gray-700">Recent Orders</h4>
                            <div class="max-h-48 overflow-y-auto">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($recentOrders as $order)
                                    <li class="py-2 flex justify-between">
                                        <span>Order #{{ $order->id }} - {{$order->user->name}}</span>
                                        <span class="text-{{ 
                                        $order->status === 'completed' ? 'green' : 
                                        ($order->status === 'pending' ? 'yellow' : 'red') 
                                    }}-600">{{ $order->status }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>