<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller {


    public function index(){
        $user = User::find(1);
       return $this->view('home/index', ['name'=> $user->fname]);
    }
    public function about($id){
        $name = "Delower hasan";
        return $this->view('home/index', ['name'=> $name]);
    }

    public function create(){
        $request = Request::capture();
        

        // Validate input
        $errors = $this->validate($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email'
        ]);

        if (!empty($errors)) {
            $this->validationError($errors);
            return;
        }

        // Create user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);
        
        $this->success(
            ['user' => $user],
            'User created successfully',
            201
        );
    }

    public function list(Request $request) {
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        
        $users = User::paginate($perPage, $currentPage);
        $total = User::count();
        
        return $this->paginate($users, $total, $perPage, $currentPage);
    }

    public function upload(Request $request) {
        if (!$request->hasFile('file')) {
            return $this->error('No file uploaded');
        }

        $file = $request->file('file');
        
        // Handle file upload logic here
        // For example:
        $uploadPath = 'uploads/' . $file['name'];
        move_uploaded_file($file['tmp_name'], $uploadPath);
        
        $file['path'] = $uploadPath;
        
        return $this->fileResponse($file);
    }

    public function show($id) {
        $user = User::find($id);
        
        if (!$user) {
            return $this->notFound('User not found');
        }
        
        return $this->success(['user' => $user]);
    }
}