<?php include('conn.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="..." crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Blog</title>
</head>
<body>
    <!-- navigation -->
     <?php include('navbar.php')?>
     <!-- banner -->
    <section class="banner">
        <div class="bannerThought" style="font-size: 1.3rem;">
            <h1 style="font-size: 3rem;"><span>Discover</span> Monitor & Share Engaging Content</h1>
            <p>Welcome to our blog, where we delve into the latest trends, insights, and stories across various domains. From tech innovations and lifestyle tips to thought-provoking articles and creative inspirations, we bring you content that matters. Join us on this journey of discovery, and let's explore the world together.</p>
            <?php if (isset($_COOKIE['user_email'])): ?>
                <a href="post_blog.php" class="btn">Post Blog</a>
            <?php endif; ?>
        </div>
        <div class="bannerImage">
            <img src="blog.png" alt="Not Found">
        </div>
    </section>
    <!-- recentBlog -->
    <?php include('recentBlogs.php')?>
    <!-- contactus -->
    <h1 class="heading" id="contact">Contact Us </h1>
    <?php include('contact.php')?>
    <!-- about -->
    <div class="about" id="about">
        <h1 class="heading">About Us</h1>
        <div class="aboutContent">
        <p>Our mission is to provide valuable insights and inspiration through our blog. We are dedicated to delivering high-quality content that spans a diverse range of topics, including technology, lifestyle, and creativity. Whether you're seeking the latest industry trends, practical tips for enhancing your daily routines, or deep dives into thought-provoking subjects, our blog strives to be your trusted resource. Join our community and embark on a journey of discovery with us, as we explore and share meaningful perspectives to enrich your life.</p>
         </div>
</div>

</body>
    <?php include('footer.php'); ?>
</html>