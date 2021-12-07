<?php

namespace App\Architecture\ViewModels;

use App\Models\User;

class UserViewModel
{
    public $id;
    public $name;
    public $email;
    protected $password;
    public $state;
    public $avatar;

    public function generateViewModel(User $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->email = $model->email;
        $this->password = $model->password;
        $this->state = $model->state;
        $this->avatar = $model->avatar;

        return $this;
    }
}
