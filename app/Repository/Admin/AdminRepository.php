<?php

namespace App\Repository\Admin;

use App\Models\Admin;

class AdminRepository
{
    private $adminModel;

    public function __construct(Admin $adminModel)
    {
        return $this->adminModel = $adminModel;
    }

    public function all()
    {
        return $this->adminModel->all();
    }

    public function find($id)
    {
        return $this->adminModel->where('id', $id)->first();
    }

    public function store($data)
    {
        return $this->adminModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->adminModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->adminModel->destroy($id);
    }
}
