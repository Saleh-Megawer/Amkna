<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .email-header {
            background-color: #2eb3d0;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 20px
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #333
        }

        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666
        }

        .email-body p {
            margin: 10px 0;
            font-weight: 400 !important;

        }

        .email-body span {
            font-weight: 700;
            color: #000000
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">رسالة جديدة من وجهتنا العقارية</div>
        <div style="direction: ltr;text-align: right;" class="email-body">
            <p style="direction: rtl;">تاريخ الارسال: <span
                    style="direction: rtl;display:inline-block">{{ now() }}</span></p>
            <p style="direction: rtl;">الاسم بالكامل : <span>{{ $data['name'] }}</span></p>
            <p style="direction: rtl;">البريد الالكتروني: <span>{{ $data['email'] }}</span></p>
            <p style="direction: rtl;">عنوان الرسالة: <span>{{ $data['subject'] }}</span></p>
            <p style="direction: rtl;">موضوع الرسالة : <span>{{ $data['message'] }}</span></p>
        </div>
        <div class="email-footer">نموذج اتصل بنا</div>
    </div>
</body>

</html>
