<?php ob_start(); ?>
<div class="camera-wrapper">
    <div class="left">
        <div class="card card-error">
            <p></p>
            <i class="gg-close"></i>
        </div>
        <div class="video-wrapper card">
            <div class="overlay-wrapper">
                <video id="video" autoplay></video>
                <img id="overlay-image" src="" />
            </div>
            <div class="no-camera">
                <img src="<?= ROOT ?>/assets/images/camera.png" alt="No camera">
                <p>Camera not found...</p>
            </div>
        </div>
        <div class="upload-file card">
            <p>Or upload image (.jpg only)</p>
            <input type="file" id="file-input" accept=".jpg">
        </div>
        <div class="superposable-images card">
            <p>Choose an image to superpose</p>
            <div class="wrapper">
                <label><input type="radio" name="superpose" id="1" />
                    <img src="<?= ROOT ?>/assets/images/alpha_images/1.png" alt="Image 1" /></label>
                <label><input type="radio" name="superpose" id="2" /><img
                        src="<?= ROOT ?>/assets/images/alpha_images/2.png" alt="Image 2" /></label>
                <label><input type="radio" name="superpose" id="3" /><img
                        src="<?= ROOT ?>/assets/images/alpha_images/3.png" alt="Image 3" /></label>
                <label><input type="radio" name="superpose" id="4" /><img
                        src="<?= ROOT ?>/assets/images/alpha_images/4.png" alt="Image 4" /></label>
                <label><input type="radio" name="superpose" id="5" /><img
                        src="<?= ROOT ?>/assets/images/alpha_images/5.png" alt="Image 5" /></label>
            </div>
        </div>
        <button id="capture-button" disabled>Submit !</button>
    </div>
    <div class="right card">
        <p>Last posts</p>
        <div class="posts">
            <?php foreach ($data['posts'] as $post): ?>
                <div class="post">
                    <img src="<?= $post->image_url ?>" alt="">
                    <div class="footer">
                        <p>
                            <?= $post->created_at ?>
                        </p>
                        <form method="POST" action="<?= ROOT ?>/camera/deletePost">
                            <input type="hidden" name="post_id" value="<?= $post->id ?>">
                            <button type="submit" class="delete-button" name="delete-post">
                                <i class="gg-close"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<script>
    let closeBtn = document.querySelector(".card-error .gg-close");
    let popup = document.querySelector(".card-error");

    closeBtn?.addEventListener("click", () => {
        popup.style.display = "none";
    });
</script>
<script>
    var fileInput = document.getElementById('file-input');
    fileInput.addEventListener('change', function () {
        // Enable the "Capture Photo" button when a file is selected
        captureButton.disabled = !fileInput.files[0];
    });
    var superposableImages = document.querySelectorAll('input[name="superpose"]');
    superposableImages.forEach(function (image) {
        image.addEventListener('change', function () {
            // Check if there is camera access
            var video = document.getElementById('video');
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            if (canvas.toDataURL('image/png') == 'data:,' && !fileInput.files[0]) {
                // No camera access
                captureButton.disabled = true;
                return;
            }
            var selectedImage = document.querySelector('input[name="superpose"]:checked');
            if (selectedImage) {
                var overlayImage = document.getElementById('overlay-image');
                var imageId = selectedImage.id;
                overlayImage.src = '<?= ROOT ?>/assets/images/alpha_images/' + imageId + '.png'; // Update with the correct image source
                overlayImage.style.display = "inline";
            }

            captureButton.disabled = false;
        });
    });
    // Get user media (webcam) and display in the video element
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            var video = document.getElementById('video');
            video.srcObject = stream;
        })
        .catch(function (error) {
            // show the no-camera div
            var noCamera = document.querySelector('.no-camera');
            noCamera.style.display = 'flex';
            // hide the video div
            var video = document.getElementById('video');
            video.style.display = 'none';
        });

    // Capture a photo from the video stream
    var captureButton = document.getElementById('capture-button');
    captureButton.addEventListener('click', function () {
        var selectedFile = fileInput.files[0];
        if (selectedFile) {
            // Create a FormData object and append the selected file
            var formData = new FormData();
            formData.append('uploadedImage', selectedFile);
            if (document.querySelector('input[name="superpose"]:checked') == null) {
                let popup = document.querySelector(".card-error");
                popup.style.display = "flex";
                popup.querySelector("p").innerHTML = "Please select an image to superpose";
                return;
            }
            formData.append('superposeImage', document.querySelector('input[name="superpose"]:checked').id);

            // Send the captured image to the PHP script for superposition
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'camera', true); // Update with the correct controller endpoint
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    let popup = document.querySelector(".card-error");
                    popup.style.display = "flex";
                    popup.querySelector("p").innerHTML = xhr.responseText;
                }
            };
            xhr.send(formData);
        } else {
            var video = document.getElementById('video');
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Create a FormData object to send the images to PHP
            var formData = new FormData();
            formData.append('webcamImage', canvas.toDataURL('image/png'));
            if (document.querySelector('input[name="superpose"]:checked') == null) {
                let popup = document.querySelector(".card-error");
                popup.style.display = "flex";
                popup.querySelector("p").innerHTML = "Please select an image to superpose";
                return;
            }
            formData.append('superposeImage', document.querySelector('input[name="superpose"]:checked').id);

            // Send the captured images to the PHP script for superposition
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'camera', true); // Update with the correct controller endpoint
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    let popup = document.querySelector(".card-error");
                    popup.style.display = "flex";
                    popup.querySelector("p").innerHTML = xhr.responseText;
                }
            };
            xhr.send(formData);
        }

    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>