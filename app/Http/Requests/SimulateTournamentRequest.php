<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulateTournamentRequest extends FormRequest
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
            'players' => 'required|array|min:2',
            'players.*.name' => 'required|string',
            'players.*.skill_level' => 'required|integer|min:0|max:100',
            'players.*.gender' => 'required|in:Male,Female',
            'players.*.strength' => 'nullable|integer|min:0|max:100',
            'players.*.speed' => 'nullable|integer|min:0|max:100',
            'players.*.reaction_time' => 'nullable|integer|min:0|max:100',
            'type' => 'required|in:Male,Female',
        ];
    }
}

