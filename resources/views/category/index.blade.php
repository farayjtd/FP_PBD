@extends('layout')

@section('content')
    <style>
        body {
            background-color: #ffffff;
            color: #1a1a1a;
            font-family: 'Segoe UI', sans-serif;
        }

        h3 {
            color: #0a2a63;
            border-bottom: 2px solid #0a2a63;
            padding-bottom: 5px;
        }

        a, button {
            background-color: #0a2a63;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        a:hover, button:hover {
            background-color: #08386f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #cccccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #0a2a63;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            top: 15%;
            left: 50%;
            transform: translate(-50%, 0);
            background-color: #ffffff;
            border: 2px solid #0a2a63;
            padding: 20px;
            z-index: 9999;
            border-radius: 8px;
            width: 400px;
        }

        .modal h4 {
            color: #0a2a63;
        }

        .modal input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .modal button {
            margin-right: 8px;
        }
    </style>

    <h3>Category List</h3>
    <a href="{{ route('category.create') }}">+ Add New Category</a>

    <!-- Form Search -->
    <form method="GET" action="{{ route('category.index') }}" style="margin-top: 10px;">
        <input type="text" name="search" placeholder="Search category..." value="{{ request('search') }}" style="padding: 6px; width: 250px;">
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ktgr</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($categories->count())
                @foreach($categories as $i => $category)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <button onclick="showDetail({{ $category->id }})">Detail</button>
                            <button onclick="showEdit({{ $category->id }})">Edit</button>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div id="detail-modal-{{ $category->id }}" class="modal">
                        <h4>Category Detail</h4>
                        <p><strong>ktgr:</strong> {{ $category->name }}</p>
                        <p><strong>Slug:</strong> {{ $category->slug }}</p>
                        <p><strong>Created:</strong> {{ $category->created_at }}</p>
                        <p><strong>Updated:</strong> {{ $category->updated_at }}</p>
                        <button onclick="hideDetail({{ $category->id }})">Close</button>
                    </div>

                    <!-- Edit Modal -->
                    <div id="edit-modal-{{ $category->id }}" class="modal">
                        <h4>Edit Category</h4>
                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" required>
                            <input type="text" name="slug" value="{{ $category->slug }}" required>
                            <button type="submit">Update</button>
                            <button type="button" onclick="hideEdit({{ $category->id }})">Cancel</button>
                        </form>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center; color: red;">Data kategori tidak ditemukan.</td>
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
