<div class="recentBlogs" id="recentBlogs" >
        <h1 class="heading">Recent Blogs</h1>
        <div class="blogDiv">
            <?php
            $query = "SELECT blogs.id, blogs.title, blogs.content, blogs.image, users.firstname, blogs.created_at 
                      FROM blogs 
                      JOIN users ON blogs.email = users.email 
                      ORDER BY blogs.created_at DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                foreach ($result as $row ) {
                    echo '<div class="individualRecentBlogs">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Blog Image">';
                    echo '<div class="recentBlogContent">';
                    echo '<h3><a href="blog_detail.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h3>';
                    echo '<b>By ' . htmlspecialchars($row['firstname']) . ' on ' . date('d.m.Y', strtotime($row['created_at'])) . '</b>';
                    echo '<p>' . substr(htmlspecialchars($row['content']), 0, 150) . '...</p>';
                    
                    echo '</div>';
                    echo '</div>';
                }
            }
            else {
                echo '<b>No blog posts found.</b>';
            }
            ?>


        </div>
    </div>