<?php

namespace App\Repository\Class;

use App\Models\ClassName;

class ClassRepository
{
    private $classModel;

    public function __construct(ClassName $classModel)
    {
        return $this->classModel = $classModel;
    }

    public function all()
    {
        return $this->classModel->all();
    }

    public function getListUpdateOrderByDesc($dataSearch)
    {
        $data = $this->classModel;
        if (!empty($dataSearch['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($dataSearch['name']) . '%']);
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function getListOrderBy($request)
    {
        $data = $this->classModel;
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->withCount('students')->paginate($request['pageSize']);
    }

    public function getByBaseCode($baseCode)
    {
        return $this->classModel->withTrashed()->whereRaw('LOWER(code) like ?', ['%' . strtolower($baseCode) . '%'])->get();
    }

    public function hasByCode($code)
    {
        return$this->classModel->withTrashed()->where('code', $code)->exists();
    }

    public function hasByName($name)
    {
        return$this->classModel->withTrashed()->where('name', $name)->exists();
    }

    public function searchByMentor($dataSearch)
    {
        $data = $this->classModel;
        if (!empty($dataSearch['code']))
        {
            $data = $data->where('mentor', 'like', '%'.$dataSearch['mentor'].'%');
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function find($id)
    {
        return $this->classModel->withTrashed()->where('id', $id)->first();
    }

    public function findByIds($ids)
    {
        return $this->classModel->withTrashed()->whereIn('id', $ids)->get();
    }

    public function findByCodes($request)
    {
        $data = $this->classModel->whereIn('code', $request['codes']);
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->withCount('students')->paginate($request['pageSize']);

    }

    public function getStudentsByClassId($classId)
    {
        return $this->classModel->with('students')->find($classId);
    }

    public function hasStudent()
    {
        return $this->classModel->withCount('students')->get();
    }

    public function store($data)
    {
        return $this->classModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->classModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {

        return $this->classModel->destroy($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->classModel->whereIn('id', $ids)->delete();
    }

    // trashed
    public function onlyTrashed($dataSearch)
    {
        $data = $this->classModel->onlyTrashed();
        if (!empty($dataSearch['name']))
        {
            $data = $data->where('name', 'like', '%'.$dataSearch['name'].'%');
        }
        return $data->paginate(request()->get('pageSize', 10));
    }

    public function onlyTrashedById($id)
    {
        return $this->classModel->onlyTrashed()->where('id', $id)->first();
    }

    public function withTrashedById($id)
    {
        return $this->classModel->withTrashed()->where('id', $id)->first();
    }

    public function restoreAll()
    {
        return $this->classModel->onlyTrashed()->restore();
    }

    public function restoreByIds($ids)
    {
        return $this->classModel->onlyTrashed()->whereIn('id', $ids)->restore($ids);
    }

    public function restoreById($id)
    {
        return $this->classModel->where('id', $id)->restore($id);
    }

    public function forceDeleteById($id)
    {
        return $this->classModel->onlyTrashed()->where('id', $id)->forceDelete($id);
    }

    public function forceDeleteByIds($ids)
    {
        return $this->classModel->onlyTrashed()->whereIn('id', $ids)->forceDelete($ids);
    }

    public function forceDeleteAll()
    {
        return $this->classModel->onlyTrashed()->forceDelete();
    }
}
