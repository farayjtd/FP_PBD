@extends('layout')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h3 class="card-title mb-3 text-center">Add New Member</h3>

            <form action="{{ route('member.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="joined" class="form-label">Join Date</label>
                    <input type="date" name="joined" id="joined" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('member.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection