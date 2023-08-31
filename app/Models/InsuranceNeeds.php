<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceNeeds extends Model
{
    use HasFactory;

    protected $table = "information";
    protected $guard = [];

    public function getAllStates() {
        return $this->select('id', 'abbr', 'statesname')->from('states')->get();
    }

    public function getAllProfessions() {
        return $this->select('*')->from('calculator_trades')->get();
    }

    public function getStatesById($id) {
        $states = $this->select('abbr')->from('states')->where('id', $id)->first();
        return $states ? $states->abbr : null;
    }

    public function getProfessionById($id) {
        $profession = $this->select('tradename', 'gl_iso', 'description')->from('calculator_trades')->where('id', $id)->first();
        return $profession ? $profession->name : null;
    }

}
