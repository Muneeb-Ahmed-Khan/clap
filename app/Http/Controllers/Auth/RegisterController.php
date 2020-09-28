<?php

namespace App\Http\Controllers\Auth;
    use App\User;
    use App\Student;
    use App\Teacher;
    use App\Principal;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
            $this->middleware('guest');
            $this->middleware('guest:student');
            $this->middleware('guest:teacher');
            $this->middleware('guest:principal');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $table)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.$table.''],   //unique:$table (check the $table table for email uniqueness)
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
         [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',

            'email.required' => 'Name is required',
            'email.min' => 'Email must be at least 2 characters.',
            'email.max' => 'Email should not be greater than 50 characters.',
            'email.unique' => 'Email already Registered',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password must be same',
         ]);
        
    }


    public function RegisterLogic(Request $request)
    {

        $role = $request->input('role');
        if($role=="principal")
        {
            $validator = $this->validator($request->all(), 'principals');  //Second Parameter is TableName we sent to Validator
            if ($validator->fails())
            {
                return back()->withInput($request->only('email', 'name'))->withErrors($validator);
            }
            else
            {
                $model = Principal::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]);

                /*
                        in this case i have 3 tables in which i create instances according to the roles.

                        PROBLEM:

                        http://127.0.0.1:8000/email/verify/ID/SHA1(EMAIL)?expires=SOMEVALUE&signature=SOMEVALUE
                        The above link sent to me by the Laravel Default Email Verification Notification has no value for which
                        table should i store the value, i can get the [ID, Hashed Email, Expiry time, Signature value] from the link
                        but i don't have the table name to which i should compare or do some function with.

                        SOLUTION:

                        Goto:       ProjectName\vendor\laravel\framework\src\Illuminate\Auth\Notifications\VerifyEmail.php

                        Inside [protected function verificationUrl($notifiable)],   add one more line
                        'instanceOf' => $notifiable->getTable(),
                        below 'hash' attribute in Carbon Section. This line will add one more parameter to the URL that will be
                        instanceOf=TABLENAME,   Now, you can extract the table name from the URL and use it in Query.

                        Updated Link will be after this modification : http://127.0.0.1:8000/email/verify/ID/SHA1(EMAIL)?expires=SOMEVALUE&instanceOf=teachers&signature=SOMEVALUE

                        Now, we can get the [ID, Hashed Email, Expiry time, TABLENAME , Signature value] from the link
                        to Extract TABLENAME from this link use:
                        $table = $request->input('instanceOf');

                        CONCULSION:

                        Now, when you use $model->sendEmailVerificationNotification();  it will get the TABLENAME associated with this model
                        from config/auth.php, it its mentioned in that file as provider in guard array and send it along with other information to email.

                */

                $model->sendEmailVerificationNotification();
                return back()->with('success', "Check your inbox for Verification Email");
            }
        }

        return back()->withErrors(["WrongInput" => "Only Principal Registration Allowed at the moment."]);
    }

    protected function showRegisterForm()
    {
        return view('register');
    }



//====================================================================================================================================================================

/*
Version 1 of the inside of RegisterLogic() function
        if($role=="student")
        {
                $validator = $this->validator($request->all(),"students");  //"students" is table name
                if ($validator->fails())
                {
                    return back()->withInput($request->only('email', 'name'))->withErrors($validator);
                }
                else
                {
                    $model = Student::create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                    ]);


                    $model->sendEmailVerificationNotification();
                    return redirect()->intended('/register')->withErrors(["success" => "Check your inbox for Verification Email"]);
                }

        }
        elseif($role=="teacher")
        {
            $validator = $this->validator($request->all(),"teachers");  //"teachers" is table name
                if ($validator->fails())
                {
                    return back()->withInput($request->only('email', 'name'))->withErrors($validator);
                }
                else
                {
                    $model = Teacher::create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                    ]);
                    $model->sendEmailVerificationNotification();
                    return redirect()->intended('/register')->withErrors(["success" => "Check your inbox for Verification Email"]);
                }
        }
        elseif($role=="principal")
        {
            $validator = $this->validator($request->all(),"principals");    //"principals" is table name
                if ($validator->fails())
                {
                    return back()->withInput($request->only('email', 'name'))->withErrors($validator);
                }
                else
                {
                    $model = Principal::create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                    ]);
                    $model->sendEmailVerificationNotification();
                    return redirect()->intended('/register')->withErrors(["success" => "Check your inbox for Verification Email"]);
                }
        }
        else
        {
            //Send them to 404 page
            return "ERROR";
        }
*/




    /*
    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }

    public function showWriterRegisterForm()
    {
        return view('auth.register', ['url' => 'student']);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    */
}
