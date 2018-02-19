<?php

namespace App\Traits;

trait CrudsModelTrait {

    /**
     * Get only validate rules for create action
     * @return validation rules
     */
    public function getCreateValidationRules() {
        if (isset($this->createValidateRules)) {
            $this->validateRules = $this->createValidateRules;
        }
        return $this->validateRules;
    }

    /**
     * Get only validate rules for update action
     * @return validation rules
     */
    public function getUpdateValidationRules() {
        if (isset($this->updateValidateRules)) {
            $this->validateRules = $this->updateValidateRules;
        }
        return $this->validateRules;
    }

    /**
     * Create or Update data with provide request
     */
    public function saveOrUpdate($request) {
        return $this->fill($request->all())->save();
    }
    
}