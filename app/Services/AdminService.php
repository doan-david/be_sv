<?php

namespace App\Services;

use App\Repository\Admin\AdminRepository;

class AdminService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAll()
    {
        return response()->json($this->adminRepository->all());
    }

    public function find($id)
    {
        return $this->adminRepository->find($id);
    }

    public function store($data)
    {
        $dataStore = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'image' => $data['image'],
            'status' => $data['status'],
            'role_id' => $data['role_id'],
            'created_at' => now(),
            'updated_at' => now()
        ];
        return $this->adminRepository->store($dataStore);
    }

    public function update($id, $data)
    {
        $dataUpdate = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'image' => $data['image'],
            'status' => $data['status'],
            'role_id' => $data['role_id'],
            'updated_at' => now()
        ];
        return $this->adminRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->adminRepository->delete($id);
    }
}
