<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use \App\Models\Role;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Helper\Helper;
use Stripe;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use App\Mail\EmailVerificationMail;
use App\Models\Category;
use App\Models\ChatImage;
use App\Models\Notification;
use App\Models\Store;
use App\Models\UserDevice;
use GrahamCampbell\ResultType\Success;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\returnSelf;

class AuthController extends ApiController {

    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','mobile_no_found','profile_picture','marital_status','type','status','is_switch','vendor_status','token','created_at','updated_at'];
//    public static $_mediaBasePath = 'uploads/users/';
    public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }
    
    
    public static function imageUpload($file, $folder) {
        $path = public_path($folder);
        $name = time() . rand(1, 10) . $file->getClientOriginalName();
        $file->move($path, $name);
        $upload['image'] = $name;
        return $upload['image'];
    }
    

   



    public function Login(Request $request) {
        try {
            $rules = ['email' => 'required', 'password' => 'required','type'=> 'required|in:1,2'];
            
            $rules = array_merge($this->requiredParams, $rules);
            $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
            if ($validateAttributes):         
                return $validateAttributes;
            endif;

            
            if (Auth::attempt(['email' => request('email'), 'password' => request('password'), 'type' => request('type')])):
                
                $input = $request->all();
                // $latitude  = $input['latitude'];
                // $longitude = $input['longitude'];
                
                // $UpdateData = \App\User::where('id', Auth::user()->id)->update(['latitude' => $latitude, 'longitude' => $longitude]); 
                
                $user = \App\Models\User::select($this->LoginAttributes)->find(Auth::user()->id);
                $user->save();
      
                $token = $user->createToken('consign-it-away')->plainTextToken;  
                $user['store'] = Store::select('id')->where('user_id', Auth::id())->orderBy('created_at','DESC')->first();
             
                parent::addUserDeviceData($user, $request);
              
                return parent::success('Login Successfully!',['token' => $token, 'user' => $user]);
            else:
                
                return parent::error("User credentials doesn't matched");
            endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function SocialLogin_2(Request $request){
        // dd('Social Login');
        $rules = ['email'=> '','social_id' =>'required', 'name'=> '', 'type'=> 'required|in:1,2','mobile_no' => ''];
        $rules = array_merge($this->requiredParams, $rules);
      
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
            try{
                
                $input = $request->all();
                
                $field = array();
                $facebook_id = ''; 
                $google_id = '';
                $apple_id ='';
                $amazon_id = '';
                
                $social_source  =  strtolower($input['social_type']); 
                $social_id      =  $input['social_id'];  
                
                if( $social_source == 'facebook' || $social_source == 'google' || $social_source == 'apple' || $social_source == 'amazon' ) {
                
                    $field[ $social_source.'_id' ] = $social_id;
                
                }
             
                 
             
                $current_user_id = User::select('id')->where($field)->first();
                
    			if(is_null($current_user_id) !== true ) {
    		
    			    $user = User::where('id', $current_user_id->id)->first();
    			    if(!empty($user->status == '1')):
    			         //   parent::sendOTPUser($user);    
    			        endif;
    			    
    			    if($user->type !== $input['type']):
    			        $typ = ($user->type === '1')? 'client':'vendor';
    			        return parent::error('This account already registered with '.$typ);
    			        endif;
    		        $token = $user->createToken('consign-it-away')->plainTextToken;
    				return parent::success('Login successfully',['token' => $token, 'user' => $user]);
    			    
    			} else {
    
    			    $user = array ();
    				if ( isset ( $input['email'] ) && ! empty ( $input['email'] ) ) {
    				    
    				    // mycode
                    
                        $input['email'] = $request->email;
                   
                        $rules = array('email' => 'unique:users,email'); //
                        
                        $validator = Validator::make($input, $rules);
                        
                        if ($validator->fails()) {
                             
                            $current_user_id = User::select('*')->where('email', $input['email'])->first();
                            User::where('id', $current_user_id->id)->update($field);
                            $userdata = User::select('*')->where('email', $input['email'])->first();
                            $token = $current_user_id->createToken('consign-it-away')->plainTextToken;
                            return parent::success('login successfully-2', ['token' => $token,'user' => $userdata]);
                        }
                        else {
                           
                            $field['email']  = $input['email'];
                            $field['name']   = $input['name'];
                            $field['type']   = $input['type'];
                            $field['status']  = '1';
                            if(!empty($input['mobile_no'])):
                                $field['mobile_no_found']  = '1';
                            endif;
                            
    				        $current_user_id = User::create($field)->id;
    				        
    				        $user = User::where('id', $current_user_id)->first();
    				        
    				        $token = $user->createToken('consign-it-away')->plainTextToken;
    				        
    				        parent::addUserDeviceData($user, $request);
    				        return parent::success('login successfully',['token' => $token,'user' => $user]);
                        }
    				  

    				} else {
    			        
                            // $userId  = User::create($field)->id;
                            // $user = User::where('id', $userId)->first();
                            // $token = $user->createToken('consign-it-away')->plainTextToken;
                            // parent::addUserDeviceData($user, $request);
                            return parent::error("Email field is required");
    				  
    			}
    				 
    			}
                

            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
    }




    public function SocialLogin(Request $request){
      
        $rules = ['social_type' =>'required', 'social_id'=>'required'];
        $rules = array_merge($this->requiredParams, $rules);
           // dd($rules);
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $field = [];
            $social_type = strtolower($input['social_type']);
            $social_id = $input['social_id'];

        if( $social_type == 'facebook' || $social_type == 'google' || $social_type == 'apple' || $social_type == 'amazon' ) {
                
                $field[ $social_type.'_id' ] = $social_id;
            
            }
            
        $check_user = User::select($this->LoginAttributes)->where($field)->first();
    
        
        // dd(isEmpty($check_user));   
        if($check_user):
            $token = $check_user->createToken('Consign-it-away')->plainTextToken;
            parent::addUserDeviceData($check_user, $request);
            $check_user['store'] = Store::select('id')->where('user_id', $check_user->id)->orderBy('created_at','DESC')->first();
         
            return parent::success("User already exists.",['token' =>  $token,'user'=> $check_user],200);
        else:
            return parent::success('This user not exists.',['status' =>'not_exist'],201);
        endif;
        
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    

    public function Logout(Request $request) {
        $rules = [];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {

            if (Auth::check()) {
            //   dd(Auth::user());
              $Auth =   Auth::user()->tokens()->delete();
             
            }
            $device = \App\Models\UserDevice::where('user_id', Auth::id())->get();
          
            if ($device->isEmpty() === false)
               // \App\Models\UserDevice::destroy($device->first()->id);
             
                UserDevice::FindOrfail($device->first()->id)->update(['token'=>'']);
              
            return parent::success('Logout Successfully');
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function Register(Request $request) {
    
        // |unique:users,mobile_no

        $input = $request->all();
      
    //    if (isset($request->profile_picture)):
    //        $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
    //    endif;
        if($input['type'] === '1'):
            $fullname = $input['fname'].' '.$input['lname'];
            $input['name'] = $fullname;
        else:
            $input['name'] = 'New User';
        endif;
        
        $input['token'] = uniqid(md5(rand()));
        $input['password'] = bcrypt($input['password']);
        if($input['type'] === '1'):
            
            //Stripe Create user;
        
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create([
            'description' => 'Create stripe Customer for client',
            'email' => $input['email'],
            'name'  => $fullname,
        ]);
            $input['cus_id'] = $customer->id;
        endif;
        if($input['type'] === '1'){
            $input['status'] = '1';
        }else if($input['type'] === '2'){
            $input['vendor_status'] = '1';
        }
       

                $field = array();
                $social_source  =  strtolower($input['social_type']); 
                $social_id      =  $input['social_id'];  
                
                if( $social_source == 'facebook' || $social_source == 'google' || $social_source == 'apple' || $social_source == 'amazon' ) {
                
                    $input[ $social_source.'_id' ] = $social_id;
                
                }


        $user = User::create($input);
                if($user->type === '1'):

                        parent::sendOTPUser($user);
                        $otp = rand(1111, 9999);
                        
                        
                        $html = '<p>Your consign-it-away verification code is '.$otp.' This help us secure your account by verifying your OTP. This let you to access your consign-it-away account.</p>';
                        Helper::SendVarificationEmail($user->email,$user->fname, $html);
                        // $mail = Mail::to($input['email'])->send( new EmailVerificationMail($data));
                        $user->email_otp = $otp;
                        $user->save();

                endif;
        
   
        $success['token'] = $user->createToken('Consign-it-away')->plainTextToken;
        // dd($success['token']);
        $userData  = User::select($this->LoginAttributes)->where('id', $user->id)->first();
        $success['user'] = $userData;
        
       
       
        $lastId = $user->id;
        $selectClientRole = [];
        if($user->type == 1):
           
            $selectClientRole = Role::where('name', 'user')->first();
            
            else:
            $selectClientRole = Role::where('name', 'vendor')->first();
        endif;
        
        $assignRole = DB::table('role_user')->insert(
                ['user_id' => $lastId, 'role_id' => $selectClientRole->id]
        );

        // Add user device details for firbase
        parent::addUserDeviceData($user, $request);
    
        // if ($user->status != 1) {
        //     return parent::error('Please contact admin to activate your account', 200);
        // }
       
        return parent::success('Register successfully',$success, $this->successStatus);
    }
    
   




    public function resendOTP(Request $request){
       
        $rules = ['phonecode' => '', 'mobile_no' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                $input = $request->all();
              
                $user = User::findOrFail(Auth::id());
               
                if(!empty($user->mobile_no)):
                    // dd('!empty mobile_no');
                        parent::sendOTPUser($user);
                        else:
                            // dd(' mobile_no');
                        $user->phonecode = $input['phonecode'];
                        $user->mobile_no = $input['mobile_no'];
                        $user->save();
                        parent::sendOTPUser($user);
                    endif;
                $UserData = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
                return parent::success('OTP has been send successfully to your number!',['user' => $UserData]);
            
                
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
   
   
    public function VerifyOTP(Request $request){
     
        $rules = ['otp' => 'required|numeric|digits:4','type'=> 'required|in:1,2'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input = $request->all();
                
                $otp = $input['otp'];
                $message='';
            if($input['type'] === '2'):
                $user = User::where('id', Auth::id())->where('mobile_otp', $otp)->first();
                $message = "Mobile OTP didn't match";
            elseif($input['type'] === '1'):
                $user = User::where('id', Auth::id())->where('email_otp', $otp)->first();
                $message = "Email OTP didn't match";
            endif;
                if(is_null($user) === true):
                        return  parent::error($message);
                    endif;
                
                    // $user = new User();
                    if($input['type'] === '1'):
                        $user->status = '2';
                        elseif($input['type'] === '2'):
                            $user->status = '3';
                    endif;
                    
                    $user->save();
                
                return parent::success('OTP verification successfuly!', ['user' => $user]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
    }
    
    
    public function EmailVerification(Request $request){
        $rules = ['otp' => 'required||numeric|digits:4','email' => 'required|exists:users,email'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $user = User::where('email', $input['email'])->where('email_otp', $input['otp'])->first();
            
                if(is_null($user) === true):
                    return response()->json(['status' => false,'code' => 422,'error' => 'OTP mismatched']);
                        // return  parent::error($input['otp'].' OTP does not match');
                    endif;
                
                return parent::success('Email verification successfully!',[]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function EmailResetPassword(Request $request){
        $rules = ['email' => 'required', 'password' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $data['password'] = hash::make($input['password']);
                // dd($password);
                $user = \App\Models\User::where('email', $input['email'])->update($data);
            
                return parent::success('Your password has been successfully changed!', []);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
   
    
    


    public function changePassword(Request $request) {
        
        $rules = ['old_password' => 'required', 'password' => 'required', 'password_confirmation' => 'required|same:password'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        
        try {
            
            if (Hash::check($request->old_password, Auth::User()->password)):
                $model = \App\Models\User::find(Auth::id());
                $model->password = Hash::make($request->password);
                $model->save();
                return parent::success('Password Changed Successfully',[]);
            else:
                return parent::error('Please use valid old password');
            endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
   


    public function ResetPassword(Request $request) {
        //Validating attributes
        $rules = ['email' => 'required|exists:users,email'];    
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try{
         
            $email = base64_encode($request->email);
            $baseUrl = "https://".$request->getHttpHost()."/#/forgot-password?token=$email";
            // dd($baseUrl);
            $header = "Reset Password";
            $html = "<p>Your reset password url: <a href='$baseUrl'>Click Here</a></p><br><p>$baseUrl</p>";
          
             // send grid Dev:Ashish Mehra
            $ResetPassword = Helper::SendVarificationEmail($request->email,'Dear User', $html, $header);
            if($ResetPassword):
                return parent::success("Reset Password link has been send successfully!");
            endif;

        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    
    public function ResendEmailOTP(Request $request){
        $rules = ['email' => 'required|exists:users,email'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules,  array_keys($rules), true);
        if($validateAttributes):
           
            return $validateAttributes;
        endif;
        try{
          
                $input = $request->all();
                $User = \App\Models\User::select('fname','lname', 'email')->where('email', $input['email'])->first();
               
                $OTP = rand(1000,9999);
             
                $header = "Email OTP Verification Mail";
                $html = '<p>Your consign-it-away verification code is '.$OTP.' This help us secure your account by verifying your OTP. This let you to access your consign-it-away account.</p>';
              
                 // send grid Dev:Ashish Mehra
                Helper::SendVarificationEmail($request->email, Auth::user()->name, $html, $header);
              
            \App\Models\User::where('email', $User->email)->update(['email_otp' => $OTP]);                
               
                return parent::success('The email has been successfully');
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function getRegisterdUserDetails(Request $request) {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'GET', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {
//            dd(\Auth::id());
            $model = \App\Models\User::whereId(Auth::id());
            return parent::success('',$model->first());
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
   
   
    
   
    
    
    
    
    
    
    public function UserChat(Request $request){
        $rules = ['reciever_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
        try{
            
            
            // mycode
            $input = $request->all();
            $reciever_id = $input['reciever_id'];
            $user_id = Auth::id();
          
        if(!empty($user_id) && $reciever_id!=''){
                // $userId = $tokenDecode->id;
          
          
        //   mycode
        $sql = "SELECT DISTINCT sender.fname as senderName, sender.id as sender_id, sender.profile_picture as sender_profile_picture,receiver.fname as receiverName, receiver.id as receiver_id, receiver.profile_picture as receiver_profile_picture,msg.message,msg.created_on,msg.status as readStatus,msg.MessageType,IF((select COUNT(*) from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."'>0),1,0) as chatDelRow FROM user_chat msg INNER JOIN users sender ON msg.source_user_id = sender.id
        INNER JOIN users receiver ON msg.target_user_id = receiver.id WHERE ((msg.source_user_id='".$user_id."' AND msg.target_user_id='".$reciever_id."') OR 
        (msg.source_user_id='".$reciever_id."' AND msg.target_user_id='".$user_id."')) HAVING IF(chatDelRow=1,(msg.created_on>(select deletedDate from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."')),'1999-01-01 05:06:23') ORDER BY msg.created_on ASC";
        
      
        
        // mycodeEnds
                // DB::enableQuerylog();
                $RecentChat = DB::select($sql);
                // dd(DB::getQueryLog());
                $checkBlock = DB::select("SELECT * FROM `block_users` WHERE ((block_id='".$user_id."' AND block_by_id='".$reciever_id."') OR (block_id='".$reciever_id."' AND block_by_id='".$user_id."')) AND status='2'");
               
                if($checkBlock)
                {
                    $blockStatus=1;
                    $block_by_id=$checkBlock['block_by_id'];
                }
                else
                {
                    $blockStatus=0; 
                    $block_by_id=0;
                }
            
                if(!empty($RecentChat)) {
                    return $response=array("status"=>true,"code"=>200,"message"=>"View Messages successfully!","data" =>$RecentChat,"blockStatus" => $blockStatus,"BlockByID" =>$block_by_id);  
                // return parent::success(['message' => 'View Messages successfully!','data' => $RecentChat,"blockStatus" => $blockStatus,"BlockByID" =>$block_by_id]);
                }else {
                    return $response=array("status"=>true,'data'=> [], "message"=>"Data not found");  
                    
                }
            }else{
                $response=array("status"=>false,"message"=>"empty token"); 
                // return parent::error('empty Token');
            }
           
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function customer(Request $request){
        try{

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create([
            'description' => 'Create stripe Customer for client',
            'email' => 'duke_walker@icloud.com',
            'name'  => 'Duke Walker',
        ]);

        dd($customer);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
   
    public function ChangeProfilePicture(Request $request)
    {
        $rules = ['profile_pciture' => ''];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{

            if (isset($request->profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
            endif;
        $user =  User::FindOrfail(Auth::id());
        $user->profile_picture = $input['profile_picture'];
        $user->save();
        $user = $user->select('id','fname','lname','profile_picture')->where('id', Auth::id())->first();
        return parent::success("Profile picture changed successfully!",['user' => $user]);

        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
  public function ChatImageUrl(Request $request){
      $rules = ['image' => 'required'];
      $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
      if($validateAttributes):
        return $validateAttributes;
      endif;
      try{
          $input = $request->all();
          if (isset($request->image)):
           
            $input['image'] = parent::__uploadImage($request->file('image'), public_path('chatImage'), false);
        endif;
        $input['user_id'] = Auth::id();
      
        $image = ChatImage::create($input);
        return parent::success("Image upload successfully!",$image);
      }catch(\Exception $ex){
        return parent::error($ex->getMessage());
      }

  }


  public function Notification(Request $request){
      $rules= [];
   
      $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
      if($validateAttributes):
        return $validateAttributes;
      endif;
      try{
          $input = $request->all();
          //DB::enableQueryLog();
          $notification = Notification::where('receiver_id', Auth::id())->orderBy('id', 'DESC')->get();
         // dd(DB::getQueryLog($notification));
        return parent::success("View Notification successfully!", $notification);
      }catch(\Exception $ex){
          return parent::error($ex->getMessage());
      }

  }

  public function ReadNotification(Request $request){
      $rules = ['notification_id'=>'required','is_read'=>'required|in:0,1'];
      $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
      if($validateAttributes):
        return $validateAttributes;
      endif;
      try{
          $input = $request->all();
          $notification =   new Notification();
          $notification =   $notification->FindOrfail($request->notification_id);
                            $notification->fill($input);
                            $notification->save();
        return parent::success("Notification read successfully!", $notification);
      }catch(\Exception $ex){
        return parent::error($ex->getMessage());
      }
  }

  public function SwitchUser(Request $request)
  {
      $rules = ['type'=> 'required|in:1,2'];
      $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
      if($validateAttributes):
        return $validateAttributes;
      endif;
      try{
            $input = $request->all();
            $user = User::FindOrfail(Auth::id());

            if(Auth::user()->type === '1'){

                if($request->type === '2'){
                    $data = ['type' => '2','is_switch' =>'3'];
                    if(Auth::user()->vendor_status === '0'):
                        $data['vendor_status'] = '1';
                    endif;
                    $user->fill($data);
                    $user->save();
                }
            }else if(Auth::user()->type === '2'){
                
                if($request->type === '1'){
                    $data = ['type' => '1', 'is_switch' =>'3'];
                    if(Auth::user()->status === '0'):
                        $data['status'] = '1';
                    endif;
                    $user->fill($data);
                    $user->save();
                }
            }
            
          return parent::success("you have switch user successfully!",$user);

      }catch(\Exception $ex){
        return parent::error($ex->getMessage());
      }
  }

  public function ViewSubCategories(Request $request){
      $rules = ['category_id' => 'required|exists:categories,id'];
      $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
      if($validateAttributes):
        return $validateAttributes;
      endif;
      try{
          $input = $request->all();
          $category = Category::with('Subcategories')->get();
        return parent::success("View sub-categories successfully!",  $category);
      }catch(\Exception $ex){
        return parent::error($ex->getMessage());
      }
  }





  public function InviteFriend(Request $request){
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'GET',$rules,array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
              
                            $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
                            $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
                           

                    if ( $iPhone || $iPad ) {
                        $base_url = asset('');
                        $base_url = str_replace ( "https://", "", $base_url );
                        $base_url = str_replace ( "http://", "", $base_url );
                        ob_start();
                        ?><script>
                            window.location.href = "consignitaway://<?php echo $base_url;  ?>";
                            setInterval(function () {
                                window.location.replace("https://apps.apple.com/us/app/dutifypro/id1545296317");
                            }, 3000);
                        </script><?php
                    } else { 
                        ?><script>
                            window.location.href = "consignitaway://details";
                            setInterval(function () {
                                window.location.replace("http://play.google.com/store/apps/details?id=com.HBCUHUB");
                            }, 3000);
                        </script><?php
                    }
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       } 
    
  }

  public function ShareProduct(Request $request, $id){
  
    $rules = [];
   
    $validateAttributes = parent::validateAttributes($request,'GET',$rules,array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
            $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
            $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
                         
if ( $iPhone || $iPad ) {
    $base_url = asset('');
    $base_url = str_replace ( "https://", "", $base_url );
    $base_url = str_replace ( "http://", "", $base_url );
    ob_start();
    ?><script>
        window.location.href = "consignitaway://<?php echo $base_url;  ?>?product_id=<?php echo $id; ?>";
        setInterval(function () {
            https://consignitaway.com/#/details?id=3
            window.location.replace("https://consignitaway.com/#/details?id=<?php echo $id; ?>");
        }, 3000);
    </script>
    <?php } else {    ?>
            <script>
                window.location.href = "consignitaway://details??product_id=<?php echo $id; ?>";
                setInterval(function () {
                    
                    window.location.replace("https://consignitaway.com/#/details?id=<?php echo $id; ?>");
                }, 3000);
            </script>
        <?php
        }
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       } 
    
  }









    
    
  
    
   

}
