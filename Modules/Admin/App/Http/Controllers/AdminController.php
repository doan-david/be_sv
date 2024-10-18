<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\App\Http\Requests\AdminRequest;
use App\Services\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        return $this->adminService->getAll();
    }

    public function show($id)
    {
        return $this->adminService->find($id);
    }

    public function store(AdminRequest $request)
    {
        try {
            return $this->adminService->store($request->all());
        }catch (\Exception $exception){}
        {
            dd($exception->getMessage());
        }

    }

    public function update(AdminRequest $request, $id)
    {
        return $this->adminService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->adminService->delete($id);
    }
}
