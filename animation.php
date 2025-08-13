<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>خلفية تعليمية متحركة</title>
<style>
    body {
        margin: 0;
        overflow: hidden;
        background: #000; /* خلفية سوداء */
    }
    canvas {
        display: block;
    }
</style>
</head>
<body>
<canvas id="bgCanvas"></canvas>

<script>
    const canvas = document.getElementById("bgCanvas");
    const ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // قائمة الأيقونات التعليمية
    const icons = ["📚", "✏️", "📐", "📊", "🧮", "📝", "🔬", "📖", "📏", "🎓"];

    // مصفوفة لحفظ الأيقونات المتحركة
    const particles = [];

    // إنشاء أيقونات عشوائية
    for (let i = 0; i < 30; i++) {
        particles.push({
            icon: icons[Math.floor(Math.random() * icons.length)],
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: 30 + Math.random() * 20,
            speed: 0.5 + Math.random() * 1,
            opacity: 0.3 + Math.random() * 0.9
        });
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            ctx.globalAlpha = p.opacity;
            ctx.font = `${p.size}px Arial`;
            ctx.fillText(p.icon, p.x, p.y);

            // حركة للأعلى
            p.y -= p.speed;
            if (p.y < -50) {
                p.y = canvas.height + 50;
                p.x = Math.random() * canvas.width;
            }
        });

        requestAnimationFrame(draw);
    }

    draw();

    // إعادة ضبط الحجم عند تغيير الشاشة
    window.addEventListener("resize", () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
</script>
</body>
</html>








