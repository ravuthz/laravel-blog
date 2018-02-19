<?php

namespace App\Http\Controllers;

use App\Role;
use App\Traits\CrudsControllerTrait;

class RoleController extends Controller
{
    use CrudsControllerTrait;

    protected $itemName = 'role_item';
    protected $listName = 'role_list';

    protected $modelPath = Role::class;
    protected $viewPrefix = 'roles.';
    protected $routePrefix = 'roles';

    public function __construct()
    {
        $this->initialize();
        $this->setPageTitle("Role");
        $this->setSiteTitle("Roles");
    }

    // Override query all data with search form
    public function getFilterData($request = null)
    {
        $query = Role::select();
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->get('name'));
        }
        if ($request->has('guard_name')) {
            $query->where('guard_name', 'LIKE', '%' . $request->get('guard_name') . '%');
        }
        return $query->paginate(10);
    }
}
