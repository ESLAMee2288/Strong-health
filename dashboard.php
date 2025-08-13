<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["stage"] = $_POST["stage"];
    $_SESSION["grade"] = $_POST["grade"];
    $_SESSION["study_type"] = $_POST["study_type"];

    // تحديد الملف بناءً على الصف ونوع الدراسة
    $file = "";
    if ($_POST["grade"] === "أولى" && $_POST["study_type"] === "عام") {
        $file = "grades/grade1_general.php";
    } elseif ($_POST["grade"] === "ثانية" && $_POST["study_type"] === "عام") {
        $file = "grades/grade2_general.php";
    } elseif ($_POST["grade"] === "ثالثة" && $_POST["study_type"] === "عام") {
        $file = "grades/grade3_general.php";
    }

    // لو الملف موجود نحوله، لو مش موجود يرجع رسالة خطأ
    if ($file && file_exists($file)) {
        header("Location: $file");
        exit;
    } else {
        echo "<script>alert('الصفحة المطلوبة غير موجودة حالياً');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>لوحة التحكم</title>
<style>
    body {
        font-family: Arial, sans-serif;
        direction: rtl;
        text-align: center;
        background: black;
        color: white;
        padding: 50px;
    }
    .container {
        background: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        display: inline-block;
        box-shadow: 0 0 10px rgba(255,255,255,0.2);
    }
    select, button {
        padding: 10px;
        margin: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background: #333;
        color: white;
    }
    button {
        background: #4CAF50;
        color: white;
        cursor: pointer;
        border: none;
    }
    a {
        display: block;
        margin-top: 20px;
        color: #ff4d4d;
        text-decoration: none;
    }
</style>
</head>
<body>

<div class="container">
    <h2>مرحباً، <?= htmlspecialchars($_SESSION["user"]) ?> 👋</h2>
    <form method="POST">
        <label>اختر المرحلة:</label><br>
        <select name="stage" id="stage" required onchange="updateGrades()">
            <option value="">-- اختر --</option>
            <option value="ابتدائي">ابتدائي</option>
            <option value="إعدادي">إعدادي</option>
            <option value="ثانوي">ثانوي</option>
        </select><br>

        <label>اختر الصف التفصيلي:</label><br>
        <select name="grade" id="grade" required>
            <option value="">-- اختر المرحلة أولاً --</option>
        </select><br>

        <label>اختر نوع الدراسة:</label><br>
        <select name="study_type" required>
            <option value="">-- اختر --</option>
            <option value="عام">عام</option>
            <option value="لغات">لغات</option>
        </select><br>

        <button type="submit">متابعة</button>
    </form>

    <a href="logout.php">تسجيل الخروج</a>
</div>

<script>
function updateGrades() {
    const stage = document.getElementById("stage").value;
    const gradeSelect = document.getElementById("grade");
    let options = "";

    if(stage === "ابتدائي") {
        options = "<option value='أولى'>أولى</option>" +
                  "<option value='ثانية'>ثانية</option>" +
                  "<option value='ثالثة'>ثالثة</option>" +
                  "<option value='رابعة'>رابعة</option>" +
                  "<option value='خامسة'>خامسة</option>" +
                  "<option value='سادسة'>سادسة</option>";
    } else if(stage === "إعدادي") {
        options = "<option value='أول'>أول</option><option value='ثاني'>ثاني</option><option value='ثالث'>ثالث</option>";
    } else if(stage === "ثانوي") {
        options = "<option value='أول'>أول</option><option value='ثاني'>ثاني</option><option value='ثالث'>ثالث</option>";
    } else {
        options = "<option value=''>-- اختر المرحلة أولاً --</option>";
    }

    gradeSelect.innerHTML = options;
}
</script>

</body>
</html>




































