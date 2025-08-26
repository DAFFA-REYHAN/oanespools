<div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVideoModalLabel">Tambah Video Lokal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to add local video -->
                <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="video">

                    <!-- Video Title -->
                    <div class="mb-3">
                        <label for="videoTitle" class="form-label">Judul Video</label>
                        <input type="text" class="form-control" id="videoTitle" name="name"
                            placeholder="Masukkan judul video" required>
                    </div>

                    <!-- Video File Upload -->
                    <div class="mb-3">
                        <label for="videoFile" class="form-label">Pilih Video</label>
                        <input type="file" class="form-control" id="videoFile" name="video_file"
                            accept="video/*" required>
                        <div class="form-text">
                            Format yang didukung: MP4, AVI, MOV, WMV, FLV, MKV (Maksimal 100MB)
                        </div>
                    </div>

                    <!-- Upload Progress Bar -->
                    <div id="uploadProgress" style="display:none;">
                        <div class="mb-2">
                            <label class="form-label">Upload Progress:</label>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"
                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" style="display:none; text-align:center;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memproses video...</p>
                    </div>

                    <!-- Video Preview Container -->
                    <div id="videoPreviewContainer" class="mt-3 mb-3" style="display:none;">
                        <label class="form-label">Preview Video:</label>
                        <div class="border rounded p-2">
                            <video id="videoPreview" width="100%" height="300" controls style="border-radius: 8px;">
                                Browser Anda tidak mendukung video tag.
                            </video>
                            <div class="mt-2">
                                <small id="videoInfo" class="text-muted"></small>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="bi bi-cloud-upload"></i> Simpan Video
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('videoFile').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (!file) {
            hidePreview();
            return;
        }

        // Validate file type
        if (!file.type.startsWith('video/')) {
            alert('File yang dipilih bukan video. Silakan pilih file video.');
            event.target.value = '';
            hidePreview();
            return;
        }

        // Validate file size (100MB = 100 * 1024 * 1024 bytes)
        const maxSize = 100 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 100MB.');
            event.target.value = '';
            hidePreview();
            return;
        }

        // Show loading spinner
        document.getElementById('loadingSpinner').style.display = 'block';

        // Create file URL for preview
        const fileURL = URL.createObjectURL(file);
        const videoPreview = document.getElementById('videoPreview');

        // Set video source
        videoPreview.src = fileURL;

        // Show file information
        const fileSize = (file.size / (1024 * 1024)).toFixed(2);
        const videoInfo = document.getElementById('videoInfo');
        videoInfo.innerHTML = `
            <strong>File:</strong> ${file.name}<br>
            <strong>Ukuran:</strong> ${fileSize} MB<br>
            <strong>Tipe:</strong> ${file.type}
        `;

        // Auto-fill title if empty
        const titleInput = document.getElementById('videoTitle');
        if (!titleInput.value) {
            const fileName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
            titleInput.value = fileName;
        }

        // Hide loading spinner and show preview after a short delay
        setTimeout(function() {
            document.getElementById('loadingSpinner').style.display = 'none';
            document.getElementById('videoPreviewContainer').style.display = 'block';
        }, 1000);

        // Clean up URL when modal is closed
        const modal = document.getElementById('addVideoModal');
        modal.addEventListener('hidden.bs.modal', function() {
            URL.revokeObjectURL(fileURL);
        });
    });

    function hidePreview() {
        document.getElementById('videoPreviewContainer').style.display = 'none';
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('uploadProgress').style.display = 'none';
    }

    // Handle form submission with progress tracking
    document.querySelector('form').addEventListener('submit', function(event) {
        const fileInput = document.getElementById('videoFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('Silakan pilih file video terlebih dahulu.');
            event.preventDefault();
            return;
        }

        // Show upload progress
        document.getElementById('uploadProgress').style.display = 'block';
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Uploading...';

        // Simulate upload progress (replace this with actual upload progress if using AJAX)
        simulateUploadProgress();
    });

    function simulateUploadProgress() {
        const progressBar = document.querySelector('.progress-bar');
        let progress = 0;

        const interval = setInterval(function() {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.textContent = Math.round(progress) + '%';

            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 200);
    }

    // Reset form when modal is closed
    document.getElementById('addVideoModal').addEventListener('hidden.bs.modal', function() {
        document.querySelector('form').reset();
        hidePreview();
        document.getElementById('saveBtn').disabled = false;
        document.getElementById('saveBtn').innerHTML = '<i class="bi bi-cloud-upload"></i> Simpan Video';
    });

    // Drag and drop functionality
    const videoFileInput = document.getElementById('videoFile');
    const modal = document.querySelector('.modal-body');

    modal.addEventListener('dragover', function(e) {
        e.preventDefault();
        modal.style.backgroundColor = '#f8f9fa';
    });

    modal.addEventListener('dragleave', function(e) {
        e.preventDefault();
        modal.style.backgroundColor = '';
    });

    modal.addEventListener('drop', function(e) {
        e.preventDefault();
        modal.style.backgroundColor = '';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            videoFileInput.files = files;
            videoFileInput.dispatchEvent(new Event('change'));
        }
    });
</script>