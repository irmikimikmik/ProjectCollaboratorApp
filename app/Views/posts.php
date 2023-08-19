<!DOCTYPE html>
<html lang="en">

<head>
    <title>Post Ideas Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        main {
            text-align: center;
        }

        form {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        input {
            display: block;
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .role-list {
            display: flex;
            flex-wrap: wrap;
        }
        .role-checkbox {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
        }

    </style>
</head>

<body>
    <main>
        <form action="/posts" method="POST">
            <h1>Add a new post, <?= $userName ?> </h1>
            <input type="text" name="Title" placeholder="Title">
            <input type="text" name="Description" placeholder="Description">
            <input type="text" name="TeamName" placeholder="Team Name">

            <div>
                <?php foreach ($allRoles as $role) : ?>
                    <label class="role-checkbox">
                        <input type="checkbox" name="selectedRoles[]" value="<?php echo $role['RoleName']; ?>">
                        <?php echo $role['RoleName']; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <?php
                if(isset($error) && $error === 'missing_field') {
                    echo "<p style='color: red;'>Please fill in all the fields.</p>";
                }
            ?>

            <button type="submit">Submit</button>
        </form>
        <a href="feed">Go back to feed</a>
    </main>
</body>

</html>