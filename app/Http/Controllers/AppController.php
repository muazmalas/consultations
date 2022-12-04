<?php
   
namespace App\Http\Controllers;
   
use Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Appointment;
use Illuminate\Http\Request;
   
class AppController extends Controller
{  

    public function User(Request $request)
    {
        return $request->user();
    }

    public function getUsers(Request $request)
    {
        return User::with('consultations')->where('name', 'like', '%'.$request->name.'%')->where('role_id', 2)->get();
    }

    public function getUserDetails(Request $request)
    {
        return User::with('consultations')->where('id', $request->user_id)->where('role_id', 2)->get();
    }

    public function getRoles(Request $request)
    {
        return Role::all();
    }

    public function getConsultations(Request $request)
    {  
        // return Consultation::with('users')->where('consultation_type', 'Medical')->get();
        return Consultation::with(['users' => function ($query) {
            $query->select('users.id', 'email', 'name')->where('role_id', 2);
        }])->where('consultation_type', $request->type)->get();
    }


    public function getUserAppointments(Request $request)
    {  
        // return Appointment::with('user', 'expert', 'consultation')->where('user_id', $request->user_id)->get();
        return User::with('userAppointments.expert', 'userAppointments.consultation')->where('id', $request->user_id)->get();
    }

    public function getExpertAppointments(Request $request)
    {  
        // return Appointment::with('user', 'expert', 'consultation')->where('expert_id', $request->expert_id)->get();
        return User::with('userAppointments.user', 'userAppointments.consultation')->where('id', $request->user_id)->get();
    }

    public function createAppointment(Request $request)
    {  
        
        $userBalance = User::findOrFail($request->user_id)->balance;
        $consultationFee = Consultation::findOrFail($request->consultation_id)->fee_amount;
        $appointments = Appointment::where('expert_id', $request->expert_id)->where('from_time', $request->from_time)->get();

        try {
            
            if($appointments->count() == 0){

                if($userBalance >= $consultationFee){
                    
                    Appointment::create([
                        'user_id' => $request->user_id,
                        'expert_id' => $request->expert_id,
                        'consultation_id' => $request->consultation_id,
                        'from_time' => $request->from_time,
                        'to_time' => $request->to_time,
                        'status' => 'Confirmed'
                    ]);

                    User::where('id', $request->user_id)->update([
                        'balance' => $userBalance - $consultationFee
                    ]);
        
                    return 'Appointment Created Successfully';
            
                } else {
                    return "You don't have enough balance to pay for the consultation";
                }

            } else {
                return 'Expert is reserved for this time window';
            };

        } catch (\Throwable $th) {
                    
            return 'Unable to Create Appointment. Check With Your System Administrator';

        }

        // return Appointment::with('user', 'expert', 'consultation')->where('expert_id', $request->expert_id)->get();
        // return User::with('userAppointments.user', 'userAppointments.consultation')->where('id', $request->user_id)->get();
    }


}
