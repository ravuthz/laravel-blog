<?php

namespace App;

use App\Traits\CrudsModelTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use CrudsModelTrait;

    /**
     * Validate both, create and update
     * @var array
     */
    protected $validateRules = [
        'name' => 'required||max:25',
        'guard_name' => 'required'
    ];

    /**
     * Validate only create action
     * @var array
     */
//    protected $createValidateRules = [];

    /**
     * Validate only update action
     * @var array
     */
//    protected $updateValidateRules = [];

}
