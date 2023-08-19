<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Tasks and Progress</title>
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
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 2px 2px #f0f0f0;
            border-radius: 8px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        form h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        input {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            display: block;
            width: 30%;
            padding: 10px;
            background-color: #007bff;
            margin-bottom: 10px;
            margin-left: auto;
            margin-right: auto;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }

        main h2 {
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        main p {
            margin: 0;
            font-size: 16px;
        }

        main small {
            color: #777;
        }
    </style>
</head>

<body>
    <h1>My Tasks</h1>
    <main>
        <form action="/tasks_filter" method="GET">
            <h4>
                Please enter the role you want to see your tasks for:
            </h4>
            <select name="Role">
                <option value="All">All Roles</option>
                <option value="Frontend Developer">Frontend Developer</option>
                <option value="Backend Developer">Backend Developer</option>
                <option value="Designer">Designer</option>
                <option value="Project Manager">Project Manager</option>
                <option value="QA">QA</option>
            </select>
            <h4>
                Please enter what type of tasks you want to see:
            </h4>
            <select name="TaskType">
                <option value="All">All</option>
                <option value="Bug">Bug</option>
                <option value="Feature">Feature</option>
                <option value="Security">Security</option>
                <option value="Testing">Testing</option>
            </select>
            <br>
            <h4>
                Please check if you want to see how these tasks are distributed among your projects:
            </h4>
            <input type="checkbox" id="showDistribution" name="showDistribution" value="showDistribution">
            <br>
            <h4>
                Please check if you want to see your progress in each project:
            </h4>
            <input type="checkbox" id="showProgress" name="showProgress" value="showProgress">
            <br>
            <h4>
                Please check if you want to see how all your tasks are distributed among your task types:
            </h4>
            <input type="checkbox" id="showTaskTypes" name="showTaskTypes" value="showTaskTypes">
            <br>
            <button type="submit"> Submit </button>
            <a href="feed">Go back to feed</a>
        </form>
    </main>
</body>
</html>