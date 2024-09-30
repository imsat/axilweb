<?php

namespace Modules\PreOrder\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\PreOrder\Traits\ResponseTrait;

class PreOrderRequest extends FormRequest
{
    use ResponseTrait;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'PATCH', 'PUT' => [
                // 'name' => 'nullable|string',
            ],
            default => [
                // 'name' => 'required|string',
            ],
        };
    }

    /**
     * Returns validations errors.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException($this->response(false, 'Please provide valid data!', 422, null, $validator->errors()));
        }
        parent::failedValidation($validator);
    }
}
