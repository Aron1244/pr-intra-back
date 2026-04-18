<?php

namespace App\Http\Requests;

use App\Models\Announcement;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Announcement|null $announcement */
        $announcement = $this->route('announcement');

        return $announcement !== null
            && ($this->user()?->can('update', $announcement) ?? false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'department_id' => ['sometimes', 'integer', 'exists:departments,id'],
        ];
    }
}
