<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Traits\CrudsControllerTrait;

class RoleController extends Controller
{
    use CrudsControllerTrait;
    
    protected $itemName = 'role_item';
    protected $listName = 'role_list';
    
    protected $modelPath = Role::class;
    protected $viewPrefix = 'roles.';
    protected $routePrefix = 'roles';
    
    public function __construct() {
        $this->initialize();
    }
}
