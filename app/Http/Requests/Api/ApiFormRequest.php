<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

abstract class ApiFormRequest extends FormRequest
{

        /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

        /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $error = [
            'status' => false,
            'message' => 'Validation error', //Massage Return in Response Data field
            'errors' => $validator->errors() //Validator Errors
        ];

        throw new HttpResponseException(response()->json($error, JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
