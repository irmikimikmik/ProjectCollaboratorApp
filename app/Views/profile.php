<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        #profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        #profile-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 50%;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #profile-card:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
        }

        .profile-info {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }

        .input-field {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .bio-field {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            resize: vertical;
        }

        .save-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-button {
            padding: 10px 15px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="profile-container">
        <div id="profile-card">
            <h1>Edit Your Profile:</h1>
            <form action="/myprofile" method="POST">
                <div class="profile-info">
                    <label class="label">Name:</label>
                    <input class="input-field" type="text" name="name" value="<?= esc($user[0]['Name']) ?>" required>
                </div>

                <div class="profile-info">
                    <label class="label">Email:</label>
                    <input class="input-field" type="email" name="email" value="<?= esc($user[0]['Email']) ?>" required>
                </div>

                <div class="profile-info">
                    <label class="label">Password:</label>
                    <input class="input-field" type="password" name="password" value="<?= esc($user[0]['Password']) ?>" required>
                </div>

                <div class="profile-info">
                    <label class="label">Bio:</label>
                    <textarea class="bio-field" name="bio"><?= esc($user[0]['Bio']) ?></textarea>
                </div>
                <button class="save-button" type="submit">Update My Profile</button>
            </form>
            
            <form action="/delete_profile" method="POST">
                <button class="delete-button" type="submit">Delete My Profile</button>
            </form>

            <a href="feed">Go back to feed</a>

            <?php
                if(isset($success) && $success === 'profile_updated') {
                    echo "<p style='color: green;'>Your profile was updated successfully.</p>";
                }
            ?>
        </div>

    </div>
</body>
</html>