<?php ob_start(); ?>
<div class="popup-error" style="display: none; position: fixed">
    <div class="error-wrapper">
        <p></p>
    </div>
    <i class="gg-close"></i>
</div>
<div class="gallery-wrapper">
    <div class="middle-wrapper">
        <div class="posts">
            <?php foreach ($posts as $post): ?>
                <div class="card post" data-post-id="<?= $post["post_id"] ?>">
                    <div class="header user-profile">
                        <div class="profile-icon">
                            <p>
                                <?= substr($post["username"], 0, 1) ?>
                            </p>
                        </div>
                        <p class="username">
                            <?= $post["username"] ?>
                        </p>
                        <p class="post-date">
                            <?= $post["created_at"] ?>
                        </p>
                    </div>
                    <img class="content" src="<?= $post["image_url"] ?>" class="card-img-top" alt="...">
                    <div class="footer">
                        <div class="wrapper">
                            <?php if ($post['user_has_liked']): ?>
                                <svg data-post-id="<?= $post["post_id"] ?>" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="red" stroke="red" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="like-button">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            <?php else: ?>
                                <svg data-post-id="<?= $post["post_id"] ?>" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="like-button">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            <?php endif; ?>
                            <span class="likes-number">
                                <?= $post["likes"] ?>
                            </span>
                        </div>
                        <div class="wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="show-comment-button">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                </path>
                            </svg>
                            <span class="comments-number">
                                <?= count($post["comments"]) ?>
                            </span>
                        </div>
                    </div>
                    <div class="comments">
                        <p class="title">Comments</p>
                        <div class="list">
                            <?php foreach ($post["comments"] as $comment): ?>
                                <div class="comment">
                                    <div class="profile-icon">
                                        <p>
                                            <?= substr($comment["comment_username"], 0, 1) ?>
                                        </p>
                                    </div>
                                    <div class="comment-text">
                                        <p class="username">
                                            <?= $comment["comment_username"] ?>
                                        </p>
                                        <p class="text">
                                            <?= $comment["comment_text"] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <form class="comment-form" data-post-id="<?= $post["post_id"] ?>">
                            <input name="comment" placeholder="Add a comment" />
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="28"
                                    viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="submit-plus">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a class="prev card" href="?page=<?= $currentPage - 1 ?>"><i class="gg-play-track-prev"></i></a>
                <?php endif ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" <?= $i == $currentPage ? 'class="active page card"' : 'class="page card"' ?>>
                        <?= $i ?>
                    </a>
                <?php endfor ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="next card" href="?page=<?= $currentPage + 1 ?>"><i class="gg-play-track-next"></i></a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<script>
    let closeBtn = document.querySelector(".popup-error .gg-close");
    let popup = document.querySelector(".popup-error");

    closeBtn?.addEventListener("click", () => {
        popup.style.display = "none";
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let likeButtons = document.querySelectorAll('.like-button');
        let showCommentsButtons = document.querySelectorAll('.show-comment-button');
        let commentForms = document.querySelectorAll('.comment-form');
        let deleteButtons = document.querySelectorAll('.delete-post');

        showCommentsButtons.forEach(showCommentsButton => {
            showCommentsButton.addEventListener('click', () => {
                let post = showCommentsButton.closest('.post');
                let comments = post.querySelector('.comments');
                comments.classList.toggle('show');
            });
        });


        likeButtons.forEach(likeButton => {
            likeButton.addEventListener('click', () => {
                let postId = likeButton.getAttribute('data-post-id');
                likePost(postId);
            });
        });

        commentForms.forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                let postId = form.getAttribute('data-post-id');
                let commentText = form.querySelector('input[name="comment"]').value;

                addComment(postId, commentText);
            });
        });


        function likePost(postId) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'gallery/likePost'); // Assuming your controller is mapped to index.php
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // console log the response wich is a json
                    let response = JSON.parse(xhr.responseText);
                    let post = document.querySelector(`.post[data-post-id="${postId}"]`)
                    let likeButton = post.querySelector('.like-button');
                    let likeCountElement = post.querySelector('.likes-number');
                    let likeCount = parseInt(likeCountElement.textContent.replace(/\s{2,}/g, ' '));
                    if (response.success === 'add_like') {
                        likeButton.style.fill = 'red';
                        likeCountElement.textContent = `${likeCount + 1}`;
                    } else if (response.success === 'remove_like') {
                        likeButton.style.fill = 'none';
                        likeCountElement.textContent = `${likeCount - 1}`;
                    }
                } else {
                    let popup = document.querySelector(".popup-error");
                    popup.style.display = "flex";
                    if (xhr.responseText) {
                        popup.querySelector("p").innerHTML = xhr.responseText;
                    } else {
                        popup.querySelector("p").innerHTML = 'An error occured';
                    }
                }
            };
            xhr.send(`post_id=${postId}`);
        }

        function addComment(postId, commentText) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'gallery/addComment');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // remove the comment from the input
                    let form = document.querySelector(`.comment-form[data-post-id="${postId}"]`);
                    form.querySelector('input[name="comment"]').value = '';
                    // add the comment to the UI
                    let response = JSON.parse(xhr.responseText);
                    let post = document.querySelector(`.post[data-post-id="${postId}"]`)
                    let postCountElement = post.querySelector('.comments-number');
                    let postCount = parseInt(postCountElement.textContent.replace(/\s{2,}/g, ' '));
                    let comments = post.querySelector('.comments .list');
                    let comment = document.createElement('div');
                    comment.classList.add('comment');
                    comment.innerHTML = `
                        <div class="profile-icon">
                            <p>${response.username[0]}</p>
                        </div>
                        <div class="comment-text">
                            <p class="username">${response.username}</p>
                            <p class="text">${response.comment}</p>
                        </div>
                    `;
                    comments.appendChild(comment);
                    postCountElement.textContent = `${postCount + 1}`;
                } else {
                    let popup = document.querySelector(".popup-error");
                    popup.style.display = "flex";
                    if (xhr.responseText) {
                        popup.querySelector("p").innerHTML = xhr.responseText;
                    } else {
                        popup.querySelector("p").innerHTML = 'An error occured';
                    }
                }
            };
            xhr.send(`post_id=${postId}&comment=${encodeURIComponent(commentText)}`);
        }

    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>