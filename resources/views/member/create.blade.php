@extends('layout')

@section('content')
    <div class="form-container">
        <h2>Tambah Member</h2>
        <form action="{{ route('member.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Telepon:</label>
                <input type="text" name="phone" required>
            </div>

            <div class="form-group">
                <label>Alamat:</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>Tanggal Bergabung:</label>
                <input type="date" name="joined" required>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit">Simpan</button>
                <a href="{{ route('member.index') }}" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>

    <style>
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 30, 60, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        h2 {
            color: #0a3d62;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #0a3d62;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-buttons {
            margin-top: 20px;
        }

        button {
            background-color: #0a3d62;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-back {
            margin-left: 10px;
            color: #0a3d62;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
@endsection
