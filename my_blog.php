<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Blogs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="..." crossorigin="anonymous" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .individualBlog {
            width: 30%;
            background-color: #fff;
            height: 100%;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .individualBlog img {
            width: 100%;
            height: 40vh;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .blogContent {
            padding: 10px;
        }

        .blogContent h3,
        .blogContent p,
        .blogContent b {
            margin-bottom: 5px;
        }

        .blogContent p {
            margin-bottom: 5px;
            font-size: 23px; 
            line-height: 1.6; 
        }

        .edit-btn,
        .delete-btn {
            margin-top: 10px;
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="blogsList">
        <h1 style="text-align: center;">My Blogs</h1>
        <div class="blogDiv" id="blogContainer">
            <!-- Blog posts will be loaded here via AJAX -->
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function loadBlogs() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'load_blogs.php', true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        var blogContainer = document.getElementById('blogContainer');
                        blogContainer.innerHTML = '';

                        if (response.error) {
                            blogContainer.innerHTML = '<p>' + response.error + '</p>';
                        } else if (response.length > 0) {
                            response.forEach(function(blog) {
                                var blogDiv = document.createElement('div');
                                blogDiv.className = 'individualBlog';
                                
                                var blogImg = document.createElement('img');
                                blogImg.src = blog.image ? blog.image : 'default.jpg'; // Default image if none
                                blogImg.alt = 'Blog Image';
                                blogDiv.appendChild(blogImg);

                                var blogContent = document.createElement('div');
                                blogContent.className = 'blogContent';

                                var blogTitle = document.createElement('h3');
                                var blogTitleLink = document.createElement('a');
                                blogTitleLink.href = 'blog_detail.php?id=' + blog.id;
                                blogTitleLink.textContent = blog.title;
                                blogTitle.appendChild(blogTitleLink);
                                blogContent.appendChild(blogTitle);

                                var blogDate = document.createElement('b');
                                blogDate.textContent = 'Published on ' + new Date(blog.created_at).toLocaleDateString();
                                blogContent.appendChild(blogDate);

                                var blogText = document.createElement('p');
                                blogText.textContent = blog.content;
                                blogContent.appendChild(blogText);

                                var editBtn = document.createElement('a');
                                editBtn.href = 'edit_blog.php?id=' + blog.id;
                                editBtn.className = 'edit-btn';
                                editBtn.textContent = 'Edit';
                                blogContent.appendChild(editBtn);

                                var deleteBtn = document.createElement('a');
                                deleteBtn.href = 'delete_blog.php?id=' + blog.id;
                                deleteBtn.className = 'delete-btn';
                                deleteBtn.textContent = 'Delete';
                                blogContent.appendChild(deleteBtn);

                                blogDiv.appendChild(blogContent);
                                blogContainer.appendChild(blogDiv);
                            });
                        } else {
                            blogContainer.innerHTML = '<p>No blog posts found.</p>';
                        }
                    }
                };
                xhr.send();
            }

            loadBlogs();
        });
    </script>
</body>
</html>
