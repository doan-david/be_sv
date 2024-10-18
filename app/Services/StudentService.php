<?php

namespace App\Services;

use App\Exports\StudentsExport;
use App\Repository\Student\StudentRepository;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getAll()
    {
        return  $this->studentRepository->all();
    }

    public function getListOrderBy($request)
    {
        return $this->studentRepository->getListOrderBy($request);
    }

    public function getListById($ids)
    {
        return $this->studentRepository->findByIds($ids);
    }

    public function find($id)
    {
        return  $this->studentRepository->find($id);
    }

    public function hasByCode($code)
    {
        return $this->studentRepository->hasByCode($code);
    }

    public function hasByEmail($email)
    {
        return $this->studentRepository->hasByEmail($email);
    }

    public function hasByPhone($phone)
    {
        return $this->studentRepository->hasByPhone($phone);
    }

    public function store($data)
    {
        $path = $data['image']->store('public/profile');
        $urlImage = substr($path, strlen('public/'));

        $birthday = $data['birthday'];
        $formattedBirthday = Carbon::parse($birthday)->format('Y-m-d');

        $dataStore = [
            'code' => $data['code'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'gender' => $data['gender'],
            'birthday' => $formattedBirthday,
            'phone' => $data['phone'],
            'address' => $data['address'],
            'hobby' => $data['hobby'],
            'status' => $data['status'],
            'image' => $urlImage,
//            'description' => $data['description'],
//            'admin_id' => $data['admin_id'],
//            'class_id' => $data['class_id'],
            'created_at' => now(),
            'updated_at' => now()
        ];
        return $this->studentRepository->store($dataStore);
    }

    public function update($id, $data)
    {
        $dataUpdate = [
            'code' => $data['code'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => $data['password'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'birthday' => $data['birthday'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'hobby' => $data['hobby'],
            'status' => $data['status'],
            'image' => $data['image'],
            'description' => $data['description'],
//            'admin_id' => $data['admin_id'],
            'class_id' => $data['class_id'],
            'updated_at' => now()
        ];
        return $this->studentRepository->update($id, $dataUpdate);
    }

    public function updateStatus($id, $status)
    {
        return $this->studentRepository->update($id, $status);
    }

    public function delete($id)
    {
        return $this->studentRepository->delete($id);
    }

    public function deleteMultiple(array $ids)
    {
        return $this->studentRepository->deleteMultiple($ids);
    }

    public function storeImage(Request $request)
    {
        $path = $request->file('file')->store('public/storage', 'public');
        return substr($path, strlen('public/'));
    }

    public function record($id)
    {
        if(!$class = $this->studentRepository->find($id)) return abort(404);

        //edit code
        $baseCode = preg_replace('/\(\d+\)$/', '', $class->code);
        $baseCode = preg_replace('/-copy/', '', $baseCode);
        $existingClasses = $this->studentRepository->getByBaseCode($baseCode);

        $highestNumber = 0;
        foreach ($existingClasses as $existingClass) {
            preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
            if (!empty($matches[1])) {
                $highestNumber = max($highestNumber, (int)$matches[1]);
            }
        }
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
            if (!$class = $this->studentRepository->find($id)) return abort(404);

            //edit code
            $baseCode = preg_replace('/\(\d+\)$/', '', $class->code);
            $baseCode = preg_replace('/-copy/', '', $baseCode);
            $existingClasses = $this->studentRepository->getByBaseCode($baseCode);

            $highestNumber = 0;
            foreach ($existingClasses as $existingClass) {
                preg_match('/\((\d+)\)$/', $existingClass->code, $matches);
                if (!empty($matches[1])) {
                    $highestNumber = max($highestNumber, (int)$matches[1]);
                }
            }
            $newCode = $baseCode . '-copy(' . ($highestNumber + 1) . ')';
            $class->code = $newCode;

//            edit name
            $baseName = preg_replace('/\(\d+\)$/', '', $class->name);
            $baseName = preg_replace('/-copy/', '', $baseName);
            $newName = $baseName . '-copy(' . ($highestNumber + 1) . ')';
            $class->name = $newName;

            //end
            $newClass = $class->replicate();
            $newClass->save();
            $data[] = $newClass;
        }
        return $data;
    }

    public function search($dataSearch)
    {
        return $this->studentRepository->search($dataSearch);
    }

    public function exportItemsToCsv(array $ids)
    {
        $students = $this->studentRepository->findByIds($ids);
        return Excel::download(new StudentsExport($students), 'students.csv');
    }

    public function exportItemsToXlsx(array $ids)
    {
        $students = $this->studentRepository->findByIds($ids);
        return Excel::download(new StudentsExport($students), 'students.xlsx');
    }

    public function recycle()
    {
        return $this->studentRepository->recycle();
    }
}
