<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:student','verified']);
    }

    public function Dashboard()
    {
        $courses = DB::table('scourses')->get()->where('student_id',Auth::user()->id);
        return view('student.dashboard')->with('courses',$courses);
    }

    public function GetCourseIDofTeacher($req)
    {
        $cname_student = DB::table('scourses')->select('cname')->where('school_id',Auth::user()->school_id)->where('id',$req)->get();
        if(!$cname_student->isEmpty())
        {
            $course_id_teacher = DB::table('tcourses')->select('id')->where('school_id',Auth::user()->school_id)->where('cname',$cname_student[0]->cname)->get();
            if(!$course_id_teacher->isEmpty())
            {
                return $course_id_teacher[0]->id;
            }
        }
        return null;
    }

    public function ManageCourse(Request $request)
    {
        $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));

        if($mapped_Course != null)
        {
            $chapters = DB::table('chapters')->get()->where('school_id',Auth::user()->school_id)->where('course_id',$mapped_Course);
            
            if(!$chapters->isEmpty())
            {
                #TODO : get brodcast for this course , if isActive ==1 then just show the broadcast else check the eligiblity of the test , if eligible then goto test else just give him the chapters
                $broadcast = DB::table('broadcasts')->where('school_id',Auth::user()->school_id)->where('course_id',$mapped_Course)->get();

                if(!$broadcast->isEmpty())  //if there is something in broadcast , check it's isActive state.
                {
                    if ($broadcast[0]->isActive == 1)
                    {
                        return view('student.course')->with(['chapters'=>$chapters, 'course' => $request->route('courseId'), "info"=>$broadcast[0]->data]);
                    }
                    else
                    {
                        //get the active test where(isActive, 1);
                        $test = DB::table('tests')->where('school_id',Auth::user()->school_id)->where('course_id',$mapped_Course)->where('isActive', 1)->get();

                        if(!$test->isEmpty())
                        {
                            // check if i am Allowed to take test
                            $allowed_users = json_decode($test[0]->allowed, true);
                            foreach ($allowed_users as $key => $value)
                            {
                                if(Auth::user()->id == intval($value))
                                {
                                    return redirect('/student/'.$request->route('courseId').'/TakeTest');
                                }
                            }
                            
                            //if he is not allowed to take test. just let him get inside simply , show him only chapters
                            return view('student.course')->with(['chapters'=>$chapters, 'course' => $request->route('courseId')]);
                        }
                        else
                        {   //if test is Empty : teacher has not uploaded test yet. just let him get inside simply , show him only chapters
                            return view('student.course')->with(['chapters'=>$chapters, 'course' => $request->route('courseId')]);
                        }
                    }
                }
                else if($broadcast->isEmpty()) //if broadcast is Empty : teacher has not boradcasted anything yet. just let him get inside simply , show him only chapters
                {
                    return view('student.course')->with(['chapters'=>$chapters, 'course' => $request->route('courseId')]);
                }
            }
        }
        return redirect('/student')->withErrors(["WrongInput" => "No Content"]);
    }

    public function TakeTest(Request $request)
    {
        
        $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));

        if($mapped_Course != null)
        {
            
            //get the active test where(isActive, 1);
            $test = DB::table('tests')->where([
                'school_id' => Auth::user()->school_id,
                'course_id' => $mapped_Course,
                'isActive' => 1
            ])->get();

            $test_record = DB::table('test_record')->where([
                'school_id' => Auth::user()->school_id,
                'course_id' => $mapped_Course,
                'test_id' => $test[0]->id,
                'student_id' => Auth::user()->id
            ])->get();

            if(!$test->isEmpty() && $test_record->isEmpty()) //if there is test and i have already not taken it.
            {
                // check if i am Allowed to take test
                $allowed_users = json_decode($test[0]->allowed, true);
                if($allowed_users != null)
                {
                    foreach ($allowed_users as $key => $value)
                    {
                        if(Auth::user()->id == intval($value))
                        {
                            return view('student.TakeTest')->with('test', $test[0]);
                        }
                    }
                }
                //if he is not allowed to take test. just let him get inside simply , show him only chapters
                return redirect('/student/'.$request->route('courseId'));
            }
            else
            {   //if test is Empty : take him to course page
                return redirect('/student')->withErrors(["WrongInput" => "Currently Test is Active. Please wait while it finishes"]);
            }
        }
        
        return redirect('/student')->withErrors(["WrongInput" => "Some Error In Test"]);
    }


    //================================================
    // SHOW CHAPTER Content
    //================================================
    public function Show_Chapter_Content(Request $request)
    {
        $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));

        $chap_rec = DB::table('chapters_record')->where(
            [
                'student_id'=>Auth::user()->id,
                'course_id'=> $mapped_Course,
                'chapter_id'=> (int)$request->route('chapterId'),
                'school_id' => Auth::user()->school_id,
            ]
        )->get();

        $chapters = DB::table('chapters')->get()->where('id',$request->route('chapterId'))->where('school_id',Auth::user()->school_id);
        $cc = array();
        $chap_id;
        foreach($chapters as $chapter)
        {
            $d = json_decode($chapter->data,true);
            $chap_id = $chapter->id;
            array_push($cc,$d);
        }
        
        return view('student.chapter')->with(['chapters'=>$cc, 'chapter_id'=>$chap_id]);
    }

    //================================================
    // SHOW Round Robin Content
    //================================================
    public function Show_RR_Content(Request $request)
    {
        $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));

        $chap_rec = DB::table('chapters_record')->where(
            [
                'student_id'=>Auth::user()->id,
                'course_id'=> $mapped_Course,
                'chapter_id'=> (int)$request->route('chapterId'),
                'school_id' => Auth::user()->school_id,
            ]
        )->get();

        $chapters = DB::table('chapters')->get()->where('id',$request->route('chapterId'))->where('school_id',Auth::user()->school_id);
        $cc = array();
        $chap_id;
        foreach($chapters as $chapter)
        {
            $d = json_decode($chapter->data,true);
            $chap_id = $chapter->id;
            array_push($cc,$d);
        }

        if(!$chap_rec->isEmpty())   //if he alerady answered the quiz then take him to RoundRobin
        {
            $cptrs = $cc[0][key($cc[0])]['roundrobin']; //this will directly give us the questions
            //dd($cptrs);
            return view('student.roundrobin')->with([
                'chapters'=> $cptrs,
                'user_id' => Auth::user()->id,
                'course_id'=> $mapped_Course,
                'chapter_id'=> (int)$request->route('chapterId'),
                'school_id' => Auth::user()->school_id,
                'user_name' => Auth::user()->name,
                ]);
        }

        return back()->withErrors(["WrongInput" => "Please attempt chapter short quiz first"]);
    }

    public function CheckQuiz(Request $request)
    {   
        //CALLED BY AJAX FROM STUDENT SIDE
        $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));
        $chapId = $request->route('chapterId');

        $q = DB::table('chapters')->where('id', $chapId)->get();
        
        $question = $q->all()[0]->data;
        $question = json_decode($question, true);
        
        $response = array("score" => array(),"response" => array(), "keynotes" => $request->input('form_keynotes'));

        

        $count = 0;
        for($i = 0; $i <= count($question[key($question)]['quiz'])-1 ; $i++)
        {
            $correct = $question[key($question)]['quiz'][''.$i.'']['Correct'];
            $correct = $question[key($question)]['quiz'][''.$i.''][$correct];
            $answered = $request[''.$i.''];

            if($correct == $answered)
            {
                array_push($response["response"], (array)array( $question[key($question)]['quiz'][''.$i.'']['Q'] => "Correct"));
                $count += 1;
            }
            else
            {
                array_push($response["response"], (array)array( $question[key($question)]['quiz'][''.$i.'']['Q'] => "Correct is : ".$correct));
            }
        }
        
        array_push($response["score"], $count);
        
        $json = json_encode($response,true);
        
        $check = DB::table('chapters_record')->insert(
            [
                'chapter_id' => $chapId,
                'chapterName' => $q->all()[0]->chapterName,
                'school_id' => Auth::user()->school_id,
                'student_id' => Auth::user()->id,
                'course_id' => $mapped_Course,
                'data' => $json,
                'created_at' => Carbon::now()
            ]
        );

        if($check == true)
        {
            try {
                return $json;
            } catch (Exception $e) {
                return "ERROR";
            }
        }
    }

    public function CheckTest(Request $request)
    {
        if($request != null)
        {
            $mapped_Course = $this->GetCourseIDofTeacher($request->route('courseId'));
            
            if($mapped_Course != null)
            {
                //get the active test where(isActive, 1);
                $test = DB::table('tests')->where('school_id',Auth::user()->school_id)->where('course_id',$mapped_Course)->where('isActive', 1)->get();
                $test_record = DB::table('test_record')->where('school_id',Auth::user()->school_id)->where('course_id',$mapped_Course)->where('test_id', $test[0]->id)->get();
                
                if($request->test_id == $test[0]->id)
                {
                    if(!$test->isEmpty() && $test_record->isEmpty())    //if there is test and i have already not taken it.
                    {
                        
                        // check if i am Allowed to take test
                        $allowed_users = json_decode($test[0]->allowed, true);
                        foreach ($allowed_users as $key => $value)
                        {
                            if(Auth::user()->id == intval($value))
                            {
                                $d = json_decode($test[0]->data,true);
                                $e = json_decode($request->data,true);
                                $response = array();
                                
                                $length = count($d);
                                
                                if ($length != count($e))
                                {
                                    return "Question Answer Conflicts";
                                }

                                for ($x = 0; $x < $length; $x++) 
                                {
                                    
                                    if($d[$x]['type'] == "Descriptive")
                                    {
                                        array_push($response, array(-1, 0));
                                    }
                                    elseif ($d[$x]['type'] == "MCQ")
                                    {
                                        $score = 0;
                                        
                                        for ($i = 0; $i < count($e[$x]); $i++) //answer's array for the question
                                        {
                                            $selected = $e[$x][$i];

                                            for ($j = 0; $j < count($d[$x]["values"]); $j++)
                                            {
                                                if(array_key_exists($selected, $d[$x]["values"][$j]))
                                                {
                                                    $result = $d[$x]["values"][$j][$selected];
                                                    if($result == false)
                                                    {
                                                        $score = 0;
                                                        break 2;
                                                    }
                                                    else
                                                    {
                                                        $score++;
                                                    }
                                                }
                                            }
                                        }
                                        array_push($response, array(1, $score));
                                    }
                                    else if($d[$x]['type'] == "ImageMCQ")
                                    {
                                        $score = 0;
                                        
                                        for ($i = 0; $i < count($e[$x]); $i++) //answer's array for the question
                                        {
                                            $selected = $e[$x][$i];

                                            for ($j = 0; $j < count($d[$x]["values"]); $j++)
                                            {
                                                if(array_key_exists($selected, $d[$x]["values"][$j]))
                                                {
                                                    $result = $d[$x]["values"][$j][$selected];
                                                    if($result == false)
                                                    {
                                                        $score = 0;
                                                        break 2;
                                                    }
                                                    else
                                                    {
                                                        $score++;
                                                    }
                                                }
                                            }
                                        }
                                        array_push($response, array(1, $score));
                                    }
                                }

                                $test_record = json_encode($response);
                                
                                try 
                                {
                                    $count = DB::table('test_record')->insert(
                                        ['student_id' => Auth::user()->id,
                                        'school_id' => Auth::user()->school_id,
                                        'course_id' => $mapped_Course,
                                        'test_id' => (int)$request->test_id,
                                        'data' => $request->data,
                                        'marks' => $test_record,
                                        'created_at' => NOW()
                                        ]
                                    );
        
                                    if($count == true)
                                    {
                                        return "success";
                                    }
                                    else
                                    {
                                        return "Test Not Saved";
                                    }
                                } catch (Exception $th) 
                                {
                                    return "Error While Saving the Test";
                                }
                            }
                        }
                        //if he is not allowed to take test. take him to course page , show him only chapters
                        return "Test Submission Not Allowed";
                    }
                    else
                    {   //if test is Empty : take him to course page , show him only chapters
                        return "Test Submission Not Allowed";
                    }

                }
                else
                {
                    return "Course ID does not Match";
                }
            }
            else
            {
                return "Wrong Course ID";
            }
            
        }
        return 'Bad Request';  
    }


    //Submit RR
    public function SubmitRR(Request $request)
    {
        try 
        {
            $chapters = DB::table('chapters')->where([
                'school_id' => Auth::user()->school_id,
                'course_id' => $request->route('courseId'),
                'id' => $request->route('chapterId')
            ])->get();
            
            if(!$chapters->isEmpty())
            {
                $participants = array();
                
                $p = json_decode($request->input('users'), true);
                foreach ($p as $key => $value)
                {
                    $usr = DB::table('students')->where([
                        'school_id' => Auth::user()->school_id,
                        'id' => $value[0]
                    ])->get();
                    
                    $myArr = array();
                    array_push($myArr,$usr[0]->name);
                    array_push($myArr,$usr[0]->id);

                    array_push($participants,$myArr);
                }
                
                $count = DB::table('roundrobin_record')->insert(
                    [
                        'chapterName' => $chapters[0]->chapterName,
                        'chapter_id' => $request->route('chapterId'),
                        'school_id' => Auth::user()->school_id,
                        'course_id' => $request->route('courseId'),
                        'student_id' => Auth::user()->id,
                        'participants' => json_encode($participants,true),
                        'data' => $request->input('data'),
                        'messages' => $request->input('messages'),
                        'created_at' => NOW()
                    ]
                );
    
                if($count == true)
                {
                    return "success";
                }
                else
                {
                    return "Test Not Saved";
                }
            }
            
        } catch (Exception $th) 
        {
            return "Error While Saving the Test";
        }
    }




    //================================================
    // SUMMARY
    //================================================
    public function DetailedSummary(Request $request)
    {
        $courseid = $this->GetCourseIDofTeacher($request->route('courseId'));
        $student_id =  Auth::user()->id;
        
        $tests = DB::table('test_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id'=> $courseid,
            'student_id' => $student_id

        ])->get();

        $chapters = DB::table('chapters_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id'=> $courseid,
            'student_id' => $student_id

        ])->get();


        $round_robin = DB::table('roundrobin_record')->select()->where([
            'school_id' => Auth::user()->school_id,
            'course_id'=> $courseid
        ])->get();

        #After getting all the roundrobins for this course, we are now filtering them based on the participants. if this participant exisits in the array, then keep the record, otherwise reject the record
        $featured = $round_robin->filter(function($item, $key) use ($student_id){
            
            $pps =  json_decode($item->participants);
            for($i = 0; $i < count($pps); $i++)
            {
                if($pps[$i][1] == $student_id)
                {
                    return true;
                }
            }
            return false;
         });

        return view('student.viewProgress')->with(['tests' => $tests, 'chapters' => $chapters, 'roundRobins' => $featured, 'courseid' => $courseid, 'studentid' => $student_id]);
    }



    //=======================================
    //   VIEW THE Round Robin RECORD
    //=======================================

    public function ViewRR(Request $request)
    {
        $chapters = DB::table('roundrobin_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId'),
            'chapter_id' => $request->route('chapterId'),
            'id' => $request->route('recordId'),
        ])->get();
        
        if(!$chapters->isEmpty())
        {
            foreach ($chapters as $key => $value) {
                $pps =  json_decode($value->participants);
                if(is_countable($pps))
                {
                    for($i = 0; $i < count($pps); $i++)
                    {
                        if($pps[$i][1] == Auth::user()->id)
                        {
                            #Since the show pattern is same so we will just show it on Teacher Blade's templete
                            return view('teacher.viewRR_Record')->with(['chapters'=>$chapters]);
                        }
                    }
                }
            }
            return back()->withErrors(["WrongInput" => "Some Error In Record"]);
        }
        return back()->withErrors(["WrongInput" => "Some Error In Record"]);
    }

    //=======================================
    //   VIEW THE Quiz Record
    //=======================================
    public function StudentViewQuiz(Request $request)
    {
        $courseid = (int)$request->route('courseId');
        $test_record_Id = $request->route('chapter_record_Id');

        $data = DB::table('chapters_record')->where([
            'school_id' => Auth::user()->school_id,
            'student_id' => Auth::user()->id,
            'course_id'=> $courseid,
            'id' => $test_record_Id
        ])->get();
        
        if(!$data->isEmpty())
        {
            #Since the show pattern is same so we will just show it on Teacher Blade's templete
            return view('teacher.viewSubmittedChapter')->with(['data' => $data]);
        }
        return back()->withErrors(["WrongInput" => "Some Error In Record"]);
    }



}
