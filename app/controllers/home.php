<?php


class Home extends Controller {

    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;
        
       return $this->view('home/index', ['name'=> $name]);
    }

    public function create($name= '', $email = ''){
        User::create([
            'name'=>$name,
            'email'=>$email
        ]);

        $a = User::where('id',2)->first();
       print_r($a->name);


    }
}