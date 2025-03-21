<?php

namespace App\Http\Requests\Llamada;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_date' => 'required|date',
            'program_date' => 'nullable|date',
            'is_success' => 'required|boolean',
            'comment' => 'nullable|string',
            'audio_path' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
        ];
    }
}
