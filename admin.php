<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MCA Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="header">
        <img src="images/logo33.gif" class="logo">
        <h1>MCA Admin Dashboard</h1>
        <a href="logout.php" style="margin-left: auto; color: white; text-decoration: none; padding: 10px; background: rgba(0,0,0,0.3); border-radius: 5px;">Logout</a>
    </header>

    <section class="info-box">
        <h2 style="text-align:center">Student Enquiries</h2>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="enquiryData">
                <!-- DATA COMES HERE -->
            </tbody>
        </table>
    </section>

    <script src="admin.js"></script>
</body>

</html>
