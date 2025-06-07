<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fraud Scan Application</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaR0y3K1sha3z8z4QeFcc6zH4l8zW1RVzLg1tAqzWl5K5jF1zKp5hF5b6p" crossorigin="anonymous">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans">
        <!-- Wrapper with gradient background -->
        <div class="bg-gradient-to-b from-gray-100 to-gray-200 min-h-screen flex flex-col">
            <!-- Header -->
            <x-header title="Fraud Scan"/>

            <!-- Main Content -->
            <main class="bg-white p-8 rounded-lg shadow-lg mx-auto mt-8 max-w-2xl text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to the Fraud Scan Application</h1>
                <form method="POST" action="{{ route('scan.perform') }}">
                    @csrf
                    <button class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-2 px-6 rounded-lg font-bold shadow-md hover:from-blue-800 hover:to-blue-600 hover:shadow-lg transition-all">
                        Scan for fraud
                    </button>
                </form>
            </main>
        </div>
    </body>
</html>