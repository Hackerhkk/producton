<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportQuestionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please select an Excel file.',
            'file.file' => 'The uploaded file is invalid.',
            'file.mimes' => 'Only XLSX, XLS or CSV files are allowed.',
            'file.max' => 'The file size cannot exceed 10 MB.',
        ];
    }
}
