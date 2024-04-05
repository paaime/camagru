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
                        <div class="wrapper wrapper-right">
                            <a href="<?= $post["image_url"] ?>" download="<?= basename($post["image_url"]) ?>"
                                class="download-button">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z"
                                        fill="currentColor" />
                                    <path
                                        d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                            <a target="_blank"
                                href="https://twitter.com/intent/tweet?text=Hey ! Check my new image made on Camagru : <?= ROOT ?>/<?= $post["image_url"] ?>">
                                <svg width="20" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 6.12549 15.0077 6.24919 15.0227 6.37063L8.08261 9.84066C7.54305 9.32015 6.80891 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15C6.80891 15 7.54305 14.6798 8.08261 14.1593L15.0227 17.6294C15.0077 17.7508 15 17.8745 15 18C15 19.6569 16.3431 21 18 21C19.6569 21 21 19.6569 21 18C21 16.3431 19.6569 15 18 15C17.1911 15 16.457 15.3202 15.9174 15.8407L8.97733 12.3706C8.99229 12.2492 9 12.1255 9 12C9 11.8745 8.99229 11.7508 8.97733 11.6294L15.9174 8.15934C16.457 8.67985 17.1911 9 18 9Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
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
            <!-- <div class="pagination">
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
            </div> -->
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
        let currentPage = <?= $currentPage ?>;
        let totalPages = <?= $totalPages ?>;
        let loading = false;

        function updateDOM() {
            let likeButtons = document.querySelectorAll('.like-button');
            let showCommentsButtons = document.querySelectorAll('.show-comment-button');
            let commentForms = document.querySelectorAll('.comment-form');

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
        }

        updateDOM();

        window.addEventListener('scroll', () => {
            if (loading) return;
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                if (currentPage < totalPages) {
                    loadMorePosts(currentPage + 1);
                }
            }
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

        function loadMorePosts(page) {
            loading = true;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `gallery/loadPosts?page=${page}`);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    let posts = JSON.parse(xhr.responseText);
                    let galleryWrapper = document.querySelector('.gallery-wrapper .posts');
                    Object.values(posts).forEach(post => {
                        let newPost = document.createElement('div');
                        newPost.classList.add('card', 'post');
                        newPost.setAttribute('data-post-id', post.post_id);
                        newPost.innerHTML = `
                            <div class="header user-profile">
                                <div class="profile-icon">
                                    <p>${post.username[0]}</p>
                                </div>
                                <p class="username">${post.username}</p>
                                <p class="post-date">${post.created_at}</p>
                            </div>
                            <img class="content" src="${post.image_url}" class="card-img-top" alt="...">
                            <div class="footer">
                                <div class="wrapper">
                                    <svg data-post-id="${post.post_id}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="${post.user_has_liked ? 'red' : 'none'}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="like-button">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                    <span class="likes-number">${post.likes}</span>
                                </div>
                                <div class="wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="show-comment-button">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38
                                        0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                    <span class="comments-number">${post.comments.length}</span>
                                </div>
                                <div class="wrapper wrapper-right">
                                    <a href="${post.image_url}" download="${post.image_url}"
                                        class="download-button">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z"
                                                fill="currentColor" />
                                            <path
                                                d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z"
                                                fill="currentColor" />
                                        </svg>
                                    </a>
                                    <a
                                        target="_blank" href="https://twitter.com/intent/tweet?text=Hey ! Check my new image made on Camagru : <?= ROOT ?>/${post.image_url}">
                                        <svg width="20" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 6.12549 15.0077 6.24919 15.0227 6.37063L8.08261 9.84066C7.54305 9.32015 6.80891 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15C6.80891 15 7.54305 14.6798 8.08261 14.1593L15.0227 17.6294C15.0077 17.7508 15 17.8745 15 18C15 19.6569 16.3431 21 18 21C19.6569 21 21 19.6569 21 18C21 16.3431 19.6569 15 18 15C17.1911 15 16.457 15.3202 15.9174 15.8407L8.97733 12.3706C8.99229 12.2492 9 12.1255 9 12C9 11.8745 8.99229 11.7508 8.97733 11.6294L15.9174 8.15934C16.457 8.67985 17.1911 9 18 9Z"
                                                fill="currentColor" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="comments">
                                <p class="title">Comments</p>
                                <div class="list">
                                    ${post.comments.map(comment => `
                                        <div class="comment">
                                            <div class="profile-icon">
                                                <p>${comment.comment_username[0]}</p>
                                            </div>
                                            <div class="comment-text">
                                                <p class="username">${comment.comment_username}</p>
                                                <p class="text">${comment.comment_text}</p>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                                <form class="comment-form" data-post-id="${post.post_id}">
                                    <input name="comment" placeholder="Add a comment" />
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="submit-plus">
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        `;
                        galleryWrapper.appendChild(newPost);
                    });
                    currentPage = page;
                    loading = false;
                    updateDOM();
                } else {
                    console.error('Error loading more posts');
                    loading = false;
                }
            };
            xhr.send();
        }

    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>