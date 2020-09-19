<?php

namespace App\Http\Requests;

use App\Reserve;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReserveStoreRequest extends FormRequest
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
            "number_table" => [
                "integer",
                "digits_between:1,15",
                Rule::unique('reserves')->where(function ($query) {
                    return $query->where('number_table', $this->number_table)
                        ->where('date', $this->date)
                        ->where('restaurant_id', $this->restaurant_id);
                }),
            ],
            "restaurant_id" => [
                function ($attribute, $value, $fail) {
                    $count = Reserve::query()
                        ->where('date', $this->date)
                        ->where('restaurant_id', $this->restaurant_id)
                        ->count();
                    if ($count > 15) {
                        $fail($attribute.' is invalid.');
                    }
                },
            ]
        ];
    }
}
