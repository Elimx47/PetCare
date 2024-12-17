<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Order Details #{{ $order->id }}</h1>

                        <!-- Success & Error Messages -->
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Order Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="mb-3">Customer Information</h4>
                                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Order Information</h4>
                                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
                                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                                <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                            </div>
                        </div>

                        <!-- Status Update Form -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">Update Order Status</h4>
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="d-flex align-items-center">
                                        <select name="status" class="form-control me-2" style="max-width: 200px;">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h4 class="mb-3">Order Items</h4>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Medication</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            {{ $item->medication_name }}
                                            @if($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->medication_name }}"
                                                style="max-width: 50px; max-height: 50px; margin-left: 10px;">
                                            @endif
                                        </td>
                                        <td>{{ $item->medication_type }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Php {{ number_format($item->price, 2) }}</td>
                                        <td>Php {{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="4" class="text-end"><strong>Total Order Amount:</strong></td>
                                        <td><strong>Php {{ number_format($order->total_amount, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>