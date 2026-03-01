<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', new Enum(TaskPriority::class)],
            'due_date' => ['nullable', 'date', 'after:now'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.string' => 'Judul tugas harus berupa teks.',
            'title.max' => 'Judul tugas maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'priority.Illuminate\Validation\Rules\Enum' => 'Prioritas tidak valid (low, medium, high).',
            'due_date.date' => 'Batas waktu harus berupa format tanggal yang valid.',
            'due_date.after' => 'Batas waktu harus waktu atau tanggal di masa depan.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (is_null($this->priority)) {
            $this->merge([
                'priority' => TaskPriority::MEDIUM->value,
            ]);
        }
    }
}