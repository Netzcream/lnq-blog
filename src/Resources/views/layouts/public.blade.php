<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Blog')</title>
    @stack('head')
</head>

<body class="min-h-screen">
    <main class="container mx-auto p-6">@yield('content')</main>
    @stack('scripts')
</body>

</html>
