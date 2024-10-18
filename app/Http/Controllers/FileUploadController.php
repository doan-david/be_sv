<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function storeImage(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,pdf|max:2048',
        ]);

        $path = $request->file('file')->store('public/storage', 'public');
        return substr($path, strlen('public/'));
    }
}
