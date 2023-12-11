<?php

/**
 * signup class
 */
class Camera
{
    use Controller;

    public function index()
    {
        is_logged_in();
        $data = [];

        $posts = new Post;

        $posts = $posts->where(['user_id' => $_SESSION['USER']->id]);

        $data['posts'] = $posts;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return $this->newPost();
        }

        $this->view('camera', $data);
    }

    public function newPost()
    {
        if (!is_logged_in_request()) {
            http_response_code(400);
            return;
        }

        if (isset($_POST['webcamImage']) && isset($_POST['superposeImage'])) {
            try {
                // Retrieve the captured image and superpose image URL from the FormData
                $webcamImage = $_POST['webcamImage'];
                $superposeImage = $_POST['superposeImage'];

                $superposeImagePath = "assets/images/alpha_images/$superposeImage.png";

                // Check if the superpose image is valid
                if (!file_exists($superposeImagePath) || exif_imagetype($superposeImagePath) !== IMAGETYPE_PNG) {
                    http_response_code(400);
                    echo 'Superpose image is not invalid';
                    return;
                }

                // Check if the webcam image is valid
                $fileInfo = getimagesize($webcamImage);

                if ($fileInfo === false || !in_array($fileInfo['mime'], ['image/jpeg', 'image/png'])) {
                    http_response_code(400);
                    echo "Webcam image is invalid";
                    return;
                }

                if (strlen(file_get_contents($webcamImage)) > 3000000) {
                    http_response_code(400);
                    echo "Webcam image is too large";
                    return;
                }

                // Load the webcam image
                if ($fileInfo['mime'] === 'image/jpeg') {
                    $baseImage = imagecreatefromjpeg($webcamImage);
                } else {
                    $baseImage = imagecreatefrompng($webcamImage);
                }

                // Load the superpose image
                $superposeImage = imagecreatefrompng($superposeImagePath);

                // Check if the images were loaded successfully
                if (!$baseImage || !$superposeImage) {
                    echo json_encode(['success' => false]);
                    http_response_code(400);
                    return;
                }

                // Get dimensions of the images
                $superposeWidth = imagesx($superposeImage);
                $superposeHeight = imagesy($superposeImage);

                // Calculate position to superpose the images (you may need to adjust these values)
                $x = ($fileInfo[0] - $superposeWidth) / 2;
                $y = ($fileInfo[1] - $superposeHeight) / 2;

                // Calculate new dimensions to fit the superposed image within the bounds
                $newWidth = min($superposeWidth, $fileInfo[0]);
                $newHeight = min($superposeHeight, $fileInfo[1]);


                // Resize the superpose image proportionally
                imagecopyresampled($baseImage, $superposeImage, 0, 0, 0, 0, $newWidth, $newHeight, $superposeWidth, $superposeHeight);

                // Save the superposed image
                $uniqueId = uniqid();
                $finalImagePath = "post_images/$uniqueId.png";
                imagepng($baseImage, $finalImagePath);

                $post = new Post;

                $post->insert([
                    'image_url' => $finalImagePath,
                    'user_id' => $_SESSION['USER']->id,
                    'likes' => 0
                ]);

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                http_response_code(400);
                return;
            }
        } elseif (isset($_FILES['uploadedImage']['tmp_name']) && isset($_POST['superposeImage'])) {
            try {
                // Handle file upload
                $uploadedImage = $_FILES['uploadedImage']['tmp_name'];
                $superposeImage = $_POST['superposeImage'];


                $superposeImagePath = "assets/images/alpha_images/$superposeImage.png";

                // Check if the superpose image is valid
                if (!file_exists($superposeImagePath) || exif_imagetype($superposeImagePath) !== IMAGETYPE_PNG) {
                    http_response_code(400);
                    echo 'Superpose image is not invalid';
                    return;
                }


                // Check if the uploaded file is a valid image
                $fileInfo = getimagesize($uploadedImage);

                if ($fileInfo === false || !in_array($fileInfo['mime'], ['image/jpeg'])) {
                    http_response_code(400);
                    echo "Uploaded image is invalid";
                    return;
                }

                // check if the uploaded file is not too large
                if ($_FILES['uploadedImage']['size'] > 1000000) {
                    http_response_code(400);
                    echo "Uploaded image is too large";
                    return;
                }

                // Load the uploaded image
                $baseImage = imagecreatefromjpeg($uploadedImage);

                // Load the superpose image
                $superposeImage = imagecreatefrompng($superposeImagePath);

                // Check if the images were loaded successfully
                if (!$baseImage || !$superposeImage) {
                    echo json_encode(['success' => false]);
                    http_response_code(400);
                    return;
                }

                // Get dimensions of the images
                $superposeWidth = imagesx($superposeImage);
                $superposeHeight = imagesy($superposeImage);

                // Calculate position to superpose the images (you may need to adjust these values)
                $x = ($fileInfo[0] - $superposeWidth) / 2;
                $y = ($fileInfo[1] - $superposeHeight) / 2;

                // Calculate new dimensions to fit the superposed image within the bounds
                $newWidth = min($superposeWidth, $fileInfo[0]);
                $newHeight = min($superposeHeight, $fileInfo[1]);


                // Resize the superpose image proportionally
                imagecopyresampled($baseImage, $superposeImage, 0, 0, 0, 0, $newWidth, $newHeight, $superposeWidth, $superposeHeight);
                // Save the superposed image
                $uniqueId = uniqid();
                $finalImagePath = "post_images/$uniqueId.png";
                imagepng($baseImage, $finalImagePath);

                $post = new Post;

                $post->insert([
                    'image_url' => $finalImagePath,
                    'user_id' => $_SESSION['USER']->id,
                    'likes' => 0
                ]);

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                http_response_code(400);
                return;
            }

        } else {
            http_response_code(400);
            return;
        }

    }

    public function deletePost()
    {
        is_logged_in();

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete-post'])) {
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['USER']->id; // Get the ID of the currently logged-in user

            // Check if the user is the owner of the post
            $post = new Post;
            $postData = $post->first(['id' => $post_id]);

            if ($postData && $postData->user_id == $user_id && $postData->id == $post_id) {
                // User is the owner of the post; proceed with deletion

                // Delete comments associated with the post
                $comment = new Comment;
                $comment->deleteCommentsByPostId($post_id);

                // Delete the post
                $deleted = $post->delete($post_id);

                // Deletion successful
                header("Location: " . ROOT . "/camera"); // Redirect to the camera view
                exit();

            } else {
                header("Location: " . ROOT . "/camera"); // Redirect to the camera view
                exit();
            }
        }
    }

}