<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h2 class="mb-0">User Details</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($user->profile_photo_path)
                                <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : 'https://static.everypixel.com/ep-pixabay/0329/8099/0858/84037/3298099085884037069-head.png' }}" class="img-fluid rounded-circle mb-3" alt="{{ $user->name }}'s avatar">
                                @else
                                <img src="https://static.everypixel.com/ep-pixabay/0329/8099/0858/84037/3298099085884037069-head.png" class="img-fluid rounded-circle mb-3" alt="Default avatar">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'success' : 'secondary' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Registered</th>
                                        <td>{{ $user->created_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $user->updated_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users-manage') }}" class="btn btn-secondary">Back to Users</a>
                        @if($user->role === 'user')
                        <form action="{{ route('deleteUser', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete User</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>