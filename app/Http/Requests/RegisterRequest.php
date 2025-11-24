<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class RegisterRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules() {
        return [
            'name'=>'required|string|max:150',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            'telefono'=>'nullable|string|max:20',
            'perfil'=>'required|in:admin,editor,user',
        ];
    }
}
