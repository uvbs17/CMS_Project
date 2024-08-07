<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Study Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin: 20px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="file"] {
            padding: 10px;
            margin-right: 10px;
        }
        p {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #4285F4;
        }
    </style>
</head>
<body>
    <h1>Upload Study Document</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload">
    </form>
    <h2>Download Study Documents</h2>
    <?php
        $files = scandir("uploads");
        for ($i = 2; $i < count($files); $i++) {
            ?>
            <p><a href="<?php echo 'uploads/' . $files[$i]; ?>"><?php echo $files[$i]; ?></a></p>
            <?php
        }
    ?>
</body>
</html>