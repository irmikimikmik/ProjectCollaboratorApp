<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #feed-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .post {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 2px #f0f0f0;
        }

        .post h2 {
            margin-top: 0;
        }

        .post p {
            margin: 10px 0;
        }

        .post small {
            color: #777;
        }

        .action-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        #delete-project-btn {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div id="feed-container">
        <h1>Here are your posts, <?= $user_name ?>!</h1>

        <div id="feed">
            <?php foreach ($posts as $post) : ?>
                <div class="post">
                    <h2><?php echo $post['Title']; ?></h2>
                    <p><?php echo $post['Description']; ?></p>
                    <small>Posted on: <?php echo $post['Time']; ?></small>
                    <form action="deletepost" method="POST">
                        <input type="text" name="ProjectID" style="display: none;" value=<?php echo $post['ProjectID'] ?>>
                        <button class="action-button" id="delete-project-btn">Delete Project</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <a href="feed">Go back to feed</a>
        </div>

    </div>
</body>

</html>