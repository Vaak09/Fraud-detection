<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function createCustomer($customer, $scan, $dateOfBirth, $lastInvoiceDate, $lastLoginDateTime, $isFraud, $reasons) {
        // Create customer record
        Customer::create([
            'customerId' => $customer['customerId'],
            'bsn' => $customer['bsn'],
            'firstName' => $customer['firstName'],
            'lastName' => $customer['lastName'],
            'dateOfBirth' => $dateOfBirth,
            'phoneNumber' => $customer['phoneNumber'],
            'email' => $customer['email'],
            'tag' => $customer['tag'] ?? null,
            'street' => $customer['address']['street'] ?? null,
            'postcode' => $customer['address']['postcode'] ?? null,
            'city' => $customer['address']['city'] ?? null,
            'products' => json_encode($customer['products']),
            'ipAddress' => $customer['ipAddress'],
            'iban' => $customer['iban'],
            'lastInvoiceDate' => $lastInvoiceDate,
            'lastLoginDateTime' => $lastLoginDateTime,
            'is_fraud' => $isFraud,
            'fraud_reason' => $isFraud ? implode(', ', $reasons) : null,
            'scan_id' => $scan->id,
        ]);
    }
    public function markAllAsFraud($customers, $scan, $reasons) {

        // Mark all customers in the provided list as fraud
        foreach ($customers as $customer) {
     

            $customer->update([
            'is_fraud' => true,
            'fraud_reason' => implode(', ', $reasons),
            'scan_id' => $scan->id,
            ]);
        }
    }
    public function getAllCustomers() {
        return Customer::all();
    }
    public function getCustomerById($id) {
        return Customer::findOrFail($id);
    }
}