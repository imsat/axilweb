<?php
namespace App\Services;


use App\Mail\AdminConfirmationEmail;
use App\Mail\UserConfirmationEmail;
use Illuminate\Support\Facades\Mail;

class SendPreOrderConfirmationEmailService
{
    public function sendPreOrderConfirmationEmails($preOrder, $user)
    {
        // Data for the email
        $data = [
            'id' => $preOrder?->id,
            'customer_name' => $user?->name,
            'customer_email' => $user?->email,
            'total' => $preOrder?->total,
            'created_at' => $preOrder?->created_at,
        ];

        // Send email to user first with a delay
        Mail::to($user->email)->later(now()->addSeconds(10), new UserConfirmationEmail($data));

        // Send admin email second but admin got the email first
        Mail::to('admin@mail.com')->send(new AdminConfirmationEmail($data));

        return true;
    }
}
