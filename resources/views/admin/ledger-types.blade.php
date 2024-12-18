@extends('layouts.app')

@section('content')
<h1 class="mt-4">Ledger Types</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Ledger Types</li>
    </ol>
<div class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Ledger Types</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Ledger Type -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-ledger-type')">+ New Ledger Type</button>
        </div>
        <div id="create-ledger-type" class="card-body d-none">
            <form action="{{ route('ledger-types.store') }}" method="POST">
                @csrf
                <div class="row">
                    <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Ledger Type Name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Ledger Type Description"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check btn-icon-prepend"></i>Save</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-ledger-type')"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
        </div>
    </div>

    <!-- List of Ledger Types -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledgerTypes as $ledgerType)
                                <tr>
                                    <td>{{ $ledgerType->name }}</td>
                                    <td>{{ $ledgerType->description }}</td>
                                    <td>
                                        <button class="badge badge-kacapaka-warning" onclick="toggleSection('edit-ledger-type-{{ $ledgerType->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('ledger-types.destroy', $ledgerType->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-ledger-type-{{ $ledgerType->id }}" class="d-none">
                                    <td colspan="3" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('ledger-types.update', $ledgerType->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <label for="name" class="col-sm-3 col-lg-2 col-form-label">Name</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $ledgerType->name }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                                                        <div class="form-group col-sm-9 col-lg-10">
                                                            <textarea type="text" class="form-control" name="description" id="description">{{ $ledgerType->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="mdi mdi-file-check btn-icon-prepend"></i> Update</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-ledger-type-{{ $ledgerType->id }}')"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No ledger types available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSection(id) {
        const element = document.getElementById(id);
        element.classList.toggle('d-none');
    }
</script>
@endsection
