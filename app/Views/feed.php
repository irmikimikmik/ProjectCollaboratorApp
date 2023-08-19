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

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .action-button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        #add-project-btn {
            background-color: #80669d;
        }

        #find-users-btn {
            background-color: #007bff;
        }

        #my-tasks-btn {
            background-color: #28a745;
        }
       
        #my-projects-btn {
            background-color: #ffbd03;
        }

        #my-profile-btn {
            background-color: #FF8C00;
        }

        #my-posts-btn {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div id="feed-container">
        <h1>Welcome back, <?= $userName ?>!</h1>
        <div class="action-buttons">
            <a href="/posts">
                <button class="action-button" id="add-project-btn">Create a Project</button>
            </a>
            <a href="/findusers">
                <button class="action-button" id="find-users-btn">Find Users</button>
            </a>
            <a href="/tasks">
                <button class="action-button" id="my-tasks-btn">My Tasks</button>
            </a>
            <a href="/myprojects">
                <button class="action-button" id="my-projects-btn">My Projects</button>
            </a>
            <a href="/myprofile">
                <button class="action-button" id="my-profile-btn">My Profile</button>
            </a>
            <a href="/myposts">
                <button class="action-button" id="my-posts-btn">My Posts</button>
            </a>
        </div>

        <div id="role-filter">
            <form action="filterRoles" method="post">
                <h3>Filter by Roles Needed:</h3>
                <?php foreach ($allRoles as $role) : ?>
                    <?php
                    $isChecked = in_array($role['RoleName'], $selectedRoles) ? 'checked' : '';
                    ?>
                    <label>
                        <input type="checkbox" name="selectedRoles[]" value="<?php echo $role['RoleName']; ?>" <?php echo $isChecked; ?>>
                        <?php echo $role['RoleName']; ?>
                    </label>
                    <br>
                <?php endforeach; ?>
                <button type="submit">Apply Filter</button>
            </form>
            <br>
        </div>

        <div id="feed">
            <?php foreach ($feed as $post) : ?>
                <div class="post">
                    <h2><?php echo $post['Title']; ?></h2>
                    <p><?php echo $post['Description']; ?></p>

                    <div class="roles-needed">
                        <h4>Number of Open Positions: <?php echo $post['OpenPositions']; ?></h4>
                        <h4>Roles Needed:</h4>
                        <ul>
                            <?php $roles = explode(',', $post['RolesNeeded']); ?>
                            <?php foreach ($roles as $role) : ?>
                                <li><?php echo $role; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <small>Posted on: <?php echo $post['Time']; ?></small>
                    <small>Author: <?php echo $post['Name']; ?></small>

                </div>
            <?php endforeach; ?>
        </div>

        <?php
        if (isset($error) && $error === 'missing_field') {
            echo "<p style='color: red;'>Please select at least one role.</p>";
        }
        ?>

    </div>
</body>

</html>