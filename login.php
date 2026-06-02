<?php

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $admin_user = 'ادمین';
    $admin_pass = '123456';

    if ($username === $admin_user && $password === $admin_pass)
    {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;

        header("Location: admin.php");
        exit;
    }
    else
    {
        $error = 'نام کاربری یا رمز عبور اشتباه است.';
    }
}

?>

<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>ورود مدیر</title>

<style>
body
{
    direction:rtl;
    font-family:tahoma;
    margin:0;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#2563eb,#1e293b);
}

.login-box
{
    width:350px;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
}

.login-box h2
{
    text-align:center;
    margin-bottom:25px;
}

input
{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

input:focus
{
    outline:none;
    border-color:#2563eb;
}

button
{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#2563eb;
    color:white;
    font-size:15px;
    cursor:pointer;
}

button:hover
{
    background:#1d4ed8;
}

.error
{
    color:red;
    text-align:center;
    margin-top:15px;
}
</style>
</head>

<body>

<div class="login-box">

    <h2>ورود به پنل مدیریت</h2>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="نام کاربری"
            required>

        <input
            type="password"
            name="password"
            placeholder="رمز عبور"
            required>

        <button type="submit">
            ورود
        </button>

    </form>

    <?php if($error): ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

</div>

    </form>

<?php if($error): ?>
<p style="color:red;text-align:center;">
    <?= htmlspecialchars($error) ?>
</p>
<?php endif; ?>

</body>
</html>