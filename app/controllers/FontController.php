<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Font;
use Illuminate\Http\Request;
use App\Config\Config;

class FontController extends Controller {

    public function index()
    {
        return $this->view('home/index');
    }
    
    public function upload()
    {
        $request = Request::capture();
        $file = $request->file('font');
        $fileName = $file->getClientOriginalName()  ;
        $fileTmp = $file->getRealPath();

        $errors = $this->validate($request->all(), [
                   'font' => 'required|file|mimes:ttf|max:2048'
                ]);

        if (!empty($errors)) {
            $this->validationError($errors);
            return;
        }

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, Config::ALLOWED_EXTENSIONS)) {
            return $this->error('Only TTF files are allowed');
        }
        
        $newFileName = uniqid('font_', true) . '.' . $fileExt;
        $uploadPath = Config::FONT_UPLOAD_DIR . $newFileName;
        
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            $font = Font::create([
                'name' => pathinfo($fileName, PATHINFO_FILENAME),
                'filename' => $newFileName,
                'path' => $uploadPath
            ]);
            return $this->success(
                ['font' => $font],
                'Font uploaded successfully',
                201
            );
        }
        
    }
    
    public function list()
    {
        $request = Request::capture();
        $perPage = 2;
        $currentPage = $request->query('page', 1);
        $fonts = Font::skip(($currentPage - 1) * $perPage)->take($perPage)->get();
        $total = Font::count();
        
        return $this->paginate($fonts, $total, $perPage, $currentPage);
    }

    public function destroy($id)
        {
            $font = Font::find($id);
            if (!$font) {
            return $this->notFound('Font not found');
        }
        unlink(Config::FONT_UPLOAD_DIR . $font->filename);
        
        $font->delete();
        
        return $this->success(['success' => true, 'message' => 'Font deleted successfully']);   
    }
    

}