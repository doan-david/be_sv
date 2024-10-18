<?php

namespace App\Services;

use App\Exports\ClassesExport;
use App\Repository\Class\ClassRepository;
use Maatwebsite\Excel\Facades\Excel;

class ClassService {
    private $classRepository;

    public function __construct(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function getAll()
    {
        return $this->classRepository->all();
    }

    public function search($dataSearch)
    {
        $data = [];
//        if (!empty($dataSearch['code']))
//        {
//            $data = $this->classRepository->searchByCode($dataSearch);
//        }
        if (!empty($dataSearch['name']))
        {
            $data = $this->classRepository->searchByName($dataSearch);
        }
//        if (!empty($dataSearch['mentor']))
//        {
//            $data = $this->classRepository->searchByMentor($dataSearch);
//        }
        return $data;
    }

    public function getListById($ids)
    {
        return $this->classRepository->findByIds($ids);
    }

    public function getListByCodes($request)
    {
        return $this->classRepository->findByCodes($request);
    }

    public function find($id)
    {
        return $this->classRepository->find($id);
    }

    public function getStudentsByClassId($classId)
    {
        return $this->classRepository->getStudentsByClassId($classId);
    }

    public function hasStudents()
    {
        return $this->classRepository->hasStudent();
    }

    public function hasByCode($code)
    {
        return $this->classRepository->hasByCode($code);
    }

    public function hasByName($name)
    {
        return $this->classRepository->hasByName($name);
    }

    public function getListUpdateOrderByDesc($data)
    {
        return $this->classRepository->getListUpdateOrderByDesc($data);
    }

    public function getListOrderBy($request)
    {
        return $this->classRepository->getListOrderBy($request);
    }

    public function store($data)
    {
        $dataStore = [
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'mentor' => $data['mentor'],
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        return $this->classRepository->store($dataStore);
    }

    public function update($id, $data)
    {
        $dataUpdate = [
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'mentor' => $data['mentor'],
            'status' => $data['status'],
            'updated_at' => now(),
        ];
        return $this->classRepository->update($id, $dataUpdate);
    }

    public function updateStatus($id, $data)
    {
        $dataUpdate = [ 'status' => $data['status'], 'updated_at' => now() ];
        return $this->classRepository->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        return $this->classRepository->delete($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->classRepository->deleteMultiple($ids);
    }

    public function record($id)
    {
        if(!$class = $this->classRepository->find($id)) return abort(404);

        //edit code
        $baseCode = preg_replace('/\(\d+\)$/', '', $class->code);
        $baseCode = preg_replace('/-copy/', '', $baseCode);
        $existingClasses = $this->classRepository->getByBaseCode($baseCode);

        $highestNumber = 0;
        foreach ($existingClasses as $existingClass) {
            preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
//        dd($highestNumber);
        $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
        $class->code = $newCode;

        //edit name
        $baseName = preg_replace('/\(\d+\)$/', '', $class->name);
        $baseName = preg_replace('/-copy/', '', $baseName);
        $newName = $baseName . '-copy(' . ($highestNumber + 1) . ')';
        $class->name = $newName;

        //end
        $newClass = $class->replicate();
        $newClass->save();

        return $newClass;
    }

    public function recordMulti($ids)
    {
        $data = [];
        foreach ($ids as $id) {
            if (!$class = $this->classRepository->find($id)) return abort(404);
            $baseCode = preg_replace('/\(\d+\)$/', '', $class->code);
            $baseCode = preg_replace('/-copy/', '', $baseCode);
            $existingClasses = $this->classRepository->getByBaseCode($baseCode);
            $highestNumber = 0;
            foreach ($existingClasses as $existingClass) {
                preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }
            $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
            $class->code = $newCode;
            $baseName = preg_replace('/\(\d+\)$/', '', $class->name);
            $baseName = preg_replace('/-copy/', '', $baseName);
            $newName = $baseName . '-copy(' . ($highestNumber + 1) . ')';
            $class->name = $newName;
            $newClass = $class->replicate();
            $newClass->save();
            $data[] = $newClass;
        }
        return $data;
    }

    public function exportItemsToCsv($ids)
    {
        $classes = $this->classRepository->findByIds($ids);
        return Excel::download(new ClassesExport($classes), 'classes.csv');
    }

    public function exportItemsToXlsx($ids)
    {
        $classes = $this->classRepository->findByIds($ids);
        if ($classes->isEmpty()) {
            throw new \Exception('No classes found for the provided IDs.');
        }
        return Excel::download(new ClassesExport($classes), 'classes.xlsx');
    }

    //recycle
    public function onlyTrashed($data)
    {
        return $this->classRepository->onlyTrashed($data);
    }

    public function onlyTrashedById($id)
    {
        return $this->classRepository->onlyTrashedById($id);
    }

    public function withTrashedById($id)
    {
        return $this->classRepository->withTrashedById($id);
    }

    public function restoreById($id)
    {
        return $this->classRepository->restoreById($id);
    }

    public function restoreByIds($ids)
    {
        return $this->classRepository->restoreByIds($ids);
    }

    public function restoreAll()
    {
        return $this->classRepository->restoreAll();
    }

    public function forceDeleteById($id)
    {
        return $this->classRepository->forceDeleteById($id);
    }

    public function forceDeleteByIds($ids)
    {
        return $this->classRepository->forceDeleteByIds($ids);
    }
    public function forceDeleteAll()
    {
        return $this->classRepository->forceDeleteAll();
    }
}
