<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&family=Rakkas&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
            font-family: "Tajawal", sans-serif !important;

        }
    </style>
</head>

<body width="100%" style="padding: 25px 10px !important;background-color: #e6e7ef;">

    <div
        style="max-width: 600px; margin: 0 auto;background-color:rgb(255, 255, 255);border-radius:5px; box-shadow: 0px 0px 3px #ddd">
        <div style="text-align:center;padding:20px 0px;border-bottom:1px solid #ddd;">
            <img width="180px" src="{{ asset('assets/images/logo-main.png') }}" alt="">
        </div><!-- logo -->
    </div><!-- logo section -->

    <div
        style="max-width: 600px; margin: 0 auto;background-color:rgb(255, 255, 255);border-radius:5px; box-shadow: 0px 0px 3px #ddd">
        <h4 style="font-size: 18px;margin-top:10px;padding:15px 15px;text-align:right">معلومات المسؤول</h4>
        <!-- title -->
        <div style="padding:15px 15px;border-top:1px solid #ddd;">

            <table style="width: 100%;direction:rtl">
                <tbody>


                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">اسم المسؤول</td>
                        <td style="padding: 5px">: {{ $data['username'] }}</td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">رقم الهاتف</td>
                        <td style="padding: 5px">: {{ $data['phone'] }}</td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">البريد الإلكتروني</td>
                        <td style="padding: 5px">: {{ $data['email'] }}</td>
                    </tr><!-- end -->

                </tbody>
            </table>


        </div>
    </div><!-- first section -->

    <div
        style="max-width: 600px; margin: 0 auto;background-color:rgb(255, 255, 255);border-radius:5px; box-shadow: 0px 0px 3px #ddd">
        <h4 style="font-size:16px;margin-top:10px;padding:15px 15px;text-align:right">نشاط الشركة (
            <b>{{ $data['activity']['title'] }}</b> )
        </h4>
        <!-- title -->
        <div style="padding:15px 15px;border-top:1px solid #ddd;">
            <ul style="direction: rtl">
                @foreach ($data['selected_programs'] as $program)
                    <li style="list-style-position: inside;padding:3px 0px">{{ $program['program']['title'] }}</li>
                @endforeach
            </ul>
        </div>
    </div><!-- first section -->

    <div
        style="max-width: 600px; margin: 0 auto;background-color:rgb(255, 255, 255);border-radius:5px; box-shadow: 0px 0px 3px #ddd">
        <h4 style="font-size: 18px;margin-top:10px;padding:15px 15px;text-align:right">معلومات عن الشركة</h4>
        <!-- title -->
        <div style="padding:15px 15px;border-top:1px solid #ddd;">

            <table style="width: 100%;direction:rtl">
                <tbody>

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">اسم الشركة</td>
                        <td style="padding: 5px">: {{ $data['company_name'] }}</td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">نشاط الشركة</td>
                        <td style="padding: 5px">: {{ $data['company_activity'] }}</td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">عدد الموظفين </td>
                        <td style="padding: 5px">: {{ $data['company_employees_number'] }}</td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">البلد</td>
                        <td style="padding: 5px">:
                            @if ($data['country'] == null)
                                لا يوجد
                            @else
                                {{ $data['country']['name'] }}
                            @endif
                        </td>
                    </tr><!-- end -->

                    <tr style="width: 100%">
                        <td style="padding: 5px;width: 100px;">المدينة</td>
                        <td style="padding: 5px">: {{ $data['city'] }}</td>
                    </tr><!-- end -->

                </tbody>
            </table>


        </div>
    </div><!-- first section -->

</body>

</html>
