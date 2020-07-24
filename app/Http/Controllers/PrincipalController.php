<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PrincipalController extends Controller
{
    //======================================================================
    // COnstrutor
    //======================================================================
    public function __construct()
    {
        $this->middleware(['auth:principal','verified']);
    }

    //======================================================================
    // to add new schools and delete the existing school
    //======================================================================
    public function ManageSchool(Request $request)
    {

        if ($request->has('RegisterSchool'))
        {
            $count = DB::table('schools')->insert(['sname' => $request->input('name'), 'principal_id' => Auth::user()->id, 'isActive' => 1]);
            if($count != null)
            {
                return redirect('/principal')->with(["success" => "School Added Successfully"]);
            }
            else
            {
                return back()->withErrors(["SomethingWentWrong" => "Something went wrong"]);
            }
        }
        else if ($request->has('DeleteSchool'))
        {
            $check = DB::table('schools')->where(['principal_id' => Auth::user()->id, 'id' => $request->input('schoolid')])->delete();

            if($check != FALSE)
            {
                DB::table('teachers')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('students')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('scourses')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('tcourses')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('chapters')->where(['school_id' => $request->input('schoolid')])->delete();
                return redirect('/principal')->with(["success" => "School Deleted Successfully"]);
            }
            else
            {
                return back()->withErrors(["WrongInput" => "Wrong School ID"]);
            }
        }
        return redirect()->intended('/principal');
    }

    //======================================================================
    //principal dashboard showing all schools
    //======================================================================
    public function Dashboard()
    {
        $schools = DB::table('schools')->get()->where('principal_id',Auth::user()->id)->where('isActive',1);
        return view('principal.dashboard')->with('schools',$schools);
    }

    //======================================================================
    //showing all coruses in school along with their teacher name
    //======================================================================
    public function SchoolView(Request $request)
    {
        $school = DB::table('schools')->where(['id' => $request->route('schoolId'), 'principal_id' => Auth::user()->id])->select()->get();
        if(!$school->isEmpty())
        {
            $courses=DB::select("select tc.id, t.name,tc.cname from teachers t ,tcourses tc where t.ID=tc.teacher_id and t.school_id=?",[$request->route('schoolId')]);
           // select t.name ,tc.cname from teachers t ,tcourses tc where t.ID=tc.teacher_id and t.school_id=1
           // $courses = DB::select("select * from tcourses where school_id = ?",[$request->route('schoolId')]);
            //return $courses;
            return view('principal.schoolview')->with(['schoolId' => $request->route('schoolId'), 'courses' => $courses]);
        }
        else
        {
            return redirect()->intended('/principal')->withErrors(["WrongInput" => "Wrong School ID"]);
        }
    }

    //======================================================================
    //for uploading students and teachers csv
    //======================================================================
    public function ManageUpload(Request $request)
    {
        $school = DB::table('schools')->where(['id' => $request->route('schoolId'), 'principal_id' => Auth::user()->id])->select()->get();
        if(!$school->isEmpty())
        {
            //*******//---students   Form submission post ---//********//
            if ($request->has('SubmitStudent'))
            {
                $fileName = $_FILES["file"]["tmp_name"]; //storing file in variable
                if ($_FILES["file"]["size"] > 0)
                {
                    // checking file if it is empty or not
                    $file = fopen($fileName, "r");
                    while (($column = fgetcsv($file, 1000, ",")) !== FALSE)
                    {
                        // insertion in student table
                        $res = DB::select("select * from students where email = '$column[1]'");
                        if($res==null)
                        {
                            DB::insert("insert into students(name,email,school_id,password)  values (?,?,?,?)",[$column[0], $column[1], $request->route('schoolId'), Hash::make("123456789")]);
                            //getting last row inserted with curent email
                            $results = DB::select("select id from students where email = ?",[$column[1]]);
                            //getting id from array
                            $idd=$results[0]->id;
                            $i=2;//for inserting courses in scourse table

                            //inserting in sscourse
                            while(!empty($column[$i]))
                            {
                                //change school id value
                                DB::insert("insert into scourses (cname,student_id,school_id)  values(?,?,?)",[$column[$i], $idd, $request->route('schoolId')]);
                                $i++;
                            }
                        }
                    }
                }
                return redirect()->intended('/principal/'.$request->route('schoolId'))->with("success","Students Added Successfully.");
            }

            //*******//---Teachers Form submission post ---//********//
            elseif($request->has('SubmitTeacher'))
            {
                $fileName = $_FILES["file"]["tmp_name"]; //storing file in variable
                if ($_FILES["file"]["size"] > 0)
                {
                    // checking file if it is empty or not
                    $file = fopen($fileName, "r");
                    while (($column = fgetcsv($file, 1000, ",")) !== FALSE)
                    {
                        // insertion in student table
                        $res = DB::select("select * from teachers where email = '$column[1]'");
                        if($res==null)
                        {
                            DB::insert("insert into teachers(name,email,school_id,password)  values (?,?,?,?)",[$column[0], $column[1], $request->route('schoolId'), Hash::make("123456789")]);
                            //getting last row inserted with curent email
                            $results = DB::select("select id from teachers where email = ? and school_id = ?",[$column[1], $request->route('schoolId')]);
                            $idd=$results[0]->id;//getting id from array
                            $i=2;//for inserting courses in tcourse table
                            while(!empty($column[$i]))//inserting in sscourse
                            {
                                $dublicate=DB::select("select *from tcourses where cname=? and school_id=?",[$column[$i], $request->route('schoolId')]);
                                if($dublicate==null)
                                {
                                DB::insert("insert into tcourses (cname,teacher_id,school_id)  values(?,?,?)",[$column[$i], $idd, $request->route('schoolId')]);
                                }

                                $i++;
                            }
                        }
                    }
                }
                return redirect()->intended('/principal/'.$request->route('schoolId'))->with("success","Teachers Added Successfully.");
            }
        }
        else
        {
            return redirect()->intended('/principal')->withErrors("SomethingWentWrong","Something Went Wrong.");
        }
    }


    //======================================================================
    // for showing all student who taken the particular subject in school
    //======================================================================
    public function ManageSubjects(Request $request)
    {
        $school = DB::table('schools')->where(['id' => $request->route('schoolId'), 'principal_id' => Auth::user()->id])->select()->get();
        if(!$school->isEmpty())
        {
            $course_name = DB::select("select cname from tcourses where id = ?",[$request->route('courseId')]);
            $students = DB::select("select s.name, s.email from students s join scourses sc on (s.id = sc.student_id) where sc.school_id = ? and sc.cname = ?",[$request->route('schoolId'), $course_name[0]->cname]);
            return view('principal.details', ['schoolId' => $request->route('schoolId'), 'students' => $students]);
        }
        else
        {
            return redirect()->intended('/principal')->withErrors("SomethingWentWrong","Something Went Wrong.");
        }

    }
}
