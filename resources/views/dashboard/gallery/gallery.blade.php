@extends('dashboard.dashboard-app')
@section('title', 'Gallery')

@section('content')
    <!-- Layout container -->
    <div class="layout-page">
        @include('dashboard.nav-dashboard')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-xl">
                    <div class="card mb-5">
                        <div class="card-header p-4">
                            <h4 class="mb-0">Galeri</h4>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <!-- VIDEO EMBED -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Video </h5>
                            <small class="text-body-secondary float-end">
                                @if ($videoCount >= 3)
                                    <button class="btn btn-sm text-danger" disabled>Max 3 Video</button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addVideoModal">+ Tambah Video</button>
                                @endif
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Video</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$videos->isEmpty())
                                            @foreach ($videos as $video)
                                                <tr>
                                                    <td>{{ $video->name }}</td>
                                                    <td>
                                                        @if ($video->path)
                                                            <!-- Display Local Video using HTML5 video tag -->
                                                            <video width="250" height="150" controls
                                                                   style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                                <source src="{{ Storage::url($video->path) }}" type="video/mp4">
                                                                <source src="{{ Storage::url($video->path) }}" type="video/webm">
                                                                <source src="{{ Storage::url($video->path) }}" type="video/ogg">
                                                                Your browser does not support the video tag.
                                                            </video>

                                                            <!-- Optional: Video Info -->
                                                            <div class="mt-2">
                                                                <small class="text-muted d-block">
                                                                    {{ pathinfo($video->path, PATHINFO_EXTENSION) }} •
                                                                    @if(Storage::disk('public')->exists($video->path))
                                                                        {{ number_format(Storage::disk('public')->size($video->path) / 1024 / 1024, 2) }} MB
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center"
                                                                 style="width: 250px; height: 150px; background-color: #f8f9fa; border-radius: 8px;">
                                                                <div class="text-center">
                                                                    <i class="ti ti-video-off" style="font-size: 32px; color: #6c757d;"></i>
                                                                    <p class="mb-0 text-muted small">No Video Available</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('gallery.destroy', $video->id) }}"
                                                            method="POST" class="delete-form" id="videoDeleteForm{{ $video->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm deleteButton"
                                                                data-id="video-{{ $video->id }}"
                                                                data-name="{{ $video->name }}">
                                                                <i class="icon-base ti tabler-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Video Preview Modal -->
                                                @if ($video->path)
                                                    <div class="modal fade" id="videoPreviewModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Preview: {{ $video->name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <video width="100%" height="400" controls>
                                                                        <source src="{{ Storage::url($video->path) }}" type="video/mp4">
                                                                        <source src="{{ Storage::url($video->path) }}" type="video/webm">
                                                                        <source src="{{ Storage::url($video->path) }}" type="video/ogg">
                                                                        Your browser does not support the video tag.
                                                                    </video>

                                                                    <!-- Video Details -->
                                                                    <div class="mt-3 text-start">
                                                                        <h6>Detail Video:</h6>
                                                                        <ul class="list-unstyled">
                                                                            <li><strong>Nama:</strong> {{ $video->name }}</li>
                                                                            <li><strong>Format:</strong> {{ strtoupper(pathinfo($video->path, PATHINFO_EXTENSION)) }}</li>
                                                                            @if(Storage::disk('public')->exists($video->path))
                                                                                <li><strong>Ukuran:</strong> {{ number_format(Storage::disk('public')->size($video->path) / 1024 / 1024, 2) }} MB</li>
                                                                            @endif
                                                                            <li><strong>Tanggal Upload:</strong> {{ $video->created_at->format('d M Y H:i') }}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{ Storage::url($video->path) }}"
                                                                       class="btn btn-success" target="_blank" download>
                                                                        <i class="ti ti-download me-1"></i> Download
                                                                    </a>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        Tutup
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center"> Belum ada Data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- GAMBAR -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gambar</h5>
                            <small class="text-body-secondary float-end">
                                @if ($imageCount >= 12)
                                    <button class="btn btn-sm text-danger" disabled>Max 12 Gambar</button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addImageModal"> + Tambah Gambar</button>
                                @endif
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$images->isEmpty())
                                            @foreach ($images as $image)
                                                <tr>
                                                    <td>{{ $image->name }}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($image->path) }}"
                                                            alt="Gambar {{ $image->name }}" height="150px"
                                                            style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);" />
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('gallery.destroy', $image->id) }}"
                                                            method="POST" class="delete-form" id="imageDeleteForm{{ $image->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm deleteButton"
                                                                data-id="image-{{ $image->id }}"
                                                                data-name="{{ $image->name }}">
                                                                <i class="icon-base ti tabler-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Image Preview Modal -->
                                                <div class="modal fade" id="imagePreviewModal{{ $image->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Preview: {{ $image->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ Storage::url($image->path) }}"
                                                                     alt="{{ $image->name }}" class="img-fluid"
                                                                     style="max-height: 500px; border-radius: 8px;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{ Storage::url($image->path) }}"
                                                                   class="btn btn-success" target="_blank" download>
                                                                    <i class="ti ti-download me-1"></i> Download
                                                                </a>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                    Tutup
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center"> Belum ada Data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->

            @include('dashboard.footer-dashboard')

            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->

    @include('dashboard.gallery.modal-video')
    @include('dashboard.gallery.modal-image')

    <script src="./vuexy/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                showConfirmButton: true,
                timer: 2500,
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                showConfirmButton: true,
                timer: 2500,
            });
        </script>
    @endif
@endsection

@section('css')
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const itemId = this.getAttribute('data-id');
                const itemName = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Hapus Gallery',
                    text: `Yakin ingin menghapus "${itemName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get the form by ID and submit it
                        const videoId = itemId.split('-')[1];
                        if (itemId.includes('video')) {
                            document.getElementById(`videoDeleteForm${videoId}`).submit();
                        } else {
                            document.getElementById(`imageDeleteForm${videoId}`).submit();
                        }
                    }
                });
            });
        });
    </script>
@endsection