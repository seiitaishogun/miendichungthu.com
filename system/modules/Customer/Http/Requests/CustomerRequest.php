<?php
namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->method() == 'POST' ? '' : ',' . $this->segment(3);
        
        return [
            'email' => 'required|min:3|max:255|email|unique:customers,email' . $id,
            'password' => 'confirmed'
        ];
    }
}
