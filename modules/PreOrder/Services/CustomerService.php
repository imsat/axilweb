<?php
namespace Modules\PreOrder\Services;

use Illuminate\Support\Facades\Hash;
use Modules\PreOrder\Models\Customer;

class CustomerService
{
    public function findOrCreate($data)
    {
        // Find user
        $customer = Customer::whereEmail($data['email'])->first();

        if(blank($customer)){
            $data['password'] = Hash::make(123456); //default password
            $customer = new Customer();
            $customer->fill($data);
            $customer->save();
        }

        return $customer->fresh();
    }
}
