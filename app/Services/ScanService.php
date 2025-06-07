<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Scan;
use App\Models\Customer;


class ScanService
{
    protected $customer_service;

    public function __construct(CustomerService $customer_service)
    {
        $this->customer_service = $customer_service;
    }


    public function performScan()
    {
        // Call an external API to retrieve customer data
        $response = Http::get('http://localhost:8080/api/v1/customers');
        if (!$response->successful()) {
            return back()->withErrors(['msg' => 'Failed to fetch customers.']);
        }

        $data = $response->json();
        $customers = collect($data['customers']);
        $scan = new Scan([
            'scan_date' => now(),
            'details' => $customers->isNotEmpty() ? 'Scan completed successfully' : 'No data found',
        ]);

        $scan->save();

        $this->checkForFraud($customers, $scan);

        return $customers;
    }

    private function checkForFraud($customers, $scan)
    {
        foreach ($customers as $customer) {
            $isFraud = false;
            $reasons = [];
    
            // Convert date formats
            $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $customer['dateOfBirth'])->format('Y-m-d');
            $lastInvoiceDate = isset($customer['lastInvoiceDate'])
                ? \Carbon\Carbon::createFromFormat('d-m-Y', $customer['lastInvoiceDate'])->format('Y-m-d')
                : null;
            $lastLoginDateTime = isset($customer['lastLoginDateTime'])
                ? \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $customer['lastLoginDateTime'])->format('Y-m-d H:i:s')
                : null;
    
            // Fraud Check 1: Duplicate IP Address or IBAN
            $duplicateIpCustomers = Customer::where('ipAddress', $customer['ipAddress'])
                ->where('id', '!=', $customer['customerId'])
                ->get();
    
            $duplicateIbanCustomers = Customer::where('iban', $customer['iban'])
                ->where('id', '!=', $customer['customerId'])
                ->get();
    
            if ($duplicateIpCustomers->isNotEmpty()) {
                $isFraud = true;
    
                // Reason for the current customer
                $reasons[] = "Customer has same IP as " . $duplicateIpCustomers->map(function ($duplicateCustomer) {
                    return "{$duplicateCustomer->firstName} {$duplicateCustomer->lastName}";
                })->join(', ') . " ({$customer['ipAddress']})";
    
                // Separate reason for duplicate customers
                $duplicateIpReason = "Customer has same IP as {$customer['firstName']} {$customer['lastName']} ({$customer['ipAddress']})";
    
                $this->customer_service->markAllAsFraud($duplicateIpCustomers, $scan, [$duplicateIpReason]);
            }
    
            if ($duplicateIbanCustomers->isNotEmpty()) {
                $isFraud = true;
    
                // Reason for the current customer
                $reasons[] = "Customer has same IBAN as " . $duplicateIbanCustomers->map(function ($duplicateCustomer) {
                    return "{$duplicateCustomer->firstName} {$duplicateCustomer->lastName}";
                })->join(', ') . " ({$customer['iban']})";
    
                // Separate reason for duplicate customers
                $duplicateIbanReason = "Customer has same IBAN as {$customer['firstName']} {$customer['lastName']} ({$customer['iban']})";
    
                $this->customer_service->markAllAsFraud($duplicateIbanCustomers, $scan, [$duplicateIbanReason]);
            }
    
            // Fraud Check 2: Phone Number Outside the Netherlands
            if (!str_starts_with($customer['phoneNumber'], '+31')) {
                $isFraud = true;
                $reasons[] = 'Customer has non-NL phone nr';
            }
    
            // Fraud Check 3: Underage Customer
            $age = \Carbon\Carbon::parse($dateOfBirth)->age;
            if ($age < 18) {
                $isFraud = true;
                $reasons[] = 'Customer is under 18 years old';
            }
    
            // Ensure the current customer is created regardless of fraud checks
            $this->customer_service->createCustomer($customer, $scan, $dateOfBirth, $lastInvoiceDate, $lastLoginDateTime, $isFraud, $reasons);
        }
    }
public function showScans()
{
    $scans = Scan::with('customers')->latest()->get();
    return $scans;
}
public function getScanById($id)
{
    $scan = Scan::with('customers')->findOrFail($id);
    return $scan;
}
}