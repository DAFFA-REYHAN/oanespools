@extends('dashboard.dashboard-app')
@section('title', 'Testimoni')

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
                            <h4 class="mb-0">Testimoni</h4>
                            {{-- <small class="text-body-secondary float-end">
                                @if ($testimoniCount >= 6)
                                    <button class="btn btn-sm text-danger" disabled>Max 6 testimoni</button>
                                @else
                                    <a href="{{ route('add-testimoni') }}" class="btn btn-primary btn-sm"> + Tambah
                                        testimoni</a>
                                @endif
                            </small> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <div class="card mb-4">
                                        <div class="table-responsive">
                                            <table class="table text-center" id="artikelTable">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Domisili</th>
                                                        <th>Pesan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($testimonis as $testimoni)
                                                        <tr id="testimoni-row-{{ $testimoni->id }}">
                                                            <td>{{ $testimoni->nama }}</td>
                                                            <td>{{ $testimoni->domisili }}</td>
                                                            <td>{{ $testimoni->pesan }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('testimoni.destroy', $testimoni->id) }}"
                                                                    method="POST" class="delete-form d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger delete-btn">
                                                                        <i class="icon-base ti tabler-trash"></i> Hapus
                                                                    </button>
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
                const deleteButtons = document.querySelectorAll('.delete-btn');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Hapus Testimoni',
                            text: 'Yakin ingin menghapus testimoni ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // 🔥 langsung submit form ke route destroy
                            }
                        });
                    });
                });

                // ✅ Tampilkan pesan dari session
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
