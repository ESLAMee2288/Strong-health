<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../dashboard.php");
    exit;
}

// ثوابت الصفحة
$grade = "أولى";
$stage = "ابتدائي";
$study_type = "عام";

// نحاول نلاقي ملف الـ JSON في مسارات شائعة
$subjects = [];
$subjects_file = null;
$candidates = [
    __DIR__ . "/../subjects.json",
    __DIR__ . "/../data/subjects.json",
    __DIR__ . "/subjects.json"
];

foreach ($candidates as $path) {
    if (is_file($path)) {
        $subjects_file = $path;
        break;
    }
}

$notice = "";
if ($subjects_file) {
    $raw = file_get_contents($subjects_file);
    $data = json_decode($raw, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // نتوقع البنية: stage -> grade -> study_type -> {اسم المادة: رابط}
        if (isset($data[$stage][$grade][$study_type]) && is_array($data[$stage][$grade][$study_type])) {
            $subjects = $data[$stage][$grade][$study_type];
        }
    } else {
        $notice = "تنبيه: ملف subjects.json غير صالح (JSON غير صحيح). تم استخدام بيانات افتراضية.";
    }
} else {
    $notice = "تنبيه: لم يتم العثور على ملف subjects.json. تم استخدام بيانات افتراضية.";
}

// في حال عدم وجود بيانات، نستخدم افتراضي

    

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>مواد الصف <?= htmlspecialchars($grade) ?> الابتدائي - <?= htmlspecialchars($study_type) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #000; /* خلفية سوداء */
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #f5f5f5;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto 30px;
            padding: 0 16px;
        }
        .notice {
            background: #222;
            color: #ffd166;
            display: inline-block;
            padding: 10px 14px;
            border-radius: 8px;
            margin: 10px 0 0;
            font-size: 14px;
        }
        .subject {
            background: #1e1e1e;
            margin: 20px auto;
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.7);
        }
        .subject h2 {
            color: #ffcc00;
            margin: 0 0 10px;
            font-size: 20px;
        }
        .subject a {
            display: inline-block;
            background: #ffcc00;
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .subject a:hover {
            background: #ffaa00;
        }
        a { display: block; margin-top: 20px; color: #ff4d4d; text-decoration: none; }
    </style>
</head>
<body>
    <h1>مواد الصف الأول الابتدائي - عام</h1>

    <div class="container">
        <?php if (!empty($notice)): ?>
            <div class="notice"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>

        <?php foreach ($subjects as $name => $link): ?>
            <div class="subject">
                <h2><?= htmlspecialchars($name) ?></h2>
                <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener">اذهب للقناة</a>
            </div>
        <?php endforeach; ?>
        <ul>
<a href="../dashboard.php">العودة للاختيار</a>
<a href="../logout.php">تسجيل الخروج</a>
        </ul>
    </div>
</body>
</html>
















