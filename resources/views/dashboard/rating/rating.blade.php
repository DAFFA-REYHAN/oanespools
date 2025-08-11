@extends('dashboard.dashboard-app')

@section('title', 'Peniliana')

@section('content')
    <!-- Layout container -->
    <div class="layout-page">
        @include('dashboard.nav-dashboard')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Penilaian</h4>
                                <div>
                                        <a href="{{ route('artikel.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Tambah Penilaian
                                        </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="artikelTable">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Konten</th>
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data dimuat dinamis -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('dashboard.footer-dashboard')
            <div class="content-backdrop fade"></div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection