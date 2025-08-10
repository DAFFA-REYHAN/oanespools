@extends('dashboard.dashboard-app')
@section('title', 'Layanan')

@section('content')
    <style>
        .hover-red:hover {
            color: #dc3545;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 9998;
            align-items: center;
            justify-content: center;
        }

        .loading-spinner {
            width: 40px;
            
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
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

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Layout container -->
    <div class="layout-page">
        @include('dashboard.nav-dashboard')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Layanan </h4>
                            <small class="text-body-secondary float-end">
                                @if ($layananCount >= 8)
                                    <button class="btn btn-sm text-danger" disabled>Max 8 Layanan</button>
                                @else
                                    <a href="{{ route('add-layanan') }}" class="btn btn-primary btn-sm"> + Tambah
                                        Layanan</a>
                                @endif
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    @if ($layanans->count() > 0)
                                        @foreach ($layanans as $layanan)
                                            <div class="card mb-4" id="layanan-card-{{ $layanan->id }}">
                                                <div class="row g-0">
                                                    <div class="col-md-3">
                                                        <img class="card-img card-img-left"
                                                            src="{{ asset('storage/' . $layanan->gambar) }}"
                                                            alt="Card image"
                                                            onerror="this.src='{{ asset('img/no-image.png') }}'" />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="card-body">
                                                            <h4 class="card-title text-container-header">
                                                                {{ $layanan->nama_layanan }}
                                                            </h4>
                                                            <span class="text-container-text">
                                                                {!! getCleanDescription($layanan->deskripsi, 150) !!}
                                                            </span>

                                                            <div
                                                                class="card-text text-md-start mt-3 text-end d-flex flex-column flex-md-row">
                                                                <small class="text-body-secondary me-md-7">
                                                                    Created At {{ $layanan->created_at->diffForHumans() }}
                                                                </small>
                                                                <small class="text-body-secondary">
                                                                    Last Update {{ $layanan->updated_at->diffForHumans() }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 my-md-auto mx-md-auto mb-4 text-center">
                                                        <a class="btn btn-sm btn-success my-1 w-xxl-75"
                                                            href="{{ route('edit-layanan', $layanan->id) }}">
                                                            <i class="icon-base ti tabler-pencil"></i>
                                                            <span class="d-none d-xxl-inline-block">Edit</span>
                                                        </a>

                                                        <button class="btn btn-sm btn-danger my-1 w-xxl-75 delete-btn"
                                                            data-id="{{ $layanan->id }}"
                                                            data-name="{{ $layanan->nama_layanan }}">
                                                            <i class="icon-base ti tabler-trash"></i>
                                                            <span class="d-none d-xxl-inline-block">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-5">
                                            <i class="icon-base ti tabler-database-off icon-lg text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada layanan</h5>
                                            <p class="text-muted">Silakan tambah layanan pertama Anda</p>
                                            <a href="{{ route('add-layanan') }}" class="btn btn-primary">
                                                <i class="icon-base ti tabler-plus me-2"></i>Tambah Layanan
                                            </a>
                                        </div>
                                    @endif
                                </div>
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

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete button clicks
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const layananId = this.dataset.id;
                    const layananName = this.dataset.name;
                    const deleteButton = this;

                    // Simple confirmation dialog
                    Swal.fire({
                        title: 'Hapus Layanan?',
                        text: `Yakin ingin menghapus "${layananName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteLayanan(layananId, layananName, deleteButton);
                        }
                    });
                });
            });

            // Delete function
            function deleteLayanan(id, name, button) {
                // Show loading
                button.disabled = true;
                button.innerHTML = '<i class="ti tabler-loader-2"></i> Hapus...';
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Create and submit form
                fetch(`/layanan/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading
                        document.getElementById('loadingOverlay').style.display = 'none';

                        if (data.success) {
                            // Success - remove card and show success message
                            const card = document.getElementById(`layanan-card-${id}`);
                            if (card) {
                                card.remove();
                            }

                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message || 'Layanan berhasil dihapus',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Check if no layanan left
                            checkEmptyState();
                        } else {
                            throw new Error(data.error || 'Gagal menghapus layanan');
                        }
                    })
                    .catch(error => {
                        // Hide loading and restore button
                        document.getElementById('loadingOverlay').style.display = 'none';
                        button.disabled = false;
                        button.innerHTML =
                            '<i class="icon-base ti tabler-trash"></i><span class="d-none d-xxl-inline-block">Delete</span>';

                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Terjadi kesalahan saat menghapus layanan',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                        console.error('Delete error:', error);
                    });
            }

            // Check if no layanan cards left
            function checkEmptyState() {
                const remainingCards = document.querySelectorAll('[id^="layanan-card-"]');
                if (remainingCards.length === 0) {
                    const cardBody = document.querySelector('.card-body .row .col-md');
                    if (cardBody) {
                        cardBody.innerHTML = `
                            <div class="text-center py-5">
                                <i class="icon-base ti tabler-database-off icon-lg text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada layanan</h5>
                                <p class="text-muted">Silakan tambah layanan pertama Anda</p>
                                <a href="{{ route('add-layanan') }}" class="btn btn-primary">
                                    <i class="icon-base ti tabler-plus me-2"></i>Tambah Layanan
                                </a>
                            </div>
                        `;
                    }
                }
            }

            // Show session messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

@endsection
