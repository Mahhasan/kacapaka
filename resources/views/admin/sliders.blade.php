@extends('layouts.app')

@section('content')
<div class="section-wrapper">
    <div class="page-header">
        <h2 class="display-4">Manage Sliders</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add New Slider -->
    <div class="card mb-4">
        <div class="card-header">
            <button class="btn btn-gradient-primary" type="button" onclick="toggleSection('create-slider')">+ New Slider</button>
        </div>
        <div id="create-slider" class="card-body d-none">
            <form action="{{ route('web-sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                <div class="row">
                    <label for="media_type" class="col-sm-3 col-lg-2 col-form-label">Media Type</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <select name="media_type" id="media_type" class="form-control" required>
                            <option value="image" {{ old('media_type') == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="link" {{ old('media_type') == 'link' ? 'selected' : '' }}>Link</option>
                        </select>
                        @error('media_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div id="media-file-section">
                    <div class="row">
                        <label for="media_file" class="col-sm-3 col-lg-2 col-form-label">Media File</label>
                        <div class="form-group col-sm-9 col-lg-10">
                            <input type="file" name="media_file" id="media_file" class="form-control-file">
                            @error('media_file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="media-url-section" class="d-none">
                    <div class="row">
                        <label for="media_url" class="col-sm-3 col-lg-2 col-form-label">Media URL</label>
                        <div class="form-group col-sm-9 col-lg-10">
                            <input type="url" name="media_url" id="media_url" class="form-control" placeholder="Enter media URL (for video link)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label for="link" class="col-sm-3 col-lg-2 col-form-label">Link</label>
                    <div class="form-group col-sm-9 col-lg-10">
                        <input type="url" name="link" id="link" class="form-control" placeholder="Enter clickable link">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <label class="form-check-label" for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        Active
                    </label>
                </div>

                <button type="submit" class="btn btn-sm btn-outline-primary btn-icon-text">
                    <i class="mdi mdi-file-check btn-icon-prepend"></i>Save
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('create-slider')">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
            </form>
        </div>
    </div>

    <!-- Sliders List -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Media</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                                <tr>
                                    <td>
                                        @if($slider->media_type == 'image')
                                            <img src="{{ asset('sliders/' . $slider->media_file_path) }}" alt="Slider Image" width="100">
                                        @elseif($slider->media_type == 'video')
                                            <video width="100" controls>
                                                <source src="{{ asset('sliders/' . $slider->media_file_path) }}" type="video/mp4">
                                            </video>
                                        @elseif($slider->media_type == 'link')
                                            <a href="{{ $slider->media_url }}" target="_blank">View Link</a>
                                        @endif
                                    </td>
                                    <td>{{ $slider->link ?? 'N/A' }}</td>
                                    <td class="switch">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input toggle-status"
                                                type="checkbox"
                                                id="toggle-status-{{ $slider->id }}"
                                                data-id="{{ $slider->id }}"
                                                {{ $slider->is_active ? 'checked' : '' }}>
                                            <label
                                                class="form-check-label"
                                                for="toggle-status-{{ $slider->id }}">
                                                <span class="text-{{ $slider->is_active ? 'primary' : 'danger' }}">
                                                    {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $slider->position }}</td>
                                    <td>
                                        <button class="badge badge-warning" onclick="toggleSection('edit-slider-{{ $slider->id }}')">Edit <i class="mdi mdi-file-check btn-icon-prepend"></i></button>
                                        <form action="{{ route('web-sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="edit-slider-{{ $slider->id }}" class="d-none">
                                    <td colspan="5" class="bg-aliceblue">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('web-sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Form Fields for Edit -->

                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="mdi mdi-file-check btn-icon-prepend"></i> Update
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSection('edit-slider-{{ $slider->id }}')">
                                                        <i class="fa-solid fa-xmark"></i> Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No sliders available.</td>
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

    // Handle Media Type Switch (Image/Video/Link)
    document.getElementById('media_type').addEventListener('change', function () {
        const mediaType = this.value;
        if (mediaType == 'link') {
            document.getElementById('media-file-section').classList.add('d-none');
            document.getElementById('media-url-section').classList.remove('d-none');
        } else {
            document.getElementById('media-file-section').classList.remove('d-none');
            document.getElementById('media-url-section').classList.add('d-none');
        }
    });

    // Handle Status Toggle
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const sliderId = this.dataset.id;
            const isActive = this.checked ? 1 : 0;

            fetch(`/web-sliders/toggle-status/${sliderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = this.nextElementSibling.querySelector('span');
                    label.className = `text-${isActive ? 'success' : 'danger'}`;
                    label.textContent = isActive ? 'Active' : 'Inactive';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked; // Revert toggle if error
            });
        });
    });
</script>
@endsection
