@extends('dashboard.dashboard-app')
@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="../vuexy/assets/vendor/libs/animate-css/animate.css" />
<link rel="stylesheet" href="../vuexy/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
        .hover-red:hover {
            color: #dc3545;
        }
    </style>

    <!-- Layout container -->
    <div class="layout-page">
        @include('dashboard.nav-dashboard')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-0 text-center">Jumlah Proyek dan Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6 offset-md-3">
                            <!-- Form for creating or updating the record -->
                            <form action="{{ route('dashboard.store') }}" method="POST">
                                @csrf
                                <div class="mb-6">
                                    <label class="form-label" for="jumlah_proyek">Jumlah Proyek</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="icon-base ti tabler-building"></i>
                                        </span>
                                        <input type="text" name="jumlah_proyek" class="form-control" placeholder="14 +"
                                            value="{{ old('jumlah_proyek', $jumlah->jumlah_proyek ?? '') }}"
                                            aria-label="14 +" />
                                        <span class="input-group-text">+ Proyek Selesai</span>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label class="form-label" for="jumlah_pelanggan">Jumlah Pelanggan</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="icon-base ti tabler-user"></i>
                                        </span>
                                        <input type="text" name="jumlah_pelanggan" class="form-control"
                                            placeholder="50 +"
                                            value="{{ old('jumlah_pelanggan', $jumlah->jumlah_pelanggan ?? '') }}"
                                            aria-label="50 +" />
                                        <span class="input-group-text">+ Pelanggan</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    @if ($jumlah)
                                        Update
                                    @else
                                        Create
                                    @endif
                                </button>
                            </form>
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

    <!-- Vuexy's SweetAlert2 Script -->
     <script src="../vuexy/assets/vendor/libs/sweetalert2/sweetalert2.js" ></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                showConfirmButton: true,
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
            });
        </script>
    @endif
@endsection
