<?php
namespace Modules\Employees\Http\Requests\Staff;

use App\Http\Requests\Request;

class StoreStaffRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('user-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'address' => '',
            'work_number' => 'numeric',
            'personal_number' => 'numeric',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
            'image_path' => '',
            'roles' => 'required',
            'departments' => 'required'
        ];
    }
}
