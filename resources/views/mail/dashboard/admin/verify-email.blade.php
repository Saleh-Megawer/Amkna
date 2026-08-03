<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style="
      background-color: #f1f1f1 !important;
      width: 100%;
      padding: 40px 10px;
    ">
    <div style="max-width: 720px; margin: auto">
        <div class="box"
            style="
          background-color: #fff !important;
          border-radius: 2px;
          padding: 40px 15px 60px 15px;
          text-align: center;
          direction: ltr !important;
        ">
            <div style="text-align: center">
                <img style="width: 90px; margin-bottom: 20px"
                    src="{{ asset('assets/images/mail/verify-email.png') }}" />
            </div>
            <!-- logo -->

            <h2 style="margin-bottom: 30px;">Verify your email address!</h2>
            <!-- title -->

            <p style="color: #585858; margin-bottom: 35px;line-height: 32px;">
                You have entered <b style="color: #212121">{{ $data['email'] }}</b> as the
                email address for your account in {{ env('APP_NAME') }}.
                <br>Please verify your email address by clicking the button below
            </p>
            <!-- Message -->

            <a href="{{ adminUrl('profile/verified-email/' . $data['token']) }}"
                style="
            background-color: #07c;
            color: #fff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 2px;
            font-size: 15px;
          ">Verify
                your email</a>
        </div>
        <!-- box -->

        <div
            style="
          font-size: 13px;
          margin: 15px 0px;
          text-align: center;
          color: #7b7b7b;
        ">
            If you do not know anything about this message and are not responsible for it, please write to us now
            <a href="https://help.mentorea.net/" style="color: #07c"> Help Center.</a>
        </div>
        <!-- Help Center -->

        <div style="font-size: 13px; color: #7b7b7b; text-align: center">
            Auto Message From LaraDashboard.
        </div>
        <!-- Website name-->
    </div>
</body>
<!-- Body-->

</html>
