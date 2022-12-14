<?php
   
namespace App\Http\Controllers;
   
use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'min:5|max:200',
            'role_id' => 'required|integer|min:1|max:2',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'pic' => 'mimes:jpg,jpeg,bmp,png|max:10000'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if ($file = $request->file('pic'))
        {
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/public/images/';
            $destinationPath = base_path() . $folderName;
            $safeName        = Str::random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);

            $input['pic'] = $safeName;
        }
        
        $user = User::create($input);
        $success['token'] =  $user->createToken('consult')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->sendError([], 'The provided credentials are incorrect.');
        }
        
        $success['token'] =  $user->createToken('consult')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User login successfully.');
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'User logged out successfully.');
    }

}