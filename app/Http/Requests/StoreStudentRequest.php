<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'dni_student' => 'required|integer|max:99999999|unique:students,dni_student',
      'year_id' => 'required|integer|max:6|min:1',
      'name' => 'required|string|min:1|max:36',
      'last_name' => 'required|string|min:1|max:36',
      'birthday' => 'required',
    ];
  }
}
