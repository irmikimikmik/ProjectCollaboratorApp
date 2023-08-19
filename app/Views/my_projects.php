<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        #myprojects-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #f4f4f4;
        }

        #filter-container {
            width: 80%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        #filter-container h3 {
            margin: 0;
            padding-bottom: 10px;
        }

        #filter-container label {
            margin-right: 10px;
        }

        #myprojects {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
        }

        .project-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .project-card:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
        }

        .project-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }

        .feed-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .feed-button:hover {
            background-color: #0056b3;
        }

        button[type="submit"] {
            padding: 5px 10px;
            border: none;
            background-color: #dc3545;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div id="myprojects-container">
        <div id="filter-container">
            <form action="/filter_projects" method="post">
                <h3>Filter by Status:</h3>
                <input type="checkbox" name="open" value="on">
                <label for="open">Open</label>
                <input type="checkbox" name="in_progress" value="on">
                <label for="in_progress">In progress</label>
                <input type="checkbox" name="completed" value="on">
                <label for="completed">Completed</label>
                <button type="submit">Apply Filter</button>
            </form>
        </div>
        <a href="/feed" class="feed-button">Go to Feed</a>
        <div id="myprojects">
            <?php foreach ($projects as $project) : ?>
                <div class="project-card">
                    <div class="project-info">
                        <div class="label">Project Name:</div>
                        <h2><?php echo $project['Name']; ?></h2>
                    </div>
                    <div class="project-info">
                        <div class="label">Progress:</div>
                        <h2><?php echo $project['Status']; ?></h2>
                    </div>
                    <div class="project-info">
                        <div class="label">Description:</div>
                        <h4><?php echo $project['Description']; ?></h4>
                    </div>
                    <div class="project-info">
                        <div class="label">Team Name:</div>
                        <h5><?php echo $project['TeamName']; ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>