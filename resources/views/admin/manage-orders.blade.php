<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Manage Orders</h1>

                        <!-- Search Bar -->
                        <div class="d-flex justify-content-end align-items-end mb-4">
                            <form action="{{ route('admin.orders.index') }}" method="GET" class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control form-control"
                                        placeholder="Search orders by ID, user name, email, or status..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Success & Error Messages -->
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Payment Method</th>
                                        <th class="text-center">Status</th>
                                        <th>Created at</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No orders found.</td>
                                    </tr>
                                    @else
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Php {{ number_format($order->total_amount, 2) }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{
                                                $order->status === 'completed' ? 'success' :
                                                ($order->status === 'cancelled' ? 'danger' : 'warning')
                                            }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-info btn-sm" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>