<?php

namespace App\Http\Controllers;

class CustomerController extends \Illuminate\Routing\Controller
{
    public $customer_service;

    public function __construct(\App\Services\CustomerService $customer_service)
    {
        $this->customer_service = $customer_service;
    }

    public function getAllCustommers()
    {
        $customers = $this->customer_service->getAllCustomers();
        return $customers;
    }
 
    public function getOneCustommer($id)
    {
        $customer = $this->customer_service->getCustomerById($id);
        return $customer;
    }
}