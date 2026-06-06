<?php
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $full_name = htmlspecialchars(strip_tags(trim($_POST['full_name'] ?? '')));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'] ?? '')));
    $student_number = htmlspecialchars(strip_tags(trim($_POST['student_number'] ?? '')));
    $skills = htmlspecialchars(strip_tags(trim($_POST['skills'] ?? '')));

    if (!preg_match('/^[0-9]{11}$/', $phone))
    {
        $message = "شماره تلفن باید 11 رقم و فقط شامل عدد باشد.";
    }
    elseif (!preg_match('/^[0-9]+$/', $student_number))
    {
        $message = "شماره دانشجویی فقط باید شامل عدد باشد.";
    }
    elseif (!empty($full_name) && !empty($phone) && !empty($student_number))
    {
        $check_sql = "SELECT COUNT(*) FROM users WHERE student_number = :student_number";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([':student_number' => $student_number]);

        if ($check_stmt->fetchColumn() > 0)
        {
            $message = "خطا: این شماره دانشجویی قبلاً ثبت نام کرده است!";
        }
        else
        {
            $sql = "INSERT INTO users (full_name, phone, student_number, skills)
                    VALUES (:full_name, :phone, :student_number, :skills)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':full_name' => $full_name,
                ':phone' => $phone,
                ':student_number' => $student_number,
                ':skills' => $skills
            ]);

            $message = "ثبت نام با موفقیت انجام شد.";
        }
    }
    else
    {
        $message = "لطفاً تمامی فیلدهای اجباری را پر کنید.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>فرم ثبت نام</title>

    <style>

        body
        {
            direction: rtl;
            font-family: Tahoma;
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            margin:0;
        }

        .container
        {
            width:450px;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.15);
        }

        h2
        {
            text-align:center;
            margin-bottom:20px;
        }

        input,
        textarea
        {
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
            box-sizing:border-box;
        }

        button
        {
            width:100%;
            padding:12px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover
        {
            background:#1d4ed8;
        }

        .message
        {
            text-align:center;
            font-weight:bold;
            margin-bottom:15px;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>فرم ثبت نام</h2>

    <?php if(!empty($message)): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">

        <label>نام و نام خانوادگی:</label>
        <input type="text" name="full_name" required>

        <label>شماره تلفن:</label>
        <input type="tel" name="phone" required>

        <label>شماره دانشجویی:</label>
        <input type="text" name="student_number" required>

        <label>مهارت ها:</label>
        <textarea name="skills" rows="5"></textarea>

        <button type="submit">ثبت اطلاعات</button>

    </form>

</div>
</body>
</html>
