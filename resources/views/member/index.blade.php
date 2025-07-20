@extends('layout')
@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <h3>Member List</h3>
    <a href="{{ route('member.create') }}">+ Add New Member</a>

    {{-- Search & Filter Form --}}
    <form method="GET" action="{{ route('member.index') }}" style="margin: 15px 0;">
        <input type="text" name="search" placeholder="Search member..." value="{{ request('search') }}"
               style="padding: 6px; width: 200px;" onkeydown="if(event.key === 'Enter') this.form.submit();">

        <select name="filter" onchange="this.form.submit()" style="padding: 6px;">
            <option value="">-- All Status & Order --</option>
            <option value="active_oldest" {{ request('filter') == 'active_oldest' ? 'selected' : '' }}>Active - Oldest</option>
            <option value="active_newest" {{ request('filter') == 'active_newest' ? 'selected' : '' }}>Active - Newest</option>
            <option value="inactive_oldest" {{ request('filter') == 'inactive_oldest' ? 'selected' : '' }}>Inactive - Oldest</option>
            <option value="inactive_newest" {{ request('filter') == 'inactive_newest' ? 'selected' : '' }}>Inactive - Newest</option>
        </select>
    </form>

    @if($members->count())
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>Phone</th>
                    <th>sts</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->status }}</td>
                        <td>
                            <button onclick="showDetail({{ $member->id }})">Detail</button>
                            <button onclick="showEdit({{ $member->id }})">Edit</button>
                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Detail Modal --}}
                    <div id="detail-modal-{{ $member->id }}" style="display:none; position:fixed; top:20%; left:30%; background:white; padding:20px; border:1px solid black; z-index:1000;">
                        <h4>Member Detail</h4>
                        <p><strong>Name:</strong> {{ $member->name }}</p>
                        <p><strong>email:</strong> {{ $member->email }}</p>
                        <p><strong>Phone:</strong> {{ $member->phone }}</p>
                        <p><strong>Address:</strong> {{ $member->address }}</p>
                        <p><strong>joined:</strong> {{ $member->joined }}</p>
                        <p><strong>sts:</strong> {{ $member->status }}</p>
                        <button onclick="hideDetail({{ $member->id }})">Close</button>
                    </div>

                    {{-- Edit Modal --}}
                    <div id="edit-modal-{{ $member->id }}" style="display:none; position:fixed; top:20%; left:30%; background:white; padding:20px; border:1px solid black; z-index:1000;">
                        <h4>Edit Member</h4>
                        <form action="{{ route('member.update', $member->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <p><strong>Name:</strong> <input type="text" name="name" value="{{ $member->name }}"></p>
                            <p><strong>Email:</strong> <input type="email" name="email" value="{{ $member->email }}"></p>
                            <p><strong>Phone:</strong> <input type="text" name="phone" value="{{ $member->phone }}"></p>
                            <p><strong>Address:</strong> <input type="text" name="address" value="{{ $member->address }}"></p>
                            <p><strong>Joined:</strong> <input type="date" name="joined" value="{{ $member->joined }}"></p>
                            <p><strong>Status:</strong>
                                <select name="status">
                                    <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </p>

                            <button type="submit">Update</button>
                            <button type="button" onclick="hideEdit({{ $member->id }})">Cancel</button>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
    @else
        <p><strong>No members found.</strong></p>
    @endif

    {{-- Scripts --}}
    <script>
        function showDetail(id) {
            document.getElementById('detail-modal-' + id).style.display = 'block';
        }
        function hideDetail(id) {
            document.getElementById('detail-modal-' + id).style.display = 'none';
        }
        function showEdit(id) {
            document.getElementById('edit-modal-' + id).style.display = 'block';
        }
        function hideEdit(id) {
            document.getElementById('edit-modal-' + id).style.display = 'none';
        }
    </script>
@endsection
