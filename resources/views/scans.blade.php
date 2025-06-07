<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Scan Results</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gradient-to-b from-gray-100 to-gray-200 min-h-screen">
        <!-- Header -->
        <x-header title="Fraud Scan" />

        <!-- Main Content -->
        <div class="container mx-auto mt-20 flex flex-col items-center px-4">
            @foreach ($scans as $scan)
                <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Scan at {{ $scan->scan_date }}</h2>
                <div class="overflow-x-auto w-full shadow-lg rounded-lg bg-white">
                    <table class="table-auto border-collapse border border-gray-300 w-full text-left">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border border-gray-300 px-6 py-3">Name</th>
                                <th class="border border-gray-300 px-6 py-3">Email</th>
                                <th class="border border-gray-300 px-6 py-3">IBAN</th>
                                <th class="border border-gray-300 px-6 py-3">Phone number</th>
                                <th class="border border-gray-300 px-6 py-3">Age</th>
                                <th class="border border-gray-300 px-6 py-3">IP</th>
                                <th class="border border-gray-300 px-6 py-3">Status</th>
                                <th class="border border-gray-300 px-6 py-3">Reason (incase of fraud)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scan->customers as $customer)
                                <tr class="{{ $customer->is_fraud ? 'bg-red-100' : 'bg-gray-50' }} hover:bg-gray-100">
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->firstName }} {{$customer->lastName}}</td>
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->email }}</td>
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->iban }}</td>
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->phoneNumber }}</td>
                                    <td class="border border-gray-300 px-6 py-3">{{ \Carbon\Carbon::parse($customer->dateOfBirth)->age }}</td>
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->ipAddress }}</td>
                                    <td class="border border-gray-300 px-6 py-3 font-semibold {{ $customer->is_fraud ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $customer->is_fraud ? 'Fraud' : 'Innocent' }}
                                    </td>
                                    <td class="border border-gray-300 px-6 py-3">{{ $customer->is_fraud ? $customer->fraud_reason : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </body>
</html>