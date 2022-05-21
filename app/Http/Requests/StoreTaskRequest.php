<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{

    /** this will change response as our common response */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "data" => [ "message" => $validator->errors()->first()]
        ], 202));
    }

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' =>  Rule::in(['New', 'Incomplete', 'Complete']),
            'priority' =>  Rule::in(['High', 'Medium', 'Low']),
            'notes' => 'nullable|array',
            'notes.*.subject' => 'required|string',
            'notes.*.attachments' => 'nullable|array',
            'notes.*.attachments.*' => 'file',
        ];
    }
}
