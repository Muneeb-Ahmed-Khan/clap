<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:teacher','verified']);
    }

    //======================================================================
    // Show all of his courses to HIM
    //======================================================================
    public function Dashboard()
    {
        $courses = DB::table('tcourses')->get()->where('teacher_id',Auth::user()->id);
        return view('teacher.dashboard')->with('courses',$courses);
    }

    //======================================================================
    // Show all of his CHAPTERS to HIM ABOUT the COURSE
    //======================================================================
    public function ManageCourse(Request $request)
    {
        $cname = DB::table('tcourses')->select('cname')->where('id', $request->route('courseId'))->where('teacher_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->get();
        if(!$cname->isEmpty())
        {
            $chapters = DB::table('chapters')->get()->where('teacher_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->where('course_id', $request->route('courseId'));

            $students_id = DB::table('scourses')->select('student_id')->where('cname', $cname[0]->cname)->where('school_id', Auth::user()->school_id)->get();

            $std = array();
            foreach ($students_id->all() as $s)
            {
                array_push($std, $s->student_id);
            }

            $students = DB::table('students')->select(['id','name'])->whereIn('id', $std)->where('school_id', Auth::user()->school_id)->get();

            return view('teacher.course')->with(['chapters'=>$chapters, 'course' => $request->route('courseId'), 'students' => $students]);
        }
        return redirect('/teacher')->withErrors(["WrongInput" => "Wrong Subject ID"]);
    }
    
    //======================================================================
    // Create a Brodcast
    //======================================================================
    public function ManageBroadcast(Request $request)
    {
        $check = DB::table('broadcasts')->updateOrInsert(
            ['course_id' => (int)$request->route('courseId')],
            [
                'school_id' => Auth::user()->school_id,
                'data' => $request->input('brodcastMsg'),
                'isActive' => 1
            ]

        );

        if($check == true)
        {
            return redirect()->intended('/teacher'.'/'.$request->route('courseId'))->with(["success" => "BroadCast Successfull"]);
        }

        return redirect()->intended('/teacher'.'/'.$request->route('courseId'))->withErrors(["Duplicate" => "Same BroadCast already Exists"]);
    }

    //======================================================================
    // Create a New Test
    //======================================================================
    public function CreateTest(Request $request)
    {
        //dd($request->route('courseId'));
        return view('teacher.createTest')->with("courseId" ,$request->route('courseId'));
    }

    //======================================================================
    // Manage Newly Created Test
    //======================================================================
    public function ManageCreatedTest(Request $request)
    {

        $imgList = explode(',', $request->input('imagesData'));
        
        $uploads = array();
        foreach($_FILES as $key0=>$FILES) {
            foreach($FILES as $key=>$value) {
                foreach($value as $key2=>$value2) {
                    $uploads[$key0][$key2][$key] = $value2;
                }
            }
        }
        //dd($uploads);

        if($uploads != null)
        {
            $targetDir = "content/";
                $allowTypes = array('jpg','jpeg','png');

                foreach($uploads["files"] as $key=>$value)
                {
                    if($uploads["files"][$key]["size"] < 50000000)
                    {
                        if($uploads["files"][$key]['error'] == 0)
                        {
                            if($uploads["files"][$key]["tmp_name"] != "")
                            {
                                $filename = $uploads["files"][$key]['name'];
                                $targetFilePath = $targetDir.NOW().time().$filename;
                                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                                if(in_array($fileType, $allowTypes))
                                {

                                }else {
                                    return "Extension Not Allowed";
                                }
                            }else {
                                return "Temporary File not Found in Header";
                            }
                        }else {
                            return "Error";
                        }
                    }else {
                        return "Size Greater than 50MB";
                    }
                }


                foreach($uploads["files"] as $key=>$value)
                {
                    if($uploads["files"][$key]['error'] == 0)
                    {
                        if($uploads["files"][$key]["tmp_name"] != "")
                        {
                            if($uploads["files"][$key]["size"] > 0)
                            {
                                $filename = $uploads["files"][$key]['name'];
                                //$targetFilePath = $targetDir.time().time().$filename;
                                $targetFilePath = $targetDir.$imgList[$key];
                                //dd($targetFilePath);
                                if(move_uploaded_file($uploads["files"][$key]['tmp_name'], $targetFilePath))
                                {

                                }
                                else
                                {
                                    return "Insertion ERROR";
                                }
                            }
                        }
                    }
                }
        }

        


        $check = DB::table('tests')->insert([

                'school_id' => Auth::user()->school_id,
                'course_id' => (int)$request->route('courseId'),
                'poster_name' => Auth::user()->name,
                'data' => $request->input('data'),
                'allowed' => '',
                'isActive' => 0,
                'created_at' => NOW()

            ]);

        // $check = DB::table('tests')->updateOrInsert(
        //     [
        //         'course_id' => (int)$request->route('courseId'),
        //         'school_id' => Auth::user()->school_id
        //     ],

        //     [
        //         'school_id' => Auth::user()->school_id,
        //         'course_id' => (int)$request->route('courseId'),
        //         'data' => $request->input('data'),
        //         'allowed' => '',
        //         'isActive' => 0
        //     ]
        // );

        if($check == true)
        {
            return "Test Saved Successfully";
        }
        else
        {
            return "Test Saved Failed";
        }
        return "Test Saved Failed";
    }

    public function StartTest(Request $request)
    {
        if($request->data != null)
        {
            
            #Disable the current Active test
            $active_test_disable = DB::table('tests')
            ->where([
                'school_id' => Auth::user()->school_id,
                'course_id' => (int)$request->route('courseId')
            ])
            ->update([
                'allowed' => '',
                'isActive' => 0
            ]);

            
            
            #Get the last test ID
            $last_test = DB::table('tests')->select('id')
            ->where([
                'school_id' => Auth::user()->school_id,
                'course_id' => (int)$request->route('courseId')
            ])
            ->orderBy('id', 'DESC')->first();
            
            
            
            #Activate the Test
            $check = DB::table('tests')
            ->where([
                'id' => $last_test->id,
                'school_id' => Auth::user()->school_id,
                'course_id' => (int)$request->route('courseId')
            ])
            ->update([
                'allowed' => $request->data,
                'isActive' => 1
            ]);

            if($check == true)
            {
                //Set the BroadCast to 0
                $check2 = DB::table('broadcasts')->where('school_id', Auth::user()->school_id)->where('course_id', (int)$request->route('courseId'))->update([
                    'isActive' => 0
                ]);

                return "success";
            }
            else
            {
                $check = DB::table('tests')->where('id', $last_test->id)->where('school_id',Auth::user()->school_id)->where('course_id', (int)$request->route('courseId'))->update([
                    'allowed' => '',
                    'isActive' => 0
                ]);

                return "BrodcastUpdateFailed";
            }
            return "TestUpdateFailed";
        }
        return "Failed";
    }


    public function stopTest(Request $request)
    {
        
        if($request != null)
        {

            $check = DB::table('tests')->where('school_id',Auth::user()->school_id)->where('course_id', (int)$request->route('courseId'))->update([
                'allowed' => '',
                'isActive' => 0
            ]);
            
            if($check == true)
            {
                return "success";
            }

            return "TestUpdateFailed";
        }
        return "Failed";
    }
    


    //======================================================================
    // View TEST to Teacher that was created by him.
    //======================================================================

    public function viewTest(Request $request)
    {
        $last_test = DB::table('tests')
        ->where('school_id', Auth::user()->school_id)
        ->where('course_id', (int)$request->route('courseId'))
        ->orderBy('id', 'DESC')->first();

        if($last_test != null)
        {
            return view('teacher.viewTest')->with('test',$last_test->data);
        }
        return redirect()->intended('/teacher')->withErrors(["WrongInput" => "Error in Test View."]);
    }

    public function ShowAllSharedTests(Request $request)
    {
        $shared_tests = DB::table('tests')->select()->where([
            'school_id' => Auth::user()->school_id,
            'course_id'=> (int)$request->route('courseId')
        ])->get();

        # After getting all the tests for this course, we are now filtering them based on the shared(column). 
        # if this participant exisits in the array, then keep the record, otherwise reject the record
        $teacher_id = Auth::user()->id;
        $featured = $shared_tests->filter(function($item, $key) use ($teacher_id){
            $pps = json_decode($item->shared);
            if(is_countable($pps))
            {
                for($i = 0; $i < count($pps); $i++)
                {
                    if($pps[$i] == $teacher_id)
                    {
                        return true;
                    }
                }
            }
            return false;
        });


        $last_test = DB::table('tests')
        ->where('school_id',Auth::user()->school_id)
        ->where('course_id', (int)$request->route('courseId'))
        ->orderBy('id', 'DESC')->first();
        
        
        return view('teacher.viewAllTests')->with(['alltests' => $featured, 'mytests' => $last_test]);
    }

    //======================================================================
    // View Progress of Students
    //======================================================================
    public function StudentProgress(Request $request)
    {
        
        $c_name = DB::table('tcourses')->select('cname')->where([
            'id'=> $request->route('courseId'),
            'school_id' => Auth::user()->school_id
        ])->get();
        
        $students = DB::select("select s.name,s.id from students s, scourses c where s.id=c.student_id and c.cname= ? and c.school_id= ? ",[$c_name[0]->cname, Auth::user()->school_id]);

        return view('teacher.viewProgress')->with(['students' => $students, 'courseid' => $request->route('courseId')]);
    }

    public function ShowFullProgress(Request $request)
    {
        $courseid = (int)$request->route('courseId');
        $student_id =  (int)$request->route('studentId');
        
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
            if(is_countable($pps))
            {
                for($i = 0; $i < count($pps); $i++)
                {
                    if($pps[$i][1] == $student_id)
                    {
                        return true;
                    }
                }
            }
           
            return false;
         });

        return view('teacher.viewFullProgress')->with(['tests' => $tests, 'chapters' => $chapters, 'roundRobins' => $featured, 'courseid' => $courseid, 'studentid' => $student_id]);
    }

    public function StudentEvaluation(Request $request)
    {
        $courseid = (int)$request->route('courseId');
        $student_id =  (int)$request->route('studentId');
        $test_record_Id = $request->route('test_record_Id');

        $answer = DB::table('test_record')->where('school_id',Auth::user()->school_id)->where('course_id', $courseid)->where('id', $test_record_Id)->get();
        if(!$answer->isEmpty())
        {
            $test = DB::table('tests')->where('id', $answer[0]->test_id)->where('school_id',Auth::user()->school_id)->where('course_id', $courseid)->get();
            
            if(!$answer->isEmpty() && !$test->isEmpty())
            {
                return view('teacher.viewEvaluation')->with(['test' => $test, 'answer' => $answer]);
            }
        }
        
        return redirect()->intended('/teacher')->withErrors(["WrongInput" => "Cannot Evaluate."]);
    }

    public function StudentViewQuiz(Request $request)
    {
        $courseid = (int)$request->route('courseId');
        $student_id =  (int)$request->route('studentId');
        $test_record_Id = $request->route('chapter_record_Id');

        $data = DB::table('chapters_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id'=> $courseid,
            'id' => $test_record_Id
        ])->get();
        
        if(!$data->isEmpty())
        {
            return view('teacher.viewSubmittedChapter')->with(['data' => $data]);
        }
        return back()->withErrors(["WrongInput" => "Record Empty"]);
    }



    public function AssignMarks(Request $request)
    {
        $courseid = (int)$request->route('courseId');
        $student_id =  (int)$request->route('studentId');
        $test_record_id = (int)$request->test_record_id;

        $check = DB::table('test_record')->where('id', $test_record_id)->where('student_id', $student_id)->where('school_id', Auth::user()->school_id)->where('course_id', (int)$request->route('courseId'))->update([
            'marks' => $request->data,
            'updated_at' => NOW()
        ]);

        if($check == true)
        {
            return 'success';
        }
        else
        {
            return 'Error While Saving';
        }
    }






    //======================================================================
    // Create a New Chapter
    //======================================================================
    public function NewChapter(Request $request)
    {
        return view('teacher.newchapter')->with('courseId',$request->route('courseId'));
    }

    

    //======================================================================
    // DELETE An Exisiting Chapter
    //======================================================================
    public function DeleteChapter(Request $request)
    {
        $chapters = DB::table('chapters')->where([
            'school_id' => Auth::user()->school_id,
            'teacher_id' => Auth::user()->id,
            'course_id' => $request->input('courseId'),
            'id' => $request->input('chapterId')
        ])->get();
        
        if(!$chapters->isEmpty())
        {   
            #Delete the chapter and all it's associated records
            DB::table('chapters')->where('id', $request->input('chapterId'))->delete();
            DB::table('chapters_record')->where('chapter_id', $request->input('chapterId'))->delete();
            DB::table('roundrobin_record')->where('chapter_id', $request->input('chapterId'))->delete();

            return back()->with('success', "Deleted Sucessfully");
        }

        return back()->withErrors(["WrongInput" => "Chapter does not Exists."]);
    }




    //======================================================================
    // When Teacher Creates a Chapter and he wants to view hy
    //======================================================================
    public function ViewAsStudent(Request $request)
    {

        $school = DB::select("select school_id from teachers where id = ? ",[Auth::user()->id]);
        if($school != null)
        {
            $chapters = DB::table('chapters')->get()->where('id',$request->route('chapterId'))->where('teacher_id',Auth::user()->id)->where('school_id',$school[0]->school_id);
            if($chapters != null)
            {
                $cc = array();
                foreach($chapters as $chapter)
                {
                    $d = json_decode($chapter->data,true);
                    array_push($cc,$d);
                }
                return view('teacher.viewAsStudent')->with('chapters',$cc);
            }
        }
        return redirect()->intended('/teacher')->withErrors(["WrongInput" => "Wrong Chapter ID"]);
    }

    public function CheckQuiz(Request $request)
    {
        return $request;
    }

    public function ManageNewChapter(Request $request)
    {
        //dd($_FILES);
        $uploads = array();
        foreach($_FILES as $key0=>$FILES) {
            foreach($FILES as $key=>$value) {
                foreach($value as $key2=>$value2) {
                    $uploads[$key0][$key2][$key] = $value2;
                }
            }
        }//dd($uploads);

        $targetDir = "content/";
        $allowTypes = array('csv','xls','mp4','jpg','jpeg','png');

        foreach($uploads["upload"] as $key=>$value)
        {
            if($uploads["upload"][$key]["size"] < 50000000)
            {
                if($uploads["upload"][$key]['error'] == 0)
                {
                    if($uploads["upload"][$key]["tmp_name"] != "")
                    {
                        $filename = $uploads["upload"][$key]['name'];
                        $targetFilePath = $targetDir.NOW().time().$filename;
                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                        if(in_array($fileType, $allowTypes))
                        {

                        }else {
                            return "Extension Not Allowed";
                        }
                    }else {
                        return "Temporary File not Found in Header";
                    }
                }else {
                    return "Error";
                }
            }else {
                return "Size Greater than 50MB";
            }
        }


        $f = array();
        $data = array("animation" => array(),"quiz" => array(), "roundrobin" => array());
        foreach($uploads["upload"] as $key=>$value)
        {
            if($uploads["upload"][$key]['error'] == 0)
            {
                if($uploads["upload"][$key]["tmp_name"] != "")
                {
                    if($uploads["upload"][$key]["size"] > 0)
                    {
                        if($key == "animation")
                        {
                            $filename = $uploads["upload"][$key]['name'];
                            $targetFilePath = $targetDir.time().time().$filename;
                            if(move_uploaded_file($uploads["upload"]["animation"]['tmp_name'], $targetFilePath))
                            {
                                array_push($f,$targetFilePath);
                                $data[$key] = array_merge($data[$key], (array)array('anim_title'=>$request->input('animationTitle')));
                                $data[$key] = array_merge($data[$key], (array)array('anim_file'=> $f[0]));
                                $data[$key] = array_merge($data[$key], (array)array('anim_keynotes'=>$request->input('animationKeyNotes')));
                            }
                            else
                            {
                                return "Insertion ERROR";
                            }

                        }
                        elseif ($key == 'quiz')
                        {
                            $fft = $uploads["upload"]["quiz"]['tmp_name'];
                            $file = fopen($fft, "r");
                            while (($column = fgetcsv($file, 1000, ",")) !== FALSE)
                            {
                                $b = array("Q"=>$column[0], "A"=>$column[1],"B"=>$column[2],"C"=>$column[3],"D"=>$column[4],"Correct"=>$column[5]);
                                array_push($data["quiz"],$b);
                            }
                        }
                        elseif($key == 'roundrobin')
                        {
                            $filename = $uploads["upload"][$key]['tmp_name'];
                            $file = fopen($filename, "r");

                            while (($column = fgetcsv($file, 1000, ",")) !== FALSE)
                            {
                                $b = array("Q"=>$column[0]);
                                array_push($data["roundrobin"],$b);
                            }
                        }
                    }
                }
            }
        }
        $post_data = json_encode(array($request->input('chapterName') => $data),true);

        $school = DB::select("select school_id from teachers where id = ? ",[Auth::user()->id]);

        $count = DB::table('chapters')->insert(
            ['chapterName' => $request->input('chapterName'),
            'school_id' => $school[0]->school_id,
            'teacher_id' => Auth::user()->id,
            'course_id' => (int)$request->route('courseId'),
            'data' => $post_data]
        );
        if($count == true)
        {
            try {
                return redirect('/teacher'.'/'.$request->route('courseId'))->with(["success" => "Chapter Added Successfully"]);
            } catch (Exception $e) {
                dd($e);

                return false;
            }
        }
        return redirect('/teacher'.'/'.$request->route('courseId'))->withErrors(["SomethingWentWrong" => "Something went wrong"]);
    }

    


    //===========================================
    // CHAPTER SUMMARY
    //===========================================
    public function ChapterSummary(Request $request)
    {

        $c_name = DB::table('tcourses')->select('cname')->where([
            'id'=> $request->route('courseId'),
            'school_id' => Auth::user()->school_id
        ])->get();
        
        $total_students = DB::select("select s.name,s.id from students s, scourses c where s.id=c.student_id and c.cname= ? and c.school_id= ? ",[$c_name[0]->cname, Auth::user()->school_id]);

        $chapters_records = DB::table('chapters_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId'),
            'chapter_id' => $request->route('chapterId')
        ])->get();

        $roundrobin_records = DB::table('roundrobin_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId'),
            'chapter_id' => $request->route('chapterId')
        ])->get();
        
        
        $results = array();
        for($i = 0; $i < count($total_students); $i++)
        {
            $std = array('id' => $total_students[$i]->id ,'name' => $total_students[$i]->name, 'quiz' => array(), 'rr' => array());
            

            //Checking if this student submitted the chapter or not, if yes, update the submitted and score values in aray
            $chapter = array();
            $chapter['submitted'] = 0;
            $chapter['score'] = 0;
            $chapter['chap_id'] = -1;

            for($j = 0; $j < count($chapters_records); $j++)
            {
                if($chapters_records[$j]->student_id == $total_students[$i]->id)
                {
                    $chapter['submitted'] = 1;
                    $chapter['chap_id'] = $chapters_records[$j]->id;
                    $chapter['score'] = json_decode($chapters_records[$j]->data, true)['score'][0];
                }
            }
            $std['quiz'] =  $chapter;


            //checking if this student has taken any part in round_robin
            $rr = array();
            $rr['submitted'] = 0;
            $rr['rr_id'] = -1;

            for($j = 0; $j < count($roundrobin_records); $j++)
            {
                $p_array = json_decode($roundrobin_records[$j]->participants);

                for($k = 0; $k < count($p_array); $k++)
                {
                    //If this student is in the list of participants.
                    if($p_array[$k][1] == $total_students[$i]->id)
                    {
                        $rr['submitted'] = 1;
                        $rr['rr_id'] = $roundrobin_records[$j]->id;
                    }
                }
            }
            $std['rr'] =  $rr;
            
            //Now push this student to results.
            array_push($results, $std);
        }
        
        #dd($results);
        return view('teacher.chapterSummary')->with(['results' => $results]);
    }

    //=======================================
    //   COURSE SUMMARY
    //=======================================
    public function CourseSummary(Request $request)
    {
        $c_name = DB::table('tcourses')->select('cname')->where([
            'id'=> $request->route('courseId'),
            'school_id' => Auth::user()->school_id
        ])->get();
        
        //All students associated with this course
        $total_students = DB::select("select s.name,s.id from students s, scourses c where s.id=c.student_id and c.cname= ? and c.school_id= ? ",[$c_name[0]->cname, Auth::user()->school_id]);
        
        //All chapters associated with this course
        $total_chapters =  DB::table('chapters')->where([
            'teacher_id'=> Auth::user()->id,
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId')
        ])->get();
        
        //All quizes records associated with this course
        $chapters_records =  DB::table('chapters_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId')
        ])->get();

        //All roundrobbins records associated with this course
        $roundrobin_records =  DB::table('roundrobin_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId')
        ])->get();



        $results = array();
        for($i = 0; $i < count($total_students); $i++)
        {
            $std = array('name' => $total_students[$i]->name, 'chapter' => array());
            
            //For every chapter, check if this student has done the quiz and roundrobin
            for($chap = 0; $chap < count($total_chapters); $chap++)
            {
                $std_chapter = array();
                $std_chapter['name'] = $total_chapters[$chap]->chapterName;
                $std_chapter['chapterId'] = $total_chapters[$chap]->id;
                

                //Checking the quiz
                $quiz = array();
                $quiz['submitted'] = 0;
                $quiz['chap_id'] = -1;
                $quiz['score'] = 0;
                foreach ($chapters_records as $index => $record) {

                    //check if we are at the right chapter record and if this student has appempted it
                    if($record->chapter_id == $total_chapters[$chap]->id && $record->student_id == $total_students[$i]->id)
                    {
                        $quiz['submitted'] = 1;
                        $quiz['chap_id'] = $record->id;
                        $quiz['score'] = json_decode($record->data, true)['score'][0];
                    }
                }
                array_push($std_chapter, $quiz);




                //Checking the RoundRobin Records, if any record for this i-th student attempthing this chapter is found, we say he did attempted RR
                $rr = array();
                $rr['submitted'] = 0;
                $rr['rr_id'] = -1;

                foreach ($roundrobin_records as $index => $record) {
                    
                    //check if we are at the right chapter record and if this student has appempted it
                    if($record->chapter_id == $total_chapters[$chap]->id)
                    {
                        $p_array = json_decode($record->participants);
                        for($k = 0; $k < count($p_array); $k++)
                        {
                            //If this student is in the list of participants.
                            if($p_array[$k][1] == $total_students[$i]->id)
                            {
                                $rr['submitted'] = 1;
                                $rr['rr_id'] = $record->id;
                            }
                        }
                    }
                }
                array_push($std_chapter, $rr);
                
                array_push($std['chapter'], $std_chapter);

            }
            
            array_push($results, $std);
        }




        //dd($results);

        //dd($c_name, $total_students, $total_chapters, $total_quizes_records, $total_rr_records);

        return view('teacher.courseSummary')->with(['results' => $results]);

    }



    //=========================================
    //  SHOW ALL THE ROUND ROBINS SUBMITTED
    //=========================================

    public function ListRR(Request $request)
    {
        $chapters = DB::table('roundrobin_record')->where([
            'school_id' => Auth::user()->school_id,
            'course_id' => $request->route('courseId'),
            'chapter_id' => $request->route('chapterId')
        ])->get();
        
        if(!$chapters->isEmpty())
        {
            return view('teacher.listRR')->with(['chapters'=>$chapters]);
        }
        return back()->withErrors(["WrongInput" => "No Round Robin Exists."]);
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
            return view('teacher.viewRR_Record')->with(['chapters'=>$chapters]);
        }
        return back()->withErrors(["WrongInput" => "Record Empty"]);
    }
}
