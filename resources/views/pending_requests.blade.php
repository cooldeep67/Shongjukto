@extends('layouts.app') {{-- Use your main layout --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pending Help Requests</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($requests->isEmpty())
        <p>No pending help requests available at the moment.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->category }}</td>
                    <td>{{ $request->description ?? 'N/A' }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>
                        @if($request->status === 'pending')
                            <form method="POST" action="{{ url('/volunteer/requests/' . $request->id . '/accept') }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>
                        @else
                            <span class="text-muted">Accepted</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
