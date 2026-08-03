<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url("") }}">
<meta name="admin-url" content="{{ adminUrl("") }}">
<link rel="icon" href="{{ website_icon() }}" sizes="32x32">
@yield('meta')
