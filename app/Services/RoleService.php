<?php

namespace App\Services;

use App\Repository\Role\RoleRepository;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        $data = $this->roleRepository->all();
        if(!$data) return abort(500);
        return response()->json($data);
    }

    public function find($id)
    {
        return response()->json($this->roleRepository->find($id));
    }

    public function store($data)
    {
        $dataStore = [
            'name' => $data['name'],
            'description' => $data['description'],
            'created_at' => now(),
            'updated_at' => now()
        ];
        return $this->roleRepository->store($dataStore);
    }

    public function update($id, $data)
    {
        $dataUpdate = [
            'name' => $data['name'],
            'description' => $data['description'],
            'updated_at' => now()
        ];
        return $this->roleRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }
}
