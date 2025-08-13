<?php
session_start();

$file = __DIR__ . "/data/users.json";
if (!file_exists($file)) {
    if (!is_dir(__DIR__ . "/data")) {
        mkdir(__DIR__ . "/data", 0777, true);
    }
    file_put_contents($file, json_encode([]));
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $users = json_decode(file_get_contents($file), true) ?? [];
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($_POST["action"] === "register") {
        $exists = false;
        foreach ($users as $u) {
            if ($u["username"] === $username) {
                $exists = true;
                break;
            }
        }
        if ($exists) {
            $message = "❌ اسم المستخدم موجود بالفعل.";
        } else {
            $users[] = [
                "username" => $username,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];
            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $message = "✅ تم إنشاء الحساب بنجاح! سجل دخول الآن.";
        }
    } elseif ($_POST["action"] === "login") {
        foreach ($users as $u) {
            if ($u["username"] === $username && password_verify($password, $u["password"])) {
                $_SESSION["user"] = $username;
                header("Location: dashboard.php");
                exit;
            }
        }
        $message = "❌ اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول / إنشاء حساب</title>
<style>
    body {
        margin: 0;
        overflow: hidden;
        font-family: Arial, sans-serif;
        background: black; /* خلفية سوداء */
        color: white;
    }
    canvas {
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1;
    }
    .form-container {
        background: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        margin: 100px auto;
        color: white;
        text-align: center;
        box-shadow: 0 0 20px rgba(255,255,255,0.2);
    }
    input {
        width: 90%;
        padding: 8px;
        margin: 8px 0;
        border: none;
        border-radius: 5px;
        outline: none;
    }
    button {
        padding: 8px 20px;
        border: none;
        background: #4CAF50;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }
    .toggle-btn {
        background: #2196F3;
        margin-top: 10px;
    }
    .message {
        margin: 10px 0;
        color: yellow;
    }
</style>
</head>
<body>

<canvas id="bgCanvas"></canvas>

<div class="form-container">
    <h2 id="form-title">تسجيل الدخول</h2>
    <div class="message"><?= htmlspecialchars($message) ?></div>
    <form method="POST">
        <input type="hidden" name="action" id="form-action" value="login">
        <input type="text" name="username" placeholder="اسم المستخدم" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit">إرسال</button>
    </form>
    <button class="toggle-btn" onclick="toggleForm()">إنشاء حساب جديد</button>
</div>

<script>
function toggleForm() {
    let title = document.getElementById("form-title");
    let action = document.getElementById("form-action");
    let btn = document.querySelector(".toggle-btn");

    if (action.value === "login") {
        action.value = "register";
        title.innerText = "إنشاء حساب";
        btn.innerText = "العودة لتسجيل الدخول";
    } else {
        action.value = "login";
        title.innerText = "تسجيل الدخول";
        btn.innerText = "إنشاء حساب جديد";
    }
}

// الخلفية المتحركة
const canvas = document.getElementById("bgCanvas");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
const icons = ["📚", "✏️", "📐", "📊", "🧮", "📝", "🔬", "📖", "📏", "🎓"];
const particles = [];
for (let i = 0; i < 40; i++) {
    particles.push({
        icon: icons[Math.floor(Math.random() * icons.length)],
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        size: 30 + Math.random() * 20,
        speed: 0.3 + Math.random() * 1,
        opacity: 0.4 + Math.random() * 0.6
    });
}
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
        ctx.globalAlpha = p.opacity;
        ctx.font = `${p.size}px Arial`;
        ctx.fillStyle = "white";
        ctx.fillText(p.icon, p.x, p.y);
        p.y -= p.speed;
        if (p.y < -50) {
            p.y = canvas.height + 50;
            p.x = Math.random() * canvas.width;
        }
    });
    requestAnimationFrame(draw);
}
draw();
window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>

</body>
</html>



