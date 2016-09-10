<?php
namespace Modules\Relations\Requests\Relation;

use App\Http\Requests\Request;

class UpdateRelationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('relation-update');
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
            'company_name' => 'required',
            'vat' => 'max:8',
            'email' => 'required',
            'address' => '',
            'zipcode' => 'max:4',
            'city' => '',
            'primary_number' => 'max:10',
            'secondary_number' => 'max:10',
            'industry' => '',
            'company_type' => '',
            'fk_staff_id' => 'required'
        ];
    }
}
