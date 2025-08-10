  <!-- Modal to Add YouTube Video -->
  <div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addVideoModalLabel">Tambah Video YouTube</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Form to add YouTube video -->
                  <form method="POST" action="{{ route('gallery.store') }}">
                      @csrf
                      <input type="hidden" name="type" value="video">
                      <!-- Video Title -->
                      <div class="mb-3">
                          <label for="videoTitle" class="form-label">Judul Video</label>
                          <input type="text" class="form-control" id="videoTitle" name="name"
                              placeholder="Video Title" required>
                      </div>

                      <!-- YouTube URL -->
                      <div class="mb-3">
                          <label for="youtubeUrl" class="form-label">URL YouTube</label>
                          <div class="input-group">
                              <input type="url" class="form-control" id="youtubeUrl" name="path"
                                  placeholder="https://www.youtube.com/watch?v=VIDEO_ID" required>
                              <button type="button" class="btn btn-primary" id="searchVideoBtn">Search</button>
                          </div>
                      </div>

                      <!-- Loading Spinner -->
                      <div id="loadingSpinner" style="display:none; text-align:center;">
                          <div class="spinner-border" role="status">
                              <span class="visually-hidden">Loading...</span>
                          </div>
                          <p>Loading Video...</p>
                      </div>

                      <!-- Video Embed Container (Preview) -->
                      <div id="videoEmbedContainer" class="mt-3">
                          <!-- Video iframe will appear here -->
                      </div>

                      <!-- Save Button -->
                      <button type="submit" class="btn btn-primary mt-3">Save</button>
                  </form>
              </div>
          </div>
      </div>
  </div>


  <script>
      document.getElementById('searchVideoBtn').addEventListener('click', function() {
          var youtubeUrl = document.getElementById('youtubeUrl').value;

          // Check if URL is valid
          if (!youtubeUrl) {
              alert("Please provide the YouTube URL.");
              return;
          }

          // Extract YouTube video ID from the URL
          var videoId = extractVideoId(youtubeUrl);

          if (!videoId) {
              alert("Invalid YouTube URL.");
              return;
          }

          // Show loading spinner inside the modal
          document.getElementById('loadingSpinner').style.display = 'block'; // Show the spinner

          // Clear previous iframe (if any)
          document.getElementById('videoEmbedContainer').innerHTML = '';

          // Create an iframe for the video
          var videoEmbed = `
        <iframe width="100%" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    `;

          // After 1 second, hide the loading spinner and show the iframe
          setTimeout(function() {
              document.getElementById('loadingSpinner').style.display = 'none'; // Hide the spinner
              document.getElementById('videoEmbedContainer').innerHTML = videoEmbed; // Display the video
          }, 1000);
      });

      // Function to extract YouTube video ID from URL
      function extractVideoId(url) {
          const youtubeRegex =
              /(?:https?:\/\/(?:www\.)?youtu\.be\/|(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)))([a-zA-Z0-9_-]{11})/;
          const match = url.match(youtubeRegex);
          return match ? match[1] : null; // Return the video ID or null if no match
      }
  </script>
