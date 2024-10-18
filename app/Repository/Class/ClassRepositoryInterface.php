<?php

namespace App\Repository\Class;

interface ClassRepositoryInterface
{
    public function all();

    public function find($id);

    public function findByIds($ids);

    public function findByCodes($request);

    public function getPaginate($data);

    public function getStudentsByClassId($classId);

    public function hasStudent();

    public function getListOrderBy($dataIndex);

    public function hasByCode($code);

    public function hasByName($name);

    public function searchByMentor($mentor);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function deleteMultiple(array $ids);


    public function getByBaseCode($baseCode);

    public function onlyTrashed();

    public function onlyTrashedById($id);

    public function withTrashedById($id);

    public function restoreById($id);

    public function restoreByIds($ids);

    public function restoreAll($id);

    public function forceDeleteById($id);

    public function forceDeleteByIds($ids);

    public function forceDeleteAll($id);
}
