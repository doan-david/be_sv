<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use \Modules\Admin\App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return $this->roleService->getAll();
    }

    public function show($id)
    {
        return $this->roleService->find($id);
    }

    public function store(RoleRequest $request)
    {
        return $this->roleService->store($request);
    }

    public function update($id, RoleRequest $request)
    {
        return $this->roleService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->roleService->delete($id);
    }
}
