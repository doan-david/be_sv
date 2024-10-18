<?php

namespace App\Repository\Role;

use App\Models\Role;

class RoleRepository
{
    private $roleModel;

    public function __construct(Role $roleModel)
    {
        return $this->roleModel = $roleModel;
    }

    public function all()
    {
        return $this->roleModel->all();
    }

    public function find($id)
    {
        return $this->roleModel->where('id', $id)->first();
    }

    public function store($data)
    {
        return $this->roleModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->roleModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->roleModel->destroy($id);
    }
}
