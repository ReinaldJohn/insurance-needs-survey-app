<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->integer('state_id')->constrained('states');
            $table->text('trades_id');
            $table->string('company_name', 100);
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->text('address');
            $table->string('city', 100);
            $table->string('zipcode', 5);
            $table->string('email', 50);
            $table->string('phone_no', 15);
            $table->boolean('does_perform_residential_work');
            $table->boolean('does_perform_commercial_work');
            $table->boolean('does_have_employee');
            $table->boolean('does_use_vehicle_in_work');
            $table->boolean('does_work_property_above_1m');
            $table->boolean('does_rent_equipment_or_add_up_10k');
            $table->boolean('does_rent_office_other_than_home');
            $table->boolean('does_maintain_licenses');
            $table->boolean('are_you_gc_performs_remodeling');
            $table->boolean('does_transport_materials_above_10k');
            $table->boolean('does_perform_design_bldg_for_fee');
            $table->boolean('does_your_website_collect_personal_info');
            $table->boolean('does_store_transport_pollutants');
            $table->boolean('does_use_subcontractors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
    }
};