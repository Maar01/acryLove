<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FUser extends Model
{
    protected $attributes = ['email', 'email_password', 'f_password',  'f_profile_name'];
}
