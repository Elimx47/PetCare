<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Manage Users</h1>



                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created at</th>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Role</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i = 0 ?>
                                    @foreach ( $users as $user)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at->diffForHumans()}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Show Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'success' : 'secondary' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>