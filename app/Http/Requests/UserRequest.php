<?php

namespace App\Http\Requests;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $check = [];

        $newPassword = Request::get('password');
        $email = Request::get('email');
        $oldEmail = Request::get('old_email');
        if(!empty($newPassword)){
            $check['password'] = 'required|min:6|confirmed';
            $check['password_confirmation'] = 'required|min:6';
        }
        if($email != $oldEmail){
            $check['email'] = 'required|unique:users|email';
        }
        return $check;
    }
}
