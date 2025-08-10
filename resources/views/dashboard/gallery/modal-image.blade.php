  <style>
      .hover-red:hover {
          color: #dc3545;
      }

      /* Image Upload Styles */
      .image-upload-wrapper {
          border: 2px dashed #d9dee3;
          border-radius: 0.5rem;
          padding: 0.2rem 0.2rem;
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


  <!-- Modal to Add Image -->
  <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addImageModalLabel">Tambah Gambar</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="type" value="gambar">
                      <!-- Image Title -->
                      <div class="mb-3">
                          <label for="imageTitle" class="form-label">Nama Gambar</label>
                          <input type="text" class="form-control" id="imageTitle" name="name"
                              placeholder="Gambar Title" required>
                      </div>

                      <div class="mb-4">
                          <label class="form-label fw-bolder" for="gambar">Gambar</label>

                          <input type="file" class="form-control" id="gambar" name="path" accept="image/*"
                              style="display: none;" required />

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

                      <!-- Save Button -->
                      <button type="submit" class="btn btn-primary mt-3">Save</button>
                  </form>
              </div>
          </div>
      </div>
  </div>


  <script>
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
      // Global function for removing image
      function removeImage(event) {
          event.stopPropagation();
          document.getElementById('gambar').value = '';
          document.getElementById('uploadContent').style.display = 'block';
          document.getElementById('previewContent').style.display = 'none';
      }
  </script>
