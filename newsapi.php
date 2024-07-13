<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
include('conn.php'); // Database connection if needed

// Function to fetch news data from API
function fetchNewsFromAPI() {
    $url = 'https://newsdata.io/api/1/latest?apikey=pub_4833432a8f348539a5a325931c6350de60e38&q=pegasus&language=en';
    
    // Fetch data from API
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return $data['results']; // Assuming 'results' is the array of news articles
}

// Fetch news data
$news = fetchNewsFromAPI();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        .news-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Optional: for spacing around items */
            padding: 10px;
        }
        .news-card {
            width: 30%;
            background-color: #fff;
            margin: 10px; /* Adjust margin for spacing between cards */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .news-card img {
            width: 100%;
            height: 40vh;
            object-fit: cover;
        }
        .news-card h2 {
            font-size: 1.2em;
            margin: 0.5em;
        }
        .news-card p {
            margin: 0.5em;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="news-container">
        <?php foreach ($news as $article): ?>
            <div class="news-card">
                <h2><a href="<?php echo $article['link']; ?>" target="_blank"><?php echo $article['title']; ?></a></h2>
                <?php if ($article['image_url']): ?>
                    <img src="<?php echo $article['image_url']; ?>" alt="Article Image">
                <?php endif; ?>
                <p><?php echo $article['description']; ?></p>
                <p><strong>Published Date:</strong> <?php echo $article['pubDate']; ?></p>
                <p><strong>Source:</strong> <a href="<?php echo $article['source_url']; ?>" target="_blank"><?php echo $article['source_id']; ?></a></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
