<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceSurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Fetch additional data using model methods
        $stateAbbr = $this->getStatesById($this->state_id);
        // Assuming $this->trades_id is ["2","3","4"]
        $tradesIds = json_decode($this->trades_id); // Convert the JSON array to a PHP array if needed

        // Initialize an empty array to store the profession details
        $professionDetails = [];

        // Loop through each ID and call getProfessionById for each
        foreach ($tradesIds as $id) {
            $professionName = $this->getProfessionById($id);

            // Check if a profession name was found and add it to the array
            if ($professionName) {
                $professionDetails[] = $professionName;
            }
        }

        $utms = $this->getUTMSStatus($this->id);

        return [
            'id' => $this->id,
            'state_id' => $stateAbbr,
            'trades_id' => $professionDetails,
            'company_name' => $this->company_name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'does_perform_residential_work' => (bool) $this->does_perform_residential_work,
            'does_perform_commercial_work' => (bool) $this->does_perform_commercial_work,
            'does_have_employee' => (bool) $this->does_have_employee,
            'does_use_vehicle_in_work' => (bool) $this->does_use_vehicle_in_work,
            'does_work_property_above_1m' => (bool) $this->does_work_property_above_1m,
            'does_rent_equipment_or_add_up_10k' => (bool) $this->does_rent_equipment_or_add_up_10k,
            'does_rent_office_other_than_home' => (bool) $this->does_rent_office_other_than_home,
            'does_maintain_licenses' => (bool) $this->does_maintain_licenses,
            'are_you_gc_performs_remodeling' => (bool) $this->are_you_gc_performs_remodeling,
            'does_transport_materials_above_10k' => (bool) $this->does_transport_materials_above_10k,
            'does_perform_design_bldg_for_fee' => (bool) $this->does_perform_design_bldg_for_fee,
            'does_your_website_collect_personal_info' => (bool) $this->does_your_website_collect_personal_info,
            'does_store_transport_pollutants' => (bool) $this->does_store_transport_pollutants,
            'does_use_subcontractors' => (bool) $this->does_use_subcontractors,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'utms' => $utms,
        ];

    }
}