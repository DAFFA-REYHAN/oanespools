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
                                        @foreach ($videos as $video)
                                            <tr>
                                                <td>{{ $video->name }}</td>
                                                <td>
                                                    @if ($video->path)
                                                        @php
                                                            $videoId = explode('v=', $video->path)[1] ?? null;
                                                            $videoId = explode('&', $videoId)[0] ?? null;
                                                            $embedUrl = $videoId
                                                                ? "https://www.youtube.com/embed/{$videoId}"
                                                                : null;
                                                        @endphp
                                                        @if ($embedUrl)
                                                            <iframe width="200" height="150" src="{{ $embedUrl }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen></iframe>
                                                        @else
                                                            No Video Available
                                                        @endif
                                                    @else
                                                        No Video Available
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('gallery.destroy', $video->id) }}" method="POST"
                                                        class="delete-form" id="videoDeleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm deleteButton"
                                                            data-id="video-{{ $video->id }}"><i
                                                                class="icon-base ti tabler-trash me-2"></i> Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                @if ($imageCount >= 3)
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
                                        @foreach ($images as $image)
                                            <tr>
                                                <td>{{ $image->name }}</td>
                                                <td>
                                                    <img src="{{ Storage::url($image->path) }}"
                                                        alt="Gambar {{ $image->name }}" height="150px" />
                                                </td>
                                                <td>
                                                    <form action="{{ route('gallery.destroy', $image->id) }}" method="POST"
                                                        class="delete-form" id="imageDeleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm deleteButton"
                                                            data-id="image-{{ $image->id }}"><i
                                                                class="icon-base ti tabler-trash me-2"></i> Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
                timer: 2500, // The alert will automatically close after 3 seconds
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
                timer: 2500, // The alert will automatically close after 3 seconds
            });
        </script>
    @endif
@endsection

@section('css')

    <style>
        /* Add this CSS inside your styles */
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately

                const itemId = this.getAttribute('data-id'); // Get the item ID (video or image)

                let itemName = "";
                if (itemId.includes('video')) {
                    // If it's a video, get the video name
                    itemName = "{{ $video->name }}";
                } else {
                    // If it's an image, get the image name
                    itemName = "{{ $image->name }}";
                }

                Swal.fire({
                    title: 'Hapus Gallery',
                    text: `Yakin ingin menghapus  "${itemName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the respective form based on the item type
                        if (itemId.includes('video')) {
                            document.getElementById('videoDeleteForm')
                                .submit(); // Submit video form
                        } else {
                            document.getElementById('imageDeleteForm')
                                .submit(); // Submit image form
                        }
                    }
                });
            });
        });
    </script>

@endsection
