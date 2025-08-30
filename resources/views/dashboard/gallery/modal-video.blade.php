<style>
    .hover-red:hover {
        color: #dc3545;
    }

    /* Video Upload Styles */
    .video-upload-wrapper {
        border: 2px dashed #d9dee3;
        border-radius: 0.5rem;
        padding: 0.2rem 0.2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        background-color: #f8f9fa;
    }

    .video-upload-wrapper:hover {
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

    .preview-media {
        max-width: 100%;
        max-height: 300px;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
        border: 2px solid #e3e6f0;
    }

    .btn-remove {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        z-index: 10;
    }

    .text-upload {
        color: #a8aaae;
        font-size: 0.9375rem;
    }

    .text-upload strong {
        color: #5d596c;
    }

    .thumbnail-upload-wrapper {
        border: 2px dashed #d9dee3;
        border-radius: 0.5rem;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        background-color: #f8f9fa;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .thumbnail-upload-wrapper:hover {
        border-color: #28a745;
        background-color: #f0fff4;
    }

    .thumbnail-controls {
        margin-top: 1rem;
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border: 1px solid #e3e6f0;
    }

    .thumbnail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .thumbnail-upload-wrapper:hover .thumbnail-overlay {
        opacity: 1;
    }

    .overlay-content {
        color: white;
        text-align: center;
    }

    .auto-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.7rem;
        font-weight: bold;
    }

    .manual-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(23, 162, 184, 0.9);
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.7rem;
        font-weight: bold;
    }

    #thumbnailCanvas {
        display: none;
    }
</style>

<div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVideoModalLabel">Tambah Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to add local video -->
                <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data" id="videoForm">
                    @csrf
                    <input type="hidden" name="type" value="video">
                    <input type="hidden" name="thumbnail_data" id="thumbnailData">
                    <input type="hidden" name="thumbnail_type" id="thumbnailType" value="auto">

                    <!-- Video Title -->
                    <div class="mb-3">
                        <label for="videoTitle" class="form-label">Judul Video</label>
                        <input type="text" class="form-control" id="videoTitle" name="name"
                            placeholder="Masukkan judul video" required>
                    </div>

                    <!-- Video File Upload -->
                    <div class="mb-3">
                        <label for="videoFile" class="form-label fw-bolder">Pilih Video</label>
                        <input type="file" class="form-control" id="videoFile" name="video_file"
                            accept="video/*" style="display: none;" required>

                        <div class="video-upload-wrapper" id="videoUploadWrapper"
                            onclick="document.getElementById('videoFile').click()">
                            <div id="videoUploadContent">
                                <div>
                                    <i class="fas fa-video upload-icon"></i>
                                    <div class="text-upload">
                                        <strong>Klik untuk upload video atau drag & drop</strong><br>
                                        Format: MP4, AVI, MOV, WMV, FLV, MKV (Max 100MB)
                                    </div>
                                </div>
                            </div>

                            <div id="videoPreviewContent" style="display: none;">
                                <div class="preview-container">
                                    <video id="videoPreview" class="preview-media" controls muted>
                                        Browser Anda tidak mendukung video tag.
                                    </video>
                                    <button type="button" class="btn btn-danger btn-remove"
                                        onclick="removeVideo(event)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted" id="videoFileInfo"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Section -->
                    <div class="mb-4" id="thumbnailSection" style="display: none;">
                        <label class="form-label fw-bolder">Thumbnail Video</label>

                        <!-- Hidden file input for manual thumbnail -->
                        <input type="file" class="form-control" id="thumbnailFileInput"
                            accept="image/jpeg,image/jpg,image/png,image/gif" style="display: none;">

                        <div class="thumbnail-upload-wrapper" id="thumbnailWrapper"
                            onclick="handleThumbnailClick()">

                            <!-- Default state - waiting for video -->
                            <div id="thumbnailWaiting">
                                <div>
                                    <i class="fas fa-image upload-icon"></i>
                                    <div class="text-upload">
                                        <strong>Thumbnail akan generate otomatis</strong><br>
                                        Atau klik untuk upload gambar sendiri
                                    </div>
                                </div>
                            </div>

                            <!-- Generated/Uploaded thumbnail display -->
                            <div id="thumbnailDisplay" style="display: none;">
                                <img id="thumbnailImage" class="preview-media" alt="Thumbnail">

                                <!-- Badge for auto/manual -->
                                <div id="thumbnailBadge" class="auto-badge">AUTO</div>

                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger btn-remove"
                                    onclick="removeThumbnail(event)">
                                    <i class="fas fa-times"></i>
                                </button>

                                <!-- Hover overlay for actions -->
                                <div class="thumbnail-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-upload fa-2x mb-2"></i><br>
                                        <strong>Klik untuk ganti thumbnail</strong><br>
                                        <small>Upload gambar sendiri</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail Controls (for auto-generated) -->
                        <div class="thumbnail-controls" id="thumbnailControls" style="display: none;">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <label class="form-label small mb-1">Pilih waktu untuk thumbnail:</label>
                                    <input type="range" class="form-range" id="thumbnailTime"
                                        min="0" max="10" step="0.5" value="1"
                                        oninput="updateThumbnailFromSlider()">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">0s</small>
                                        <small class="text-muted" id="currentTime">1.0s</small>
                                        <small class="text-muted" id="maxTime">10s</small>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="regenerateThumbnail()">
                                        <i class="fas fa-redo"></i> Generate Ulang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Progress Bar -->
                    <!-- Progress bar dihilangkan, loading cuma di button -->

                    <!-- Loading Spinner -->
                    <!-- Loading spinner dihilangkan, loading cuma di button -->

                    <!-- Save Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn" disabled>
                            <i class="fas fa-save"></i> Simpan Video
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden canvas for thumbnail generation -->
<canvas id="thumbnailCanvas"></canvas>

<script>
    let videoFile = null;
    let videoUrl = null;
    let videoDuration = 0;
    let isGeneratingThumbnail = false;
    let thumbnailType = 'auto';

    // Video Upload Handler
    document.getElementById('videoFile').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (!file) {
            hideVideoPreview();
            return;
        }

        console.log('Video file selected:', file.name);

        // Validate file type
        if (!file.type.startsWith('video/')) {
            alert('File yang dipilih bukan video. Silakan pilih file video.');
            event.target.value = '';
            hideVideoPreview();
            return;
        }

        // Validate file size (100MB)
        const maxSize = 100 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 100MB.');
            event.target.value = '';
            hideVideoPreview();
            return;
        }

        videoFile = file;

        // Create file URL for preview
        try {
            if (videoUrl) {
                URL.revokeObjectURL(videoUrl);
            }
            videoUrl = URL.createObjectURL(file);
        } catch (error) {
            console.error('❌ Failed to create object URL:', error);
            alert('Gagal memproses file video.');
            hideVideoPreview();
            return;
        }

        // Setup video preview
        const videoPreview = document.getElementById('videoPreview');
        videoPreview.src = videoUrl;

        // Show file information
        const fileSize = (file.size / (1024 * 1024)).toFixed(2);
        document.getElementById('videoFileInfo').innerHTML = `
            <strong>File:</strong> ${file.name}<br>
            <strong>Ukuran:</strong> ${fileSize} MB<br>
            <strong>Tipe:</strong> ${file.type}
        `;

        // Auto-fill title if empty
        const titleInput = document.getElementById('videoTitle');
        if (!titleInput.value) {
            const fileName = file.name.replace(/\.[^/.]+$/, "");
            titleInput.value = fileName;
        }

        // Show video preview
        document.getElementById('videoUploadContent').style.display = 'none';
        document.getElementById('videoPreviewContent').style.display = 'block';
        document.getElementById('thumbnailSection').style.display = 'block';

        // Setup video element for thumbnail generation
        setupVideoForThumbnail();
    });

    // Manual thumbnail upload handler
    document.getElementById('thumbnailFileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran thumbnail terlalu besar! Maksimal 5MB.');
                this.value = '';
                return;
            }

            console.log('Manual thumbnail selected');

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumbnailImage').src = e.target.result;
                document.getElementById('thumbnailData').value = e.target.result;
                document.getElementById('thumbnailType').value = 'manual';

                // Update UI
                thumbnailType = 'manual';
                document.getElementById('thumbnailBadge').className = 'manual-badge';
                document.getElementById('thumbnailBadge').textContent = 'MANUAL';
                document.getElementById('thumbnailControls').style.display = 'none';

                showThumbnailDisplay();
                updateSaveButton();

                console.log('✅ Manual thumbnail uploaded');
            };
            reader.readAsDataURL(file);
        }
    });

    function setupVideoForThumbnail() {
        const videoPreview = document.getElementById('videoPreview');

        videoPreview.onloadedmetadata = () => {
            videoDuration = videoPreview.duration;

            if (videoDuration > 0 && videoPreview.videoWidth > 0 && videoPreview.videoHeight > 0) {
                // Update slider
                const slider = document.getElementById('thumbnailTime');
                slider.max = Math.floor(videoDuration);
                slider.value = Math.min(2, Math.floor(videoDuration / 4));
                document.getElementById('maxTime').textContent = Math.floor(videoDuration) + 's';
                document.getElementById('currentTime').textContent = slider.value + 's';

                // Generate auto thumbnail
                setTimeout(() => {
                    generateAutoThumbnail();
                }, 800);
            } else {
                showFallbackThumbnail();
            }
        };

        videoPreview.onerror = (e) => {
            showFallbackThumbnail();
        };
    }

    function handleThumbnailClick() {
        if (!videoFile) {
            // No video selected, show message
            alert('Upload video terlebih dahulu');
            return;
        }

        // Allow manual thumbnail upload
        document.getElementById('thumbnailFileInput').click();
    }

    function generateAutoThumbnail() {
        if (isGeneratingThumbnail || !videoFile) return;

        isGeneratingThumbnail = true;

        const time = parseFloat(document.getElementById('thumbnailTime').value);
        const video = document.getElementById('videoPreview');
        const canvas = document.getElementById('thumbnailCanvas');
        const ctx = canvas.getContext('2d');

        // Check video readiness
        if (video.readyState < 2) {
            setTimeout(() => {
                isGeneratingThumbnail = false;
                generateAutoThumbnail();
            }, 1000);
            return;
        }

        const originalTime = video.currentTime;
        let seekCompleted = false;

        const captureFrame = () => {
            if (seekCompleted) return;
            seekCompleted = true;

            try {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                canvas.toBlob((blob) => {
                    // Restore original time
                    video.currentTime = originalTime;

                    if (blob && blob.size > 0) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            document.getElementById('thumbnailImage').src = reader.result;
                            document.getElementById('thumbnailData').value = reader.result;
                            document.getElementById('thumbnailType').value = 'auto';

                            // Update UI
                            thumbnailType = 'auto';
                            document.getElementById('thumbnailBadge').className = 'auto-badge';
                            document.getElementById('thumbnailBadge').textContent = 'AUTO';
                            document.getElementById('thumbnailControls').style.display = 'block';

                            showThumbnailDisplay();
                            updateSaveButton();

                            isGeneratingThumbnail = false;
                        };
                        reader.readAsDataURL(blob);
                    } else {
                        showFallbackThumbnail();
                    }
                }, 'image/jpeg', 0.95); // High quality JPEG

            } catch (error) {
                video.currentTime = originalTime;
                showFallbackThumbnail();
            }
        };

        // Seek to time and capture
        if (Math.abs(video.currentTime - time) < 0.1) {
            captureFrame();
        } else {
            video.addEventListener('seeked', function onSeeked() {
                video.removeEventListener('seeked', onSeeked);
                setTimeout(captureFrame, 100);
            });

            video.currentTime = time;

            setTimeout(() => {
                if (!seekCompleted) {
                    captureFrame();
                }
            }, 2000);
        }
    }

    function showFallbackThumbnail() {
        const canvas = document.getElementById('thumbnailCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 640;
        canvas.height = 360;

        // Create gradient background
        const gradient = ctx.createLinearGradient(0, 0, 640, 360);
        gradient.addColorStop(0, '#667eea');
        gradient.addColorStop(1, '#764ba2');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, 640, 360);

        // Add video icon
        ctx.fillStyle = 'white';
        ctx.font = 'bold 48px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('🎬', 320, 150);

        ctx.font = 'bold 20px Arial';
        ctx.fillText('Video Thumbnail', 320, 200);

        canvas.toBlob((blob) => {
            if (blob) {
                const reader = new FileReader();
                reader.onload = () => {
                    document.getElementById('thumbnailImage').src = reader.result;
                    document.getElementById('thumbnailData').value = reader.result;

                    showThumbnailDisplay();
                    updateSaveButton();

                    isGeneratingThumbnail = false;
                };
                reader.readAsDataURL(blob);
            }
        }, 'image/jpeg', 0.95); // High quality JPEG fallback
    }

    function showThumbnailDisplay() {
        document.getElementById('thumbnailWaiting').style.display = 'none';
        document.getElementById('thumbnailDisplay').style.display = 'flex';
    }

    function updateThumbnailFromSlider() {
        const time = document.getElementById('thumbnailTime').value;
        document.getElementById('currentTime').textContent = time + 's';

        // Debounce thumbnail generation
        clearTimeout(window.thumbnailTimeout);
        window.thumbnailTimeout = setTimeout(() => {
            if (thumbnailType === 'auto') {
                generateAutoThumbnail();
            }
        }, 500);
    }

    function regenerateThumbnail() {
        if (thumbnailType === 'auto') {
            generateAutoThumbnail();
        }
    }

    function removeThumbnail(event) {
        event.stopPropagation();

        document.getElementById('thumbnailFileInput').value = '';
        document.getElementById('thumbnailData').value = '';
        document.getElementById('thumbnailDisplay').style.display = 'none';
        document.getElementById('thumbnailControls').style.display = 'none';
        document.getElementById('thumbnailWaiting').style.display = 'flex';

        updateSaveButton();
    }

    function removeVideo(event) {
        event.stopPropagation();

        // Clean up
        if (videoUrl) {
            URL.revokeObjectURL(videoUrl);
        }

        hideVideoPreview();
        updateSaveButton();

        // Reset variables
        videoFile = null;
        videoUrl = null;
        videoDuration = 0;
        isGeneratingThumbnail = false;
        thumbnailType = 'auto';
    }

    function hideVideoPreview() {
        document.getElementById('videoFile').value = '';
        document.getElementById('thumbnailFileInput').value = '';
        document.getElementById('thumbnailData').value = '';
        document.getElementById('videoUploadContent').style.display = 'block';
        document.getElementById('videoPreviewContent').style.display = 'none';
        document.getElementById('thumbnailSection').style.display = 'none';
        document.getElementById('thumbnailDisplay').style.display = 'none';
        document.getElementById('thumbnailControls').style.display = 'none';
        document.getElementById('thumbnailWaiting').style.display = 'flex';
    }

    function updateSaveButton() {
        const hasVideo = videoFile !== null;
        const hasThumbnail = document.getElementById('thumbnailData').value !== '';

        document.getElementById('saveBtn').disabled = !(hasVideo && hasThumbnail);
    }

    // Handle form submission with button loading only
    document.getElementById('videoForm').addEventListener('submit', function(event) {
        const fileInput = document.getElementById('videoFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('Silakan pilih file video terlebih dahulu.');
            event.preventDefault();
            return;
        }

        if (!document.getElementById('thumbnailData').value) {
            alert('Tunggu thumbnail selesai dibuat atau upload thumbnail manual.');
            event.preventDefault();
            return;
        }

        // Show loading in button only
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Uploading...';
    });

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Reset form when modal is closed
    document.getElementById('addVideoModal').addEventListener('hidden.bs.modal', function() {
        if (videoUrl) {
            URL.revokeObjectURL(videoUrl);
        }

        document.getElementById('videoForm').reset();
        hideVideoPreview();
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Simpan Video';
        document.getElementById('thumbnailData').value = '';
        document.getElementById('thumbnailType').value = 'auto';

        videoFile = null;
        videoUrl = null;
        videoDuration = 0;
        isGeneratingThumbnail = false;
        thumbnailType = 'auto';
    });

    // Drag and drop functionality
    const videoUploadWrapper = document.getElementById('videoUploadWrapper');

    videoUploadWrapper.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        videoUploadWrapper.style.borderColor = '#696cff';
        videoUploadWrapper.style.backgroundColor = '#f4f5ff';
    });

    videoUploadWrapper.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        videoUploadWrapper.style.borderColor = '#d9dee3';
        videoUploadWrapper.style.backgroundColor = '#f8f9fa';
    });

    videoUploadWrapper.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        videoUploadWrapper.style.borderColor = '#d9dee3';
        videoUploadWrapper.style.backgroundColor = '#f8f9fa';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('videoFile').files = files;
            document.getElementById('videoFile').dispatchEvent(new Event('change'));
        }
    });

    // Initialize
</script>