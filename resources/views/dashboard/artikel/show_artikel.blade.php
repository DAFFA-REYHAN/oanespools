@extends('dashboard.dashboard-app')

@section('title', 'Detail Artikel')

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
                                <h4 class="card-title mb-0">Detail Artikel</h4>
                                <div>
                                    <a href="{{ route('artikel.edit', $artikel) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="{{ route('artikel') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">{{ $artikel->title }}</h3>

                                        <div class="mb-4">
                                            <h6 class="text-muted">Konten Artikel:</h6>
                                            <div class="border p-3 rounded bg-light">
                                                {!! nl2br(e($artikel->content)) !!}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-plus me-1"></i>
                                                    Dibuat: {{ $artikel->created_at->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-edit me-1"></i>
                                                    Diupdate: {{ $artikel->updated_at->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        @if($artikel->image)
                                            <div class="mb-3">
                                                <h6 class="text-muted">Gambar Artikel:</h6>
                                                <img src="{{ asset('storage/' . $artikel->image) }}" alt="{{ $artikel->title }}"
                                                     class="img-fluid rounded shadow">
                                            </div>
                                        @else
                                            <div class="text-center text-muted">
                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                <p>Tidak ada gambar</p>
                                            </div>
                                        @endif
                                    </div>
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
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection