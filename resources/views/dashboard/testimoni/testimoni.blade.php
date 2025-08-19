@extends('dashboard.dashboard-app')

@section('title', 'Testimoni')

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
                                <h4 class="card-title mb-0">Testimoni</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Domisili</th>
                                                <th>Pesan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$testimonis->isEmpty())
                                                @foreach ($testimonis as $testi)
                                                    <tr>
                                                        <td>{{ $testi->nama }}</td>
                                                        <td>{{ $testi->domisili }}</td>
                                                        <td>{{ $testi->pesan }}</td>
                                                        <td>
                                                            <form action="{{ route('testimoni.destroy', $testi->id) }}"
                                                                method="POST" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-record"
                                                                    data-id="{{ $testi->id }}">
                                                                    <i class="icon-base ti tabler-trash me-2"></i> Hapus
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
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
            </div>

            @include('dashboard.footer-dashboard')
            <div class="content-backdrop fade"></div>
        </div>
    </div>

@section('css')
    <link rel="stylesheet" href="{{ asset('/vuexy/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('../vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
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
        $('#testimoniTable').on('click', '.delete-record', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Testimoni?',
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
                        url: '{{ url('/testimoni') }}/' + id, // <-- ganti sesuai route
                        method: 'POST', // Laravel butuh _method override
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            // reload datatable atau hapus row manual
                            // contoh kalau pakai DataTable:
                            dt_basic.ajax.reload();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Testimoni berhasil dihapus',
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
                                text: 'Gagal menghapus testimoni: ' + xhr.responseText,
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
    </script>
@endsection

@section('css')

@endsection

@section('js')

@endsection
