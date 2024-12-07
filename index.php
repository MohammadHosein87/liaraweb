<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل کاربری</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap');
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(135deg, #43cea2, #185a9d); /* پیش‌فرض گرادیانت جدید */
            color: #fff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: right;
            direction: rtl;
            transition: background 0.5s ease;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 30px 25px;
            width: 400px;
            text-align: right;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .info {
            margin: 10px 0;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1em;
            color: #f1f1f1;
            transition: transform 0.3s, background 0.3s;
        }
        .info:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-5px);
        }
        .info strong {
            color: #FFD700;
        }
        .color-picker {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }
        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .color-option:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>پروفایل <?php echo htmlspecialchars($user['name']); ?></h1>
        <div class="info"><strong>ایمیل:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
        <div class="info"><strong>تاریخ شروع:</strong> <?php echo htmlspecialchars($user['start']); ?></div>
        <div class="info"><strong>تاریخ انقضا:</strong> <?php echo htmlspecialchars($user['exp']); ?></div>
        <div class="info"><strong>روزهای باقی‌مانده:</strong> <?php echo htmlspecialchars($user['remaining_days']); ?></div>
        
        <!-- Color Picker -->
        <div class="color-picker">
            <div class="color-option" style="background: #667eea;" onclick="changeBackground('#667eea')"></div>
            <div class="color-option" style="background: #43cea2;" onclick="changeBackground('#43cea2')"></div>
            <div class="color-option" style="background: #ff7e5f;" onclick="changeBackground('#ff7e5f')"></div>
            <div class="color-option" style="background: #6a11cb;" onclick="changeBackground('#6a11cb')"></div>
            <div class="color-option" style="background: #f7971e;" onclick="changeBackground('#f7971e')"></div>
            <div class="color-option" style="background: #a1c4fd;" onclick="changeBackground('#a1c4fd')"></div>
            <div class="color-option" style="background: #fdc830;" onclick="changeBackground('#fdc830')"></div>
            <div class="color-option" style="background: #8e2de2;" onclick="changeBackground('#8e2de2')"></div>
            <div class="color-option" style="background: #ff4b1f;" onclick="changeBackground('#ff4b1f')"></div>
            <div class="color-option" style="background: #f48c06;" onclick="changeBackground('#f48c06')"></div>
        </div>
    </div>

    <script>
        function changeBackground(color) {
            document.body.style.background = 'linear-gradient(135deg, ' + color + ', #185a9d)';
        }
    </script>
</body>
</html>
