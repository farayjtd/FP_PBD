@extends('layout')

@section('content')
    <div class="form-container">
        <h3 class="form-title">Tambah Publisher Baru</h3>

        <form action="{{ route('publisher.store') }}" method="POST">
            @csrf

            <p>
                <label for="name">Nama:</label><br>
                <input type="text" name="name" id="name" required>
            </p>

            <p>
                <label for="address">Alamat:</label><br>
                <input type="text" name="address" id="address">
            </p>

            <p>
                <label for="phone">Telepon:</label><br>
                <input type="text" name="phone" id="phone">
            </p>

            <p>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email">
            </p>

            <button type="submit" class="btn-submit">Simpan</button>
            <a href="{{ route('publisher.index') }}" class="btn-back">Kembali</a>
        </form>
    </div>
@endsection

@push('styles')
<style>
    body {
        background-color: #ffffff;
        color: #1a237e;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        background-color: #f0f4ff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(26, 35, 126, 0.1);
    }

    .form-title {
        text-align: center;
        margin-bottom: 20px;
        color: #0d47a1;
    }

    label {
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #90caf9;
        border-radius: 5px;
    }

    .btn-submit, .btn-back {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        background-color: #1565c0;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
    }

    .btn-back {
        background-color: #9e9e9e;
        margin-left: 10px;
    }

    .btn-submit:hover {
        background-color: #0d47a1;
    }

    .btn-back:hover {
        background-color: #757575;
    }
</style>
@endpush
