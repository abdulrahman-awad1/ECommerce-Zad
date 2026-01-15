<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        // أي حد مسموح له يقدم الطلب
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'       => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email',
            'country'         => 'required|string|max:100',
            'city'            => 'required|string|max:100',
            'street'          => 'required|string|max:500',
            'zip_code'        => 'nullable|string|max:20',
            'payment_method'  => 'required|in:cash,online',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'      => 'اسمك مطلوب',
            'phone.required'          => 'رقم الهاتف مطلوب',
            'email.required'          => 'البريد الإلكتروني مطلوب',
            'country.required'        => 'البلد مطلوب',
            'city.required'           => 'المدينة مطلوبة',
            'street.required'         => 'الشارع مطلوب',
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in'       => 'طريقة الدفع غير صحيحة',
        ];
    }
}
