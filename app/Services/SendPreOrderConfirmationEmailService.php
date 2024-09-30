<?php

namespace App\Services;


use App\Mail\AdminConfirmationEmail;
use App\Mail\CustomerConfirmationEmail;
use Illuminate\Support\Facades\Mail;

class SendPreOrderConfirmationEmailService
{
    public function sendPreOrderConfirmationEmails($preOrder, $customer)
    {
        // Data for the email
        $data = [
            'id' => $preOrder?->id,
            'customer_name' => $customer?->name,
            'customer_email' => $customer?->email,
            'total' => $preOrder?->total,
            'created_at' => $preOrder?->created_at,
        ];

        // Send email to user first with a delay
        Mail::to($customer->email)->later(now()->addSeconds(10), new CustomerConfirmationEmail($data));

        // Send admin email second but admin got the email first. hardcoded to test temporary
        Mail::to('mondalsatyajit93@gmail.com')->send(new AdminConfirmationEmail($data));

        return true;
    }
}
