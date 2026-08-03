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

<body style="background-color: #f1f1f1 !important; width: 100%; padding: 40px 10px;direction: ltr !important;">
    <div style="max-width: 540px; margin: auto">



        <div class="box"
            style="
          background-color: #fff !important;
          border-radius: 2px;
          padding: 40px 15px 60px 15px;
          text-align: center;
        ">

            <div style="text-align: center;">
                <img style="width: 75px; object-fit: contain;margin-bottom: 20px;" src="wrench.png" />
            </div>
            <!-- logo -->

            <h2 style="margin-bottom: 30px;">Forgot your password?</h2>
            <!-- title -->

            <p style="color: #7b7b7b;margin-bottom: 45px;">You have requested a password reset, so this mail has been
                sent upon your request, click on the button below
            </p>
            <!-- Message -->


            <a href="{{ adminUrl('profile/reset-password/' . $data['token']) }}"
                style="background-color:#07c;color:#fff; text-decoration: none;padding: 12px 20px;">Reset
                your password</a>

        </div>
        <!-- box -->



        <div style="font-size: 13px; margin: 15px 0px; text-align: center; color: #CC3300;">
            This link will expire after 30 minutes
        </div>
        <!-- Help Center -->


    </div>
</body>
<!-- Body-->

</html>
