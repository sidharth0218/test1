<?php
require('connect.php');

$name = $_POST['name'];
$email = $_POST['email'];
if ($name == '') {
    $errors['name'] = "Name is required";
}

if ($email == '') {
    $errors['email'] = "Email is required";
} else {
    // CHECK EMAIL EXISTS
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $errors['email'] = "Email already exists";
    }
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// FILE INFO
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

// UNIQUE NAME (important)
$imageName = time() . "_" . $image;

// FOLDER PATH
$folder = "uploads/";
$path = $folder . $imageName;

// ✅ 1. Check folder exists or create
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

// ✅ 2. Upload file
if (move_uploaded_file($tmp, $path)) {

    // ✅ 3. Insert only if upload success
    $sql = "INSERT INTO users (name, email, password, image)
            VALUES ('$name', '$email', '$password', '$imageName')";

    if ($conn->query($sql)) {
        echo "<span style='color:green'>Data Inserted Successfully</span>";
    } else {
        echo "<span style='color:red'>DB Error!</span>";
    }

} else {
    echo "<span style='color:red'>Image Upload Failed!</span>";
}
?>