<?php

namespace App\Http\Controllers;


class ScanController extends \Illuminate\Routing\Controller
{
    public $scan_service;

    public function __construct(\App\Services\ScanService $scan_service)
    {
        $this->scan_service = $scan_service;
    }

    public function index()
    {
        return view('scan');
    }

    public function perform()
    {
        $this->scan_service->performScan();
        $scans = $this->scan_service->showScans();

        return view('scans',  ['scans' => $scans]);
    }
    public function history()
    {
        $scans = $this->scan_service->showScans();
        return view('scans', ['scans' => $scans]);
    }
    public function getAllScans()
    {
        $scans = $this->scan_service->showScans();
        return response()->json($scans);
    }

    public function getScanById($id)
    {
        $scan = $this->scan_service->getScanById($id);
        return response()->json($scan);
    }
}
