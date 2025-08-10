@extends('dashboard.dashboard-app')
@section('title', 'Edit Layanan')

@section('content')
    <style>
        .hover-red:hover {
            color: #dc3545;
        }

        /* Image Upload Styles */
        .image-upload-wrapper {
            border: 2px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 0.5rem 0.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            background-color: #f8f9fa;
        }

        .image-upload-wrapper:hover {
            border-color: #696cff;
            background-color: #f4f5ff;
        }

        .upload-icon {
            font-size: 2.5rem;
            color: #a8aaae;
            margin-bottom: 1rem;
        }

        .preview-container {
            position: relative;
            display: inline-block;
            margin-top: 1rem;
        }

        .preview-image {
            max-width: 100%;
            max-height: 250px;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
        }

        .btn-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .text-upload {
            color: #a8aaae;
            font-size: 0.9375rem;
        }

        .text-upload strong {
            color: #5d596c;
        }

        /* Quill Editor Styling */
        .ql-toolbar {
            border: 1px solid #d9dee3;
            border-bottom: none;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .ql-container {
            border: 1px solid #d9dee3;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            font-size: 14px;
        }

        .ql-editor {
            min-height: 300px;
        }

        
        @media (max-width: 576px) {
            .image-upload-wrapper {
                padding: 1.5rem 1rem;
            }

            .preview-image {
                max-height: 200px;
            }

            .upload-icon {
                font-size: 2rem;
            }
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
                    <nav aria-label="breadcrumb mb-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('layanan') }}">Layanan</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Layanan</li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 text-center">Edit Layanan</h4>
                        </div>
                        <div class="card-body">
                            <form class="browser-default-validation col-md-8 offset-md-2" enctype="multipart/form-data"
                                action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="nama_layanan">Nama Layanan</label>
                                    <input type="text" class="form-control" id="nama_layanan"
                                        placeholder="Masukkan Nama Layanan" name="nama_layanan"
                                        value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required />
                                </div>

                                <!-- Image Upload Section -->
                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="gambar">Gambar</label>

                                    <input type="file" class="form-control" id="gambar" name="gambar"
                                        accept="image/*" style="display: none;" />

                                    <div class="image-upload-wrapper" id="uploadWrapper"
                                        onclick="document.getElementById('gambar').click()">
                                        <div id="uploadContent" style="{{ $layanan->gambar ? 'display: none;' : '' }}">
                                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                            <div class="text-upload">
                                                <strong>Klik untuk upload gambar</strong><br>
                                                Format: JPG, PNG, GIF (Max 5MB)
                                            </div>
                                        </div>

                                        <div id="previewContent" style="{{ $layanan->gambar ? '' : 'display: none;' }}">
                                            <div class="preview-container">
                                                <img id="previewImg" class="preview-image" alt="Preview"
                                                    src="{{ $layanan->gambar ? asset('storage/' . $layanan->gambar) : '' }}">
                                                <button type="button" class="btn btn-danger btn-remove"
                                                    onclick="removeImage(event)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted" id="fileInfo">
                                                    {{ $layanan->gambar ? 'Gambar saat ini: ' . basename($layanan->gambar) : '' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="title">Deskripsi</label>
                                    <!-- Quill Editor Container - Toolbar akan dibuat otomatis -->
                                    <div id="editor"></div>
                                    <!-- Hidden Input for Quill Editor Content -->
                                    <input type="hidden" name="deskripsi" id="editor-content" />
                                </div>

                                <div class="row text-center">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
                                        <a href="{{ route('layanan') }}" class="btn btn-secondary ms-2">Kembali</a>
                                    </div>
                                </div>
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
@endsection

@section('css')
    <link rel="stylesheet" href="../vuexy/assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="../vuexy/assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Quill Table Better CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill-table-better@1/dist/quill-table-better.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="../vuexy/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Quill Table Better JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-table-better@1/dist/quill-table-better.js"></script>

    <script>
        let quill;

        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit for all scripts to load
            setTimeout(function() {
                try {
                    // Register the table-better module
                    Quill.register({
                        'modules/table-better': QuillTableBetter
                    }, true);

                    // Initialize Quill with complete toolbar and table better
                    const options = {
                        theme: 'snow',
                        modules: {
                            table: false, // Disable default table module
                            toolbar: [
                                [{
                                    'font': []
                                }, {
                                    'size': ['small', false, 'large', 'huge']
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                [{
                                    'script': 'sub'
                                }, {
                                    'script': 'super'
                                }],
                                [{
                                    'header': 1
                                }, {
                                    'header': 2
                                }, 'blockquote', 'code-block'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }],
                                [{
                                    'direction': 'rtl'
                                }, {
                                    'align': []
                                }],
                                ['link', 'image', 'video'],
                                ['table-better'],
                                ['clean']
                            ],
                            'table-better': {
                                language: 'en_US',
                                menus: ['column', 'row', 'merge', 'table', 'cell', 'wrap', 'copy',
                                    'delete'
                                ],
                                toolbarTable: true
                            },
                            keyboard: {
                                bindings: QuillTableBetter.keyboardBindings
                            }
                        },
                        placeholder: 'Tulis deskripsi layanan di sini...'
                    };

                    quill = new Quill('#editor', options);
                    console.log('Quill with Table Better initialized successfully');

                    // Load existing content into Quill editor
                    @if ($layanan->deskripsi)
                        quill.root.innerHTML = `{!! addslashes($layanan->deskripsi) !!}`;
                    @endif

                } catch (error) {
                    console.error('Error initializing Quill with Table Better:', error);

                    // Fallback: Initialize basic Quill
                    quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'font': []
                                }, {
                                    'size': ['small', false, 'large', 'huge']
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                [{
                                    'script': 'sub'
                                }, {
                                    'script': 'super'
                                }],
                                [{
                                    'header': 1
                                }, {
                                    'header': 2
                                }, 'blockquote', 'code-block'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }],
                                [{
                                    'direction': 'rtl'
                                }, {
                                    'align': []
                                }],
                                ['link', 'image', 'video'],
                                ['clean']
                            ]
                        },
                        placeholder: 'Tulis deskripsi layanan di sini...'
                    });

                    // Load existing content for fallback
                    @if ($layanan->deskripsi)
                        quill.root.innerHTML = `{!! addslashes($layanan->deskripsi) !!}`;
                    @endif

                    console.log('Fallback Quill initialized (without table)');
                }

                // Setup event handlers after initialization
                setupEventHandlers();

            }, 1000); // Increase delay to 1 second
        });

        function setupEventHandlers() {
            // Form submission handler
            document.querySelector('form').onsubmit = function(event) {
                if (quill) {
                    const content = quill.root.innerHTML;
                    document.querySelector('#editor-content').value = content;
                }
            };

            // Image Upload Functionality
            document.getElementById('gambar').addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validasi ukuran (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        this.value = '';
                        return;
                    }

                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak didukung! Gunakan JPG, PNG, atau GIF.');
                        this.value = '';
                        return;
                    }

                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('previewImg').src = e.target.result;
                        document.getElementById('uploadContent').style.display = 'none';
                        document.getElementById('previewContent').style.display = 'block';

                        // Info file
                        let fileSize = (file.size / 1024).toFixed(1) + ' KB';
                        if (file.size > 1024 * 1024) {
                            fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                        }
                        document.getElementById('fileInfo').textContent = `${file.name} (${fileSize})`;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Submit button handler
            document.getElementById('submitButton').addEventListener('click', function(event) {
                event.preventDefault();

                let formData = new FormData(document.querySelector('form'));

                if (quill) {
                    const content = quill.root.innerHTML;
                    formData.append('deskripsi', content);
                }

                fetch("{{ route('layanan.update', $layanan->id) }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: data.message || 'Layanan berhasil diupdate!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = "{{ route('layanan') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ups...',
                                text: data.error || 'Terjadi kesalahan. Silakan coba lagi.',
                                showConfirmButton: true,
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Jaringan',
                            text: 'Terjadi kesalahan pada permintaan. Silakan coba lagi.',
                            showConfirmButton: true,
                        });
                    });
            });
        }

        // Global function for removing image
        function removeImage(event) {
            event.stopPropagation();

            // Reset file input
            document.getElementById('gambar').value = '';

            // Show upload content, hide preview
            document.getElementById('uploadContent').style.display = 'block';
            document.getElementById('previewContent').style.display = 'none';

            // Clear the preview image source
            document.getElementById('previewImg').src = '';
            document.getElementById('fileInfo').textContent = '';
        }
    </script>
@endsection
