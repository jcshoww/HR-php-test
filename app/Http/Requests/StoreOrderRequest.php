<?php

namespace App\Http\Requests;

use App\Order;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => "required|integer|exists:orders,id",
            "client_email" => "required|email",
            "partner_id" => "required|integer|exists:partners,id",
            "status" => "required|integer|in:" .  implode(',', array_column(Order::STATUS, 'id'))
        ];
    }
}
