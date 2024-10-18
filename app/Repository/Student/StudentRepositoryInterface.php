<?php

namespace App\Repository\Student;

interface StudentRepositoryInterface
{
    public function all();

    public function getListOrderBy($request);

    public function find($id);

    public function findByIds(array $ids);

    public function hasByCode($code);

    public function hasByEmail($email);

    public function hasByPhone($phone);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function deleteMultiple(array $ids);


    public function getByBaseCode($baseCode);

    public function search($dataSearch);

    public function recycle();
}
