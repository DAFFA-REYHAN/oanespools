@extends('dashboard.dashboard-app')
@section('title', 'Tambah Artikel')

@section('content')
    <style>
        .hover-red:hover {
            color: #dc3545;
        }

        /* Image Upload Styles */
        .image-upload-wrapper {
            border: 2px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 2rem 1rem;
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

        /* Custom table button icon */
        .ql-table-better::before {
            font-size: 16px;
            font-weight: bold;
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
                                <a href="{{ route('artikel') }}">Artikel</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah Artikel</li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 text-center">Tambah Artikel</h4>
                        </div>
                        <div class="card-body">
                            <form class="browser-default-validation col-md-8 offset-md-2" enctype="multipart/form-data"
                                action="{{ route('artikel.store') }}" method="POST">

                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="title">Judul Artikel</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="Masukkan Judul Artikel" name="title" required />
                                </div>

                                <!-- Image Upload Section -->
                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="gambar">Gambar Artikel</label>

                                    <input type="file" class="form-control" id="gambar" name="image"
                                        accept="image/*" style="display: none;" required />

                                    <div class="image-upload-wrapper" id="uploadWrapper"
                                        onclick="document.getElementById('gambar').click()">
                                        <div id="uploadContent">
                                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                            <div class="text-upload">
                                                <strong>Klik untuk upload gambar</strong><br>
                                                Format: JPG, PNG, GIF (Max 5MB)
                                            </div>
                                        </div>

                                        <div id="previewContent" style="display: none;">
                                            <div class="preview-container">
                                                <img id="previewImg" class="preview-image" alt="Preview">
                                                <button type="button" class="btn btn-danger btn-remove"
                                                    onclick="removeImage(event)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted" id="fileInfo"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bolder" for="title">Konten Artikel</label>
                                    <!-- Quill Editor Container - Toolbar akan dibuat otomatis -->
                                    <div id="editor"></div>
                                    <!-- Hidden Input for Quill Editor Content -->
                                    <input type="hidden" name="content" id="editor-content" />
                                </div>

                                <div class="row text-center">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
                        placeholder: 'Tulis konten artikel di sini...'
                    };

                    quill = new Quill('#editor', options);

                } catch (error) {

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
                        placeholder: 'Tulis konten artikel di sini...'
                    });

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
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        this.value = '';
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak didukung! Gunakan JPG, PNG, atau GIF.');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('previewImg').src = e.target.result;
                        document.getElementById('uploadContent').style.display = 'none';
                        document.getElementById('previewContent').style.display = 'block';

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

                let formData = new FormData(document.querySelector('form.browser-default-validation'));

                if (quill) {
                    const content = quill.root.innerHTML;
                     formData.delete('content');
                    formData.append('content', content);
                    console.log('Quill content added:', content);
                }

                fetch("{{ route('artikel.store') }}", {
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
                                text: data.message || 'Artikel berhasil ditambahkan!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = "{{ route('artikel') }}";
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
            document.getElementById('gambar').value = '';
            document.getElementById('uploadContent').style.display = 'block';
            document.getElementById('previewContent').style.display = 'none';
        }
    </script>
@endsection
