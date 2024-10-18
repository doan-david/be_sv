<?php

namespace App\Repository\Student;

use App\Models\Student;

class StudentRepository
{
    private $studentModel;

    public function __construct(Student $studentModel)
    {
        return $this->studentModel = $studentModel;
    }

    public function all()
    {
        return $this->studentModel->all();
    }

    public function getListOrderBy($request)
    {
        $data = $this->studentModel;
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->paginate($request['pageSize']);
    }

    public function find($id)
    {
        return $this->studentModel->where('id', $id)->first();
    }

    public function findByIds(array $ids)
    {
        return $this->studentModel->whereIn('id', $ids)->get();
    }

    public function hasByCode($code)
    {
        return $this->studentModel->withTrashed()->where('code', $code)->exists();
    }

    public function hasByEmail($email)
    {
        return $this->studentModel->withTrashed()->where('email', $email)->exists();
    }

    public function hasByPhone($phone)
    {
        return $this->studentModel->withTrashed()->where('phone', $phone)->exists();
    }

    public function store($data)
    {
        return $this->studentModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->studentModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->studentModel->destroy($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->studentModel->destroy($ids);
    }

    public function getByBaseCode($baseCode)
    {
        return $this->studentModel->where('code', 'LIKE', $baseCode . '%' )->get();
    }

    public function findByAdminId($id)
    {
        return $this->studentModel->where('admin_id', $id)->first();
    }

    public function search($dataSearch)
    {
//        $data = $this->classModel;
        $data = $this->studentModel->with(['created_at']);
        if (!empty($dataSearch['name']))
        {
            $data = $data->where('name', 'like', '%'.$dataSearch['name'].'%');
        }
//        if (!empty($dataSearch['abvisor']))
//        {
//            $data = $data->where('abvisor', 'like', '%'.$dataSearch['abvisor'].'%');
//        }
//        if (!empty($dataSearch['code']))
//        {
//            $data = $data->where('code', $dataSearch['code']);
//        }
        return $data->get();
    }

    public function recycle()
    {
        return $this->studentModel->onlyTrashed()->get();
    }
}
