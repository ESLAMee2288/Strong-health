<?php
session_start();
if (!isset($_SESSION["user"])) { header("Location: ../dashboard.php"); exit; }

$grade = "ثالثة"; 
$stage = "ابتدائي"; 
$study_type = "عام";

$subjects_file = __DIR__ . "/../subjects.json";
$subjects_data = json_decode(file_get_contents($subjects_file), true);
$subjects = $subjects_data[$stage][$grade][$study_type] ?? [];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الصف <?= htmlspecialchars($grade) ?> (<?= htmlspecialchars($study_type) ?>)</title>
<style>
body { font-family: Arial; direction: rtl; text-align: center; background: black; color: white; padding: 50px; }
.container { background: #1a1a1a; padding: 20px; border-radius: 10px; display: inline-block; box-shadow: 0 0 10px rgba(255,255,255,0.2);}
ul { list-style: none; padding: 0; }
li { padding: 10px; margin: 5px 0; background: #333; border-radius: 5px; }
a { display: block; margin-top: 20px; color: #ff4d4d; text-decoration: none; }
</style>
</head>
<body>
<div class="container">
<h2>الصف <?= htmlspecialchars($grade) ?> (<?= htmlspecialchars($study_type) ?>)</h2>
<ul>
<?php foreach($subjects as $sub): ?>
<li><a href="../lesson.php?subject=<?= urlencode($sub) ?>"><?= htmlspecialchars($sub) ?></a></li>
<?php endforeach; ?>
</ul>
<a href="../dashboard.php">العودة للاختيار</a>
<a href="../logout.php">تسجيل الخروج</a>
</div>
</body>
</html>
<?php
$subjects = [
    "اللغة العربية" => "https://www.youtube.com/@elschoola",
    "الرياضيات" => "https://www.youtube.com/@mo3az.alhoregy",
    "اللغة الإنجليزية" => "https://www.youtube.com/@MostafaAwad",
    "اكتشف" => "https://www.youtube.com/@elschoola",
    "الدين الإسلامي" => "https://www.youtube.com/@elschoola"
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثالثة ابتدائي - عام</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #121212; 
            color: #ffffff; 
            text-align: center; 
            margin: 0;
            padding: 0;
        }
        h1 { 
            color: #f5f5f5; 
            padding: 20px; 
        }
        .subject {
            background: #1e1e1e;
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.7);
        }
        h2 {
            color: #ffcc00;
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            background: #ffcc00;
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        a:hover {
            background: #ffaa00;
        }
    </style>
</head>
<body>
    <h1>مواد الصف الثالث الابتدائي - عام</h1>

    <?php foreach ($subjects as $name => $link): ?>
        <div class="subject">
            <h2><?php echo $name; ?></h2>
            <a href="<?php echo $link; ?>" target="_blank">اذهب للقناة</a>
        </div>
    <?php endforeach; ?>

</body>
</html>






















