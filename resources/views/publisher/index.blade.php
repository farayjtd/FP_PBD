@extends('layout')

@if (session('error'))
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif


@section('content')
    <h3 style="color: #003366;">Publisher List</h3>
    <a href="{{ route('publisher.create') }}" style="color: white; background-color: #003366; padding: 5px 10px; text-decoration: none; border-radius: 4px;">+ Add New Publisher</a>

    <form method="GET" action="{{ route('publisher.index') }}" style="margin-top: 10px;">
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    </form>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 15px; background-color: white; border-collapse: collapse;">
        <thead style="background-color: #003366; color: white;">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($publishers->count() > 0)
                @foreach($publishers as $index => $publisher)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $publisher->name }}</td>
                        <td>{{ $publisher->phone }}</td>
                        <td>{{ $publisher->email }}</td>
                        <td>
                            <button style="background-color: #003366; color: white;" onclick="showDetail({{ $publisher->id }})">Detail</button>
                            <button style="background-color: #003366; color: white;" onclick="showEdit({{ $publisher->id }})">Edit</button>
                            <form action="{{ route('publisher.destroy', $publisher->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" style="background-color: darkred; color: white;">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div id="detail-modal-{{ $publisher->id }}" style="display:none; position:fixed; top:15%; left:30%; background:white; padding:20px; border:2px solid #003366; width:400px;">
                        <h4 style="color:#003366;">Publisher Detail</h4>
                        <p><strong>Name:</strong> {{ $publisher->name }}</p>
                        <p><strong>Address:</strong> {{ $publisher->address }}</p>
                        <p><strong>Phone:</strong> {{ $publisher->phone }}</p>
                        <p><strong>Email:</strong> {{ $publisher->email }}</p>
                        <button onclick="hideDetail({{ $publisher->id }})" style="background-color: #003366; color: white;">Close</button>
                    </div>

                    <!-- Edit Modal -->
                    <div id="edit-modal-{{ $publisher->id }}" style="display:none; position:fixed; top:10%; left:30%; background:white; padding:20px; border:2px solid #003366; width:400px;">
                        <h4 style="color:#003366;">Edit Publisher</h4>
                        <form action="{{ route('publisher.update', $publisher->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <p>Name:<br><input type="text" name="name" value="{{ $publisher->name }}" style="width:100%;"></p>
                            <p>Address:<br><input type="text" name="address" value="{{ $publisher->address }}" style="width:100%;"></p>
                            <p>Phone:<br><input type="text" name="phone" value="{{ $publisher->phone }}" style="width:100%;"></p>
                            <p>Email:<br><input type="email" name="email" value="{{ $publisher->email }}" style="width:100%;"></p>
                            <button type="submit" style="background-color: #003366; color: white;">Update</button>
                            <button type="button" onclick="hideEdit({{ $publisher->id }})">Cancel</button>
                        </form>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align:center; color: red;">Data publisher tidak ditemukan.</td>
                </tr>
            @endif
        </tbody>
    </table>

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
