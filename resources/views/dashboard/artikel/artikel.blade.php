@extends('dashboard.dashboard-app')

@section('title', 'Artikel')

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
                                <h4 class="card-title mb-0">Artikel</h4>
                                <div>
                                    @if ($artikelCount >= 20)
                                        <button class="btn btn-sm btn-outline-danger" disabled>
                                            <i class="fas fa-exclamation-triangle me-1"></i>Max 20 artikel
                                        </button>
                                    @else
                                        <a href="{{ route('artikel.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Tambah Artikel
                                        </a>
                                    @endif
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
    <link rel="stylesheet" href="{{ asset('/vuexy/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('../vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <style>
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }

        .article-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .article-image:hover {
            transform: scale(1.1);
        }

        .content-preview {
            max-width: 250px;
        }

        /* Fallback for missing images */
        .article-image-placeholder {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            border-radius: 6px;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('vuexy/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- <script src="{{ asset('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script> -->

    <!-- Magnific Popup -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
        $(document).ready(function() {
            let dt_basic = $('#artikelTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('artikel.data') }}',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal memuat data artikel: ' + xhr.responseText,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                columns: [{
                        data: 'title',
                        name: 'title',
                        render: function(data, type, row) {
                            return `<span class="fw-semibold text-primary">${data}</span>`;
                        }
                    },
                    {
                        data: 'content',
                        name: 'content',
                        orderable: false,
                        className: 'content-preview',
                        render: function(data, type, row) {
                            if (data && data.length > 100) {
                                return `<span class="text-muted">${data.substring(0, 100)}...</span>`;
                            }
                            return `<span class="text-muted">${data || 'Tidak ada konten'}</span>`;
                        }
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '80px',
                        render: function(data, type, row) {
                            if (data && data !== '') {
                                return `
                                    <a href="${data}" class="image-popup">
                                        <img src="${data}"
                                             alt="Gambar Artikel"
                                             class="article-image"
                                             onerror="this.onerror=null; this.closest('a').outerHTML='<div class=\'article-image-placeholder\'><i class=\'fas fa-image text-muted\'></i></div>';">
                                    </a>
                                `;
                            } else {
                                return `
                                    <div class="article-image-placeholder">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '120px',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-success btn-action edit-article"
                                            data-id="${row.id}" title="Edit">
                                        <i class="icon-base ti tabler-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-action delete-record"
                                            data-id="${row.id}" title="Hapus">
                                        <i class="icon-base ti tabler-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                language: {
                    emptyTable: "Tidak ada data artikel",
                    loadingRecords: "Memuat...",
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(dari _MAX_ total data)",
                },
                // Initialize Magnific Popup after table draw
                drawCallback: function() {
                    $('.image-popup').magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        mainClass: 'mfp-img-mobile',
                        image: {
                            verticalFit: true
                        }
                    });
                }
            });

            // View details
            $('#artikelTable').on('click', '.view-details', function() {
                const id = $(this).data('id');
                window.location.href = '{{ url('/artikel') }}/' + id;
            });

            // Edit artikel
            $('#artikelTable').on('click', '.edit-article', function() {
                const id = $(this).data('id');
                window.location.href = '{{ url('/artikel') }}/' + id + '/edit';
            });

            // Delete artikel
            $('#artikelTable').on('click', '.delete-record', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Artikel?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('/artikel') }}/' + id,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                dt_basic.ajax.reload();
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Artikel berhasil dihapus',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    },
                                    buttonsStyling: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus artikel: ' + xhr.responseText,
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: false
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection