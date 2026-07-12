<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Page Not Found</title>
        <link rel="icon" href="/health-care.png" sizes="any">
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen items-center justify-center bg-muted/30 p-4">
            <div class="w-full max-w-md text-center">
                <p class="text-7xl font-black text-red-500">404</p>
                <p class="mt-4 text-lg text-muted-foreground">Page not found.</p>
                <a href="/" class="mt-6 inline-flex items-center justify-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900">
                    Go Home
                </a>
            </div>
        </div>
    </body>
</html>
