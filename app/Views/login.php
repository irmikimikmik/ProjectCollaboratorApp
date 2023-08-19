<!DOCTYPE html>
<html lang="en">

<head>
    <title>Welcome to Project Buddies</title>
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
    </style>
</head>

<body>
    <div id="box">
        <form action="/login" method="POST">
            <h2>Welcome to Project Buddies!</h2>
            <input type="email" name="Email" placeholder="Email">
            <input type="password" name="Password" placeholder="Password">
            <button type="submit">Login</button>
            <a href="signup">Click here to sign up</a>
        </form>

        <?php
            if(isset($error) && $error === 'invalid') {
                echo "<p style='color: red;'>Invalid email or password. Please try again.</p>";
            }
        ?>
        
    </div>
</body>