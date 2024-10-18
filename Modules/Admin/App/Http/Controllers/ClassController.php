<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Exports\ClassesExport;
use App\Http\Controllers\Controller;
use App\Imports\ClassesImport;
use App\Services\ClassService;
use App\Services\StudentService;
use http\Message;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\App\Http\Requests\BaseRequest;
use Modules\Admin\App\Http\Requests\ClassRequest;
use Modules\Admin\App\Http\Requests\ExportRequest;
use function Laravel\Prompts\alert;

class ClassController extends Controller
{
    private $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index(ClassRequest $request)
    {
        try {
            if (!$data = $this->classService->getListOrderBy($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function search(ClassRequest $request)
    {
        try {
            if (!$search = $this->classService->search($request->all())) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByCode($code)
    {
        try {
            if (!$search = $this->classService->hasByCode($code)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByName($name)
    {
        try {
            if (!$search = $this->classService->hasByName($name)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function getClassList(ClassRequest $request)
    {
        try {
            if (!$data = $this->classService->getAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showClassListByCode(ClassRequest $request)
    {
        try {
            try {
                if (!$data = $this->classService->getListByCodes($request->all())) return response()->json("Bad request!", 404);
                return response()->json($data);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showStudentList($classId)
    {
        try {
            if (!$students = $this->classService->getStudentsByClassId($classId)) return response()->json("Bad request!", 404);
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasStudentList()
    {
        try {
            if (!$data = $this->classService->hasStudents())  return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            if (!$class = $this->classService->withTrashedById($id)) return response()->json("Bad request!", 404);
            return response()->json($class);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(ClassRequest $request)
    {
        try {
            return $this->classService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function update($id, ClassRequest $request)
    {
        try {
            if (!$this->classService->update($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($id, ClassRequest $request)
    {
        try {
            if (!$this->classService->updateStatus($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->classService->delete($id)) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteMultiple(ClassRequest $request)
    {
        try {
            if(!$data = $this->classService->deleteMultiple($request->all())) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function record($id)
    {
        try {
            if (!$record = $this->classService->record($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function recordMultiple(ClassRequest $request)
    {
        try {
            if (!$record = $this->classService->recordMulti($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function importExcelData(ClassRequest $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);
            if (!$import = Excel::import(new ClassesImport, $request->file('file'))) return response()->json("Bad request!", 404);
            return response()->json(['data'=>'Users imported successfully.', $import]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function exportCsv(ExportRequest $request)
    {
        return $this->classService->exportItemsToCsv($request->all());
    }

    public function exportXlsx(ExportRequest $request)
    {
        try {
            return $this->classService->exportItemsToXlsx($request->all());
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//    public function search(ClassRequest $request)
//    {
//        try {
//            $data = $request->all();
//            if (empty($data)) {
//                if (!$search = $this->classService->getAll()) return abort(404);
//            } else {
//                if (!$search = $this->classService->search($request->all())) return abort(404);
//            }
//            return response()->json($search);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }

    //recycle
    public function recycle(ClassRequest $request)
    {
        try {
            if (!$data = $this->classService->onlyTrashed($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showRecycled($id)
    {
        try {
            if (!$data = $this->classService->onlyTrashedById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            if (!$data = $this->classService->restoreById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreMultiple($ids)
    {
        try {
            if (!$data = $this->classService->restoreByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreAll()
    {
        try {
            if (!$data = $this->classService->restoreAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            if (!$data = $this->classService->forceDeleteById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteMultiple($ids)
    {
        try {
            if (!$data = $this->classService->forceDeleteByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteAll()
    {
        try {
            if (!$data = $this->classService->forceDeleteAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
