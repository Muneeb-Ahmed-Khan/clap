<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
                DB::table('chapters_record')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('roundrobin_record')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('tests')->where(['school_id' => $request->input('schoolid')])->delete();
                DB::table('test_record')->where(['school_id' => $request->input('schoolid')])->delete();

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
            #$courses=DB::select("select tc.id, t.name,tc.cname from teachers t ,tcourses tc where t.ID=tc.teacher_id and t.school_id=?",[$request->route('schoolId')]);
           
            $courses = DB::table('tcourses')
            ->where([
                'tcourses.school_id' =>  $request->route('schoolId'),
            ])
            ->leftjoin('teachers as t', 't.id', '=', 'tcourses.teacher_id')
            ->select('tcourses.*', 't.name')
            ->get();
            

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
            elseif($request->has('SubmitedForm_AddCourse'))
            {
                #Instead of Bulk Upload by .csv file, add the course manually.
                if(is_numeric($request->input('schoolId')))
                {
                    #IF valid email then try to assign it to
                    if(filter_var($request->input('temail'), FILTER_VALIDATE_EMAIL))
                    {
                        #Try to check if this teacher exists
                        $teacher = DB::table('teachers')->where([
                            'email' => $request->input('temail'),
                            'school_id' => $request->input('schoolId'),
                        ])->get();

                        if(!$teacher->isEmpty())
                        {
                            #Teacher Exisits so add the course to tcourses
                            $count = DB::table('tcourses')->insert([
                                'cname' => $request->input('cname'), 
                                'teacher_id' => $teacher[0]->id, 
                                'school_id' => $request->input('schoolId')
                            ]);

                            if($count != null)
                            {
                                return back()->with(["success" => "Course added and assigned to ".$teacher[0]->name]);
                            }
                            else
                            {
                                return back()->withErrors(["WrongInput" => "Failed to add course"]);
                            }
                        }
                    }
                    
                    #Try to get the first most teacher of this school
                    $teacher = DB::table('teachers')->where([
                        'school_id' => $request->input('schoolId'),
                    ])->orderBy('id', 'ASC')->first();
                    
                    if($teacher != null)
                    {
                        #Teacher Exisits so add the course to tcourses
                        $count = DB::table('tcourses')->insert([
                            'cname' => $request->input('cname'), 
                            'teacher_id' => $teacher->id, 
                            'school_id' => $request->input('schoolId')
                        ]);

                        if($count != null)
                        {
                            return back()->with(["success" => "Course added and auto assigned to ".$teacher->name]);
                        }
                        else
                        {
                            return back()->withErrors(["WrongInput" => "Failed to add course"]);
                        }
                    }

                    return back()->withErrors(["WrongInput" => "Please add a teacher"]);
                }
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
    public function ShowSubjectParticipants(Request $request)
    {
        $school = DB::table('schools')->where(['id' => $request->route('schoolId'), 'principal_id' => Auth::user()->id])->get();
        if(!$school->isEmpty())
        {
            $course_name = DB::table('tcourses')->where([
                                'id' => $request->route('courseId'),
                                'school_id' => $school[0]->id,
                            ])->select('cname')->get();

            if(!$course_name->isEmpty())
            {
                $students = DB::select("select s.* from students s join scourses sc on (s.id = sc.student_id) where sc.school_id = ? and sc.cname = ?",[$request->route('schoolId'), $course_name[0]->cname]);
                $teachers = DB::table('teachers')->where([ 'school_id' => $request->route('schoolId')  ])->get();
                
                return view('principal.details', [
                                                    'courseId' => $request->route('courseId'),
                                                    'schoolId' => $request->route('schoolId'), 
                                                    'students' => $students, 
                                                    'teachers' => $teachers ]);
            }
            else
            {
                return redirect('/principal')->withErrors("SomethingWentWrong","This course does not belong to your school.");
            }
            
        }
        else
        {
            return redirect()->intended('/principal')->withErrors("SomethingWentWrong", "Something Went Wrong.");
        }

    }

    //=================================================
    //  ViewAllStudents
    //==================================================
    public function ViewAllStudents(Request $request)
    {
        $thisSchool = DB::table('schools')->where([
            'id' => $request->route('schoolId'),
            'principal_id' => Auth::user()->id
        ])->get();
        
        if(!$thisSchool->isEmpty())
        {
            $students = DB::table('students')->where([
                'school_id' => $request->route('schoolId'),
            ])->get();

            $courses = DB::table('tcourses')->where([
                'school_id' => $request->route('schoolId'),
            ])->get();

            return view('principal.studentsDetails', ['schoolId' => $request->route('schoolId'), 'students' => $students, "courses" =>  $courses]);
        }
        else
        {
            return back()->withErrors(["WrongInput" => "No School Exists."]);
        }
    }

    public function AddStudent(Request $request)
    {
        if ($request->has('SubmitedForm_AddStudent') && is_numeric($request->input('schoolId')) && filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            #Confirm this school belongs to me
            $thisSchool = DB::table('schools')->where([
                'id' => $request->input('schoolId'),
                'principal_id' => Auth::user()->id
            ])->get();

            if(!$thisSchool->isEmpty())
            {
                #The school belongs to me now add the student.
                $count = DB::table('students')->insert([
                    'name' => $request->input('name'), 
                    'email' => $request->input('email'), 
                    'password' => Hash::make("123456789"),
                    'school_id' => $thisSchool[0]->id
                ]);

                if($count != null)
                {
                    return back()->with(["success" => "Student added successfully"]);
                }
                else
                {
                    return back()->withErrors(["WrongInput" => "Failed to add student"]);
                }
            }
        }
        
        return back()->withErrors(["err1" => "Something went wrong.", "err2" => "Hint : Check Email"]);
    }

    public function DeleteStudent(Request $request)
    {
        
        $thisSchool = DB::table('schools')->where([
            'id' => $request->input('schoolId'),
            'principal_id' => Auth::user()->id
        ])->get();
        
        if(!$thisSchool->isEmpty())
        {
            $student = DB::table('students')->where([
                'school_id' => $request->input('schoolId'),
                'id' => $request->input('studentId')
            ])->get();
            
            if(!$student->isEmpty())
            {   
                #Delete the chapter and all it's associated records
                DB::table('students')->where([
                    'id' => $request->input('studentId'),
                    'school_id' => $request->input('schoolId'),
                ])->delete();
                
                DB::table('scourses')->where([
                    'student_id' => $request->input('studentId'),
                    'school_id' => $request->input('schoolId'),
                ])->delete();
    
                DB::table('chapters_record')->where([
                    'student_id' => $request->input('studentId'),
                    'school_id' => $request->input('schoolId'),
                ])->delete();
    
                DB::table('test_record')->where([
                    'student_id' => $request->input('studentId'),
                    'school_id' => $request->input('schoolId'),
                ])->delete();
                
                return back()->with('success', "Deleted Sucessfully");
            }

            return back()->withErrors(["WrongInput" => "Student does not Exists."]);
        }
        else
        {
            return back()->withErrors(["WrongInput" => "No School Exists."]);
        }
    }

    public function AssignCourseToStudent(Request $request)
    {
        if(is_numeric($request->input('courseId')) && is_numeric($request->input('studentId')) && $request->has('SubmitedForm_AddCoursetoStudent'))
        {
            #Confirm this course is in school which belongs to me.
            $thisCourse = DB::table('tcourses')->where([
                'id' => $request->input('courseId')
            ])->get();

            if(!$thisCourse->isEmpty())
            {   
                #Now Check the school_id with this course, wrther it is equal to school which i own.
                $thisSchool = DB::table('schools')->where([
                    'id' => $thisCourse[0]->school_id,
                    'principal_id' => Auth::user()->id
                ])->get();

                if(!$thisSchool->isEmpty())
                {
                    $thisStudent = DB::table('students')->where([
                        'id' => $request->input('studentId'),
                        'school_id' => $thisSchool[0]->id
                    ])->get();
                    
                    if(!$thisStudent->isEmpty())
                    {
                        #now if we got here, it means, School is mine, course is in this school, student is of this school
                        $check = DB::table('scourses')->updateOrInsert(
                            [
                                'cname' => $thisCourse[0]->cname,
                                'student_id' => $thisStudent[0]->id,
                                'school_id' => $thisSchool[0]->id
                            ],
                            [
                                'cname' => $thisCourse[0]->cname,
                                'student_id' => $thisStudent[0]->id,
                                'school_id' => $thisSchool[0]->id
                            ]
                        );
                
                        if($check == true)
                        {
                            return back()->with(["success" => "Course assigned successfully"]);
                        }
                        return back()->with(["success" => "Already assigned"]);
                    }
                    return back()->withErrors(["WrongInput" => "Student not found"]);
                }
                return back()->withErrors(["WrongInput" => "School not found"]);
            }
            return back()->withErrors(["WrongInput" => "Course not found"]);
        }
        return back()->withErrors(["WrongInput" => "Something went wrong."]);
    }

    public function RemoveStudentFromCourse(Request $request)
    {
        if(is_numeric($request->input('courseId')) && is_numeric($request->input('studentId')))
        {
            #Confirm this course is in school which belongs to me.
            $thisCourse = DB::table('tcourses')->where([
                'id' => $request->input('courseId')
            ])->get();

            if(!$thisCourse->isEmpty())
            {
                $thisSchool = DB::table('schools')->where([
                    'id' => $thisCourse[0]->school_id,
                    'principal_id' => Auth::user()->id
                ])->get();

                if(!$thisSchool->isEmpty())
                {
                    $thisStudent = DB::table('students')->where([
                        'id' => $request->input('studentId'),
                        'school_id' => $thisSchool[0]->id
                    ])->get();
                    
                    if(!$thisStudent->isEmpty())
                    {
                        DB::table('scourses')->where([
                            'cname' => $thisCourse[0]->cname,
                            'student_id' => $thisStudent[0]->id,
                            'school_id' => $thisSchool[0]->id
                        ])->delete();
                        
                        return back()->with(["success" => "Removed successfully"]);
                    }
                    return back()->withErrors(["WrongInput" => "Student not found"]);
                }
                return back()->withErrors(["WrongInput" => "School not found."]);
            }
            return back()->withErrors(["WrongInput" => "Course not found."]);
        }
        return back()->withErrors(["WrongInput" => "Something went wrong."]);
    }



    //=================================================
    //  View All Teachers
    //==================================================
    public function ViewAllTeachers(Request $request)
    {
        $thisSchool = DB::table('schools')->where([
            'id' => $request->route('schoolId'),
            'principal_id' => Auth::user()->id
        ])->get();
        
        if(!$thisSchool->isEmpty())
        {
            $teachers = DB::table('teachers')->where([
                'school_id' => $request->route('schoolId'),
            ])->get();

            return view('principal.teachersDetails', ['schoolId' => $request->route('schoolId'), 'teachers' => $teachers]);
        }
        else
        {
            return back()->withErrors(["WrongInput" => "No School Exists."]);
        }
    }


    public function AddTeacher(Request $request)
    {
        if ($request->has('SubmitedForm_AddTeacher') && is_numeric($request->input('schoolId')) && filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            #Confirm this school belongs to me
            $thisSchool = DB::table('schools')->where([
                'id' => $request->input('schoolId'),
                'principal_id' => Auth::user()->id
            ])->get();

            if(!$thisSchool->isEmpty())
            {
                #The school belongs to me now add the Teacher.
                $count = DB::table('teachers')->insert([
                    'name' => $request->input('name'), 
                    'email' => $request->input('email'), 
                    'password' => Hash::make("123456789"),
                    'school_id' => $thisSchool[0]->id
                ]);

                if($count != null)
                {
                    return back()->with(["success" => "Teacher added successfully"]);
                }
                else
                {
                    return back()->withErrors(["WrongInput" => "Failed to add Teacher"]);
                }
            }
        }
        
        return back()->withErrors(["err1" => "Something went wrong.", "err2" => "Hint : Check Email"]);
    }

    public function DeleteTeacher(Request $request)
    {
        $thisSchool = DB::table('schools')->where([
            'id' => $request->input('schoolId'),
            'principal_id' => Auth::user()->id
        ])->get();
        
        if(!$thisSchool->isEmpty())
        {
            $teacher = DB::table('teachers')->where([
                'school_id' => $request->input('schoolId'),
                'id' => $request->input('teacherId')
            ])->get();
            
            if(!$teacher->isEmpty())
            {   
                #Delete the chapter and all it's associated records
                DB::table('teachers')->where([
                    'id' => $request->input('teacherId'),
                    'school_id' => $request->input('schoolId'),
                ])->delete();
                
                
                return back()->with('success', "Deleted Sucessfully");
            }

            return back()->withErrors(["WrongInput" => "Teacher does not Exists."]);
        }
        else
        {
            return back()->withErrors(["WrongInput" => "No School Exists."]);
        }
    }


    //=================================================
    //  Change The Teacher for this Course
    //==================================================
    public function ChangeTeacher(Request $request)
    {
        if ($request->has('SubmitedForm_ChangeTeacher') && is_numeric($request->input('courseId')) && is_numeric($request->input('teacherId')))
        {
            #Confirm this course is in school which belongs to me.
            $thisCourse = DB::table('tcourses')->where([
                'id' => $request->input('courseId')
            ])->get();

            if(!$thisCourse->isEmpty())
            {   
                #Now Check the school_id with this course, wrther it is equal to school which i own.
                $thisSchool = DB::table('schools')->where([
                    'id' => $thisCourse[0]->school_id,
                    'principal_id' => Auth::user()->id
                ])->get();

                if(!$thisSchool->isEmpty())
                {
                    #If we get to here, this means that the course belongs to my school, Change the Teacher
                    $check = DB::table('tcourses')
                    ->where([
                        'id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id
                    ])
                    ->update([
                        'teacher_id' => $request->input('teacherId')
                    ]);

                    if($check == true)
                    {
                        #now in chapters table, update teacher_id for the course as well.
                        DB::table('chapters')
                        ->where([
                            'course_id' => $thisCourse[0]->id,
                            'school_id' => $thisSchool[0]->id
                        ])
                        ->update([
                            'teacher_id' => $request->input('teacherId')
                        ]);

                        return back()->with(["success" => "Teacher changed successfully"]);
                    }
                    else
                    {
                        return back()->with(["success" => "Already Registered"]);
                    }
                    
                }
            }
        }
        
        return back()->withErrors(["WrongInput" => "Something went wrong."]);
    }


    //=================================================
    //  Delete Course
    //==================================================
    public function DeleteCourse(Request $request)
    {
        if(is_numeric($request->input('courseId')))
        {
            #Confirm this course is in school which belongs to me.
            $thisCourse = DB::table('tcourses')->where([
                'id' => $request->input('courseId')
            ])->get();

            if(!$thisCourse->isEmpty())
            {   
                #Now Check the school_id with this course, wrther it is equal to school which i own.
                $thisSchool = DB::table('schools')->where([
                    'id' => $thisCourse[0]->school_id,
                    'principal_id' => Auth::user()->id
                ])->get();

                if(!$thisSchool->isEmpty())
                {
                    //I own the school that this course is in, and i am allowed to do it. so let's do it.
                    //delete the course and it's associcated records.
                    DB::table('tcourses')->where([
                        'id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('broadcasts')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('chapters')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('chapters_record')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('roundrobin_record')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('scourses')->where([
                        'cname' => $thisCourse[0]->cname,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('tests')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    DB::table('test_record')->where([
                        'course_id' => $thisCourse[0]->id,
                        'school_id' => $thisSchool[0]->id,
                    ])->delete();

                    
                    return back()->with('success', "Deleted Sucessfully");
                }
                return back()->withErrors(["WrongInput" => "Not a course of this school."]);
            }
            return back()->withErrors(["WrongInput" => "Course does not exists."]);
        }
    }
}
