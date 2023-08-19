<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Tasks</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        main {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 2px 2px #f0f0f0;
            border-radius: 8px;
        }

        form {
            text-align: center;
            margin: 20px 0;
        }

        select {
            width: 80%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .user-card {
            max-width: 600px;
            margin: 10px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .user-card h2 {
            margin: 10px 0;
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }

        .user-card h4,
        .user-card h5 {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        p {
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h1>Find Users for your Project</h1>
    <main>
        <form action="/findusers" method="POST">
            <h4>
                Please enter the role you are looking for your project:
            </h4>
            <select name="Role">
                <option value="" disabled selected hidden>Please choose a role...</option>
                <option value="Frontend Developer">Frontend Developer</option>
                <option value="Backend Developer">Backend Developer</option>
                <option value="Designer">Designer</option>
                <option value="Project Manager">Project Manager</option>
                <option value="QA">QA</option>
            </select>
            <button type="submit"> Submit </button>
        </form>
        <a href="feed">Go back to feed</a>
    </main>

    <?php if (isset($users_with_role) && $users_with_role !== null && is_array($users_with_role)) : ?>
        <?php foreach ($users_with_role as $user) : ?>
            <div class="user-card">
                <h2 class="name"><?php echo $user['Name']; ?></h2>
                <h4><?php echo $user['Email']; ?></h4>
                <h5><?php echo $user['Bio']; ?></h5>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php
    if (isset($error) && $error === 'no_role_specified') {
        echo "<p style='color: red;'>Please select a role to view users.</p>";
    }
    ?>

</body>

</html>