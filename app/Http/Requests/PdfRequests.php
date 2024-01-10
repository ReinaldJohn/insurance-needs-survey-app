<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data.state_id' =>  'required|integer',
            'data.trades_performed' => 'required',
            'data.company' => 'required|string|max:100',
            'data.firstname' => 'required|string|max:100',
            'data.lastname' => 'required|string|max:100',
            'data.address' => 'required|string|string',
            'data.city' => 'required|string|max:100',
            'data.zipcode' => 'required|string|max:5',
            'data.email' => 'required|email|max:50',
            'data.phone_no' => 'required|string|max:15',
            'data.does_perform_residential_work' => 'required|boolean',
            'data.does_perform_commercial_work' => 'required|boolean',
            'data.does_have_employee' => 'required|boolean',
            'data.does_use_vehicle_in_work' => 'required|boolean',
            'data.does_work_property_above_1m' => 'required|boolean',
            'data.does_rent_equipment_or_add_up_10k' => 'required|boolean',
            'data.does_rent_office_other_than_home' => 'required|boolean',
            'data.does_maintain_licenses' => 'required|boolean',
            'data.are_you_gc_performs_remodeling' => 'required|boolean',
            'data.does_transport_materials_above_10k' => 'required|boolean',
            'data.does_perform_design_bldg_for_fee' => 'required|boolean',
            'data.does_your_website_collect_personal_info' => 'required|boolean',
            'data.does_store_transport_pollutants' => 'required|boolean',
            'data.does_use_subcontractors' => 'required|boolean'
        ];

        // Log::info();
    }
}
