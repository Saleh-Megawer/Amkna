<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $row->subject }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style="background-color: #f1f1f1 !important; width: 100%; padding: 100px 10px">
    <div style="max-width: 600px; margin: auto">


        <div style="text-align: center;">
            <img style="width: 75px; object-fit: contain" src="{{ env('APP_LOGO') }}" />
        </div>
        <!-- logo -->

        <div class="box"
            style="
          background-color: #fff !important;
          border-radius: 3px;
          border-top: 5px solid #00b894;
          margin-top: 10px;
          padding: 25px;
        ">
            <div>{!! $row->message !!} </div>
            <!-- Message -->
        </div>
        <!-- box -->

        <div style="font-size: 13px; margin: 15px 0px; text-align: center; color: #7b7b7b;">
            If you need help or give us any feedback, please visit our
            <a href="https://help.mentorea.net/" style="color: #00b894">Help Center.</a>
        </div>
        <!-- Help Center -->

        <div style="
          font-size: 12px;
          color: #7b7b7b;
          text-align: center;
        ">
            {{ env('APP_NAME') . ' Team' }}
        </div>
        <!-- Website name-->

    </div>
</body>
<!-- Body-->

</html>
