<?php

namespace Spatie\MailcoachEditor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|image',
        ];
    }
}
