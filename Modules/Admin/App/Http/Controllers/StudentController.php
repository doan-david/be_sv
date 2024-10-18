<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(StudentRequest $request)
    {
        try {
            if (!$data = $this->studentService->getListOrderBy($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function showStudentList(StudentRequest $request)
    {
        try {
            if (!$class = $this->studentService->getListById($request->all())) return response()->json("Bad request!", 404);
            return response()->json($class);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function hasByCode($code)
    {
        try {
            if (!$data = $this->studentService->hasByCode($code)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function hasByEmail($email)
    {
        try {
            if (!$data = $this->studentService->hasByEmail($email)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function hasByPhone($phone)
    {
        try {
            if (!$data = $this->studentService->hasByPhone($phone)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function store(StudentRequest $request)
    {
        try {
            return $this->studentService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function show($id)
    {
        try {
            if (!$class = $this->studentService->find($id)) return response()->json("Bad request!", 404);
            return response()->json($class);
        }
        catch (\Exception $e) {
            abort(500);
        }
    }

    public function update($id, StudentRequest $request)
    {
        try {
            return $this->studentService->update($id, $request->all());
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updateStatus($id, StudentRequest $request)
    {
        try {
            return $this->studentService->updateStatus($id, $request->all());
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->studentService->delete($id)) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e){
            return response()->json(500);
        }
    }

    public function deleteMultiple(StudentRequest $request)
    {
        try {
            $ids = $request->input('ids');
            if(!$this->studentService->deleteMultiple($ids)) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

    public function record($id)
    {
//        Mass assignment
        try {
            if (!$record = $this->studentService->record($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function recordMultiple(StudentRequest $request)
    {
        try {
            if (!$record = $this->studentService->recordMulti($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function importExcelData(StudentRequest $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);
            if (!$import = Excel::import(new StudentsImport, $request->file('file'))) return response()->json("Bad request!", 404);
            return response()->json(['data'=>'Users imported successfully.', $import]);
        }catch(\Exception $ex){
            Log::info($ex);
            return response()->json(['data'=>'Some error has occur.']);
        }
    }

    public function exportCsv(StudentRequest $request)
    {
        return $this->studentService->exportItemsToCsv($request->all());
    }

    public function exportXlsx(StudentRequest $request)
    {
        return $this->studentService->exportItemsToXlsx($request->all());
    }

    public function search(StudentRequest $request)
    {
        try {
            $data = $request->all();
            if (empty($data)) {
                if (!$search = $this->studentService->getAll()) return response()->json("Bad request!", 404);
            } else {
                if (!$search = $this->studentService->search($request->all())) return response()->json("Bad request!", 404);
            }
            return response()->json($search);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function recycle()
    {
        try {
            if (!$data = $this->studentService->recycle()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            abort(500);
        }
    }
}
