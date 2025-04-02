<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\FontGroup;
use Illuminate\Http\Request;

class FontGroupController  extends Controller {

    public function index()
    {
        $request = Request::capture();
        $perPage = 10;
        $currentPage = $request->query('page', 1);
                
        $groups = FontGroup::with('fonts')->skip(($currentPage - 1) * $perPage)->take($perPage)->get();
        $total = FontGroup::count();
        
        return $this->paginate($groups, $total, $perPage, $currentPage);
       
    }
    
    public function store()
    {
        $request = Request::capture();
        
        $errors = $this->validate($request->all(), [
            'name' => 'required|String|max:255',
            'fonts' => 'required|Array|min:2',
            'fonts.*' => 'exists:fonts,id'
         ]);

         if(count($request->fonts) < 2){
            return $this->error('Error creating font group. Please select at least 2 fonts.');
         }

            if (!empty($errors)) {
                $this->validationError($errors);
                return;
            }
     
        
        $group = FontGroup::create(['name' => $request->name]);
        
        foreach ($request->fonts as $index => $fontId) {
            $group->fonts()->attach($fontId, ['order' => $index]);
        }
        
        return $this->success(
            ['group' => $group->load('fonts')],
            'Font group created successfully',
            201
        );
       
    }

    public function show($id) {
        $group = FontGroup::find($id);
        
        if (!$group) {
            return $this->notFound('Font group not found');
        }
        
        return $this->success(['group' => $group->load('fonts')]);
    }
    
    public function update($id)
    {
        $request = Request::capture();
        $group = FontGroup::find($id);
        if (!$group) {
            return $this->notFound('Font group not found');
        }
        $errors = $this->validate($request->all(), [
            'name' => 'required|string|max:255',
            'fonts' => 'required|array|min:2',
            'fonts.*' => 'exists:fonts,id'
        ]);

        if (!empty($errors)) {
            $this->validationError($errors);
            return;
        }
        
        $group->update(['name' => $request->name]);
        $group->fonts()->detach();
        
        foreach ($request->fonts as $index => $fontId) {
            $group->fonts()->attach($fontId, ['order' => $index]);
        }
        
        return $this->success(['group' => $group->load('fonts')]);
    }
    
    public function destroy($id)
    {
        FontGroup::find($id)->delete();
        return $this->success(['success' => true]);
    }
   
}