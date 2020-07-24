@extends('layouts.dashboardEssentials')
@section('content')
<style>
body{
    margin-top:40px;
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
    margin-top: 30px;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}

.col-lg-custom {
    min-width : 300px;
    width: 100%;
}
.card {
    box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,0.03), 0 0.9375rem 1.40625rem rgba(4,9,20,0.03), 0 0.25rem 0.53125rem rgba(4,9,20,0.05), 0 0.125rem 0.1875rem rgba(4,9,20,0.03);
    border-width: 0;
    transition: all .2s;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(26,54,126,0.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    padding: 1.25rem;
}
.card-title {
    text-transform: uppercase;
    color: rgba(13,27,62,0.7);
    font-weight: bold;
    font-size: 20px;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: rgba(0,0,0,0);
}

.container
{
    padding :0px;
    margin : 0px;
}

.activePage
{
    background : #03a9f4 !important;
    color: white !important;
}
video {
  width: 100%;
  height : 480px;
}

input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;

  border-radius: 50%;
  width: 16px;
  height: 16px;

  border: 2px solid #999;
  transition: 0.2s all linear;
  margin-right: 5px;

  position: relative;
  top: 4px;
}

input:checked {
  border: 8px solid #0973eb;
}




.base-timer {
  position: relative;
  width: 300px;
  height: 300px;
}

.base-timer__svg {
  transform: scaleX(-1);
}

.base-timer__circle {
  fill: none;
  stroke: none;
}

.base-timer__path-elapsed {
  stroke-width: 7px;
  stroke: grey;
}

.base-timer__path-remaining {
  stroke-width: 7px;
  stroke-linecap: round;
  transform: rotate(90deg);
  transform-origin: center;
  transition: 1s linear all;
  fill-rule: nonzero;
  stroke: currentColor;
}

.base-timer__path-remaining.green {
  color: rgb(65, 184, 131);
}

.base-timer__path-remaining.orange {
  color: orange;
}

.base-timer__path-remaining.red {
  color: red;
}

.base-timer__label {
  position: absolute;
  width: 300px;
  height: 300px;
  top: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 48px;
}

/* Button used to open the chat form - fixed at the bottom of the page */
.open-button {
    border-radius: 60%;
    background-color: #337ab7;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    position: fixed;
    bottom: 10px;
    right: 10px;
    outline:0;
}

/* The popup chat - hidden by default */
.chat-popup {
  /* display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9; */
}

/* Add styles to the form container */
.chat-popup {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width textarea */
.chat-popup textarea {
  width: 100%;
  /* padding: 15px; */
  /* margin: 5px 0 22px 0; */
  border: none;
  background: #f1f1f1;
  resize: none;
  /* min-height: 200px; */
}

.chat-popup .messageArea
{
    margin-bottom: 10px;
    scroll-behavior: smooth;
    overflow-y: scroll;
    min-height: 400px;
    max-height: 400px;
    background: #f1f1f1;
}

/* When the textarea gets focus, do something */
.chat-popup textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.chat-popup .btn {
    float: right;
    background-color: #4CAF50;
    color: white;
    border: none;
    width: 49%;
    opacity: 0.8;
}

/* Add a red background color to the cancel button */
.chat-popup .cancel {
    float: left;
    background-color: red;
}

/* Add some hover effects to buttons */
.chat-popup .btn:hover, .open-button:hover {
  opacity: 1;
}

/* width */
::-webkit-scrollbar {
  width: 6px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #c5c5c5; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

#msgArea::-webkit-scrollbar {
  display: none;
}


#questions{
    max-height: 477px;
    overflow-y: scroll;
    padding: 10px;
}


.row {
    margin-right: 0;
}
.msg_container {
        padding: 10px;
        overflow: hidden;
        display: flex;
    }
    
.base_sent {
    justify-content: flex-end;
    align-items: flex-end;
}

.col-md-2, .col-md-10 {
    padding: 0;
}

.messages {
    background: white;
    padding: 10px;
    border-radius: 2px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    max-width: 100%;
}

.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
}

.messages > time {
    font-size: 11px;
    color: #ccc;
}

.msg_sent > time {
    float: right;
}

.msg_receive {
    margin-left: 0;
}

.msg_date{
    font-size: 10px;
    padding-top: 12px;
    float: right;
    color: grey;
}

</style>


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-database.js"></script>
<script>
        var firebaseConfig = {
        apiKey: "AIzaSyC9hxLROGIJH-sGNtReZRLZrRB3tIcpZA4",
        authDomain: "roundrobingroups.firebaseapp.com",
        databaseURL: "https://roundrobingroups.firebaseio.com",
        projectId: "roundrobingroups",
        storageBucket: "roundrobingroups.appspot.com",
        messagingSenderId: "908703545786",
        appId: "1:908703545786:web:99f7807a2ab4d492d84583",
        measurementId: "G-ML9TX7PB0S"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
</script>


<div id="main" class="main-padding main-dashboard extend">

    <div class="container">
        <a type="button" id="Start_RR" disabled  style='margin-top: 5px; display:none' class="btn btn-primary">Start</a>
    </div>
    <br>

    <div class="col-lg-custom">
        <div class="main-card mb-3 card" style="flex-direction: row;">
            
            <div class="card-body" id="card-body" style=" width: 65%; ">
                
                <div id='questions' style="display:none">
                <?php
                    foreach ($chapters as $key => $value) {
                        foreach ($value as $k2 => $v2)
                        {
                            echo '<div style="display: none;">';
                            echo '<label>'.$v2.'</label>';
                            echo '<textarea disabled class="form-control text-area" id="'.$key.'"  placeholder="Someone is typing..."></textarea>';
                            echo '</div>';
                        }
                    }
                ?>
                </div>
            
                <button id="next_RR" disabled class="btn btn-success btn-lg pull-right" style="margin-top:10px;">Next</button>
            </div>

            <div class="chat-popup" id="chatBox" style="width: 30%; margin-top:20px; margin-right:10px; margin-bottom:10px; display: flex; flex-flow: column;">
                
                <div style="border-style: solid;border-color: #ccc; padding: 6px;">
                    <div class="messageArea" id="msgArea" style="flex: 1 1 auto;">
                        <!-- Messages to be appended here -->
                    </div>
                    <textarea placeholder="Type message.." id="user_msg" required></textarea>
                    <button id="send_msg" class="btn" style="width:100%">Send</button>
                </div>

            </div>
            
        </div>
        
    </div>
    
</div>

<!-- <button class="open-button" id="chatOpner" style="display:none;" onclick="$('#chatBox').css('display','block');">Chat</button>

 <div class="chat-popup" id="chatBox">
    
        
        <div class="messageArea" id="msgArea">
                //Messages to be appended here
        </div>
        <textarea placeholder="Type message.." id="user_msg" required></textarea>

        <button id="send_msg" class="btn">Send</button>
        <button type="button" class="btn cancel" onclick="$('#chatBox').css('display','none');">Close</button>
    
</div> -->



<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
<script>
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
</script>

<script>

var school_id = '{!! $school_id !!}';
var course_id = '{!! $course_id !!}';
var chapter_id = '{!! $chapter_id !!}';

var user_id = '{!! $user_id !!}';
var user_name = '{!! $user_name !!}';

room_id = String(school_id) + String(course_id) + String(chapter_id)
var initial_roomID = room_id;

var users = []

function CreatedRoom(msg) {
    console.log(msg);
    //Command: toastr["success"]("Room Created");
    startTimer();
}

function connectToRoom(rm_id)
{
    room_id = rm_id;

    firebase.database().ref(rm_id + "/people/").ref.transaction(function(currentClicks) {
    
        // If node/clicks has never been set, currentRank will be `null`.
        var newValue = (currentClicks || 0) + 1;
        
        if (newValue > 3) 
        {
            console.log("Transaction ABORT");
            return; // abort the transaction
        }

        return newValue;

    
    }, function(error, committed, snapshot) 
    {
        if (error) 
        {
            console.log('Transaction failed abnormally!', error);
        } 
        else if (!committed) 
        {
            console.log('Room Already Full, Creating a New Room');

            nextRoom = rm_id+"_";
            connectToRoom(nextRoom);

            //Update Room id
            firebase.database().ref("latestRoomCreated/" + initial_roomID).transaction(function(latest_room_ID) {
                return nextRoom;
            },function(err, comm, sn)
            {
                if(comm)
                {
                    CreatedRoom("-----------This Person just Created this Room-------------");
                }
            }, false);

        } 
        else
        {
            firebase.database().ref(rm_id + "/users/" + user_id).set(0);
            var ref = firebase.database().ref(rm_id + "/users/" + user_id);
            ref.onDisconnect().remove();
            console.log('CONNECTED TO ROOM ----- Seat count updated and User Added');

            listenforRR_Start(rm_id);

        }

      }, false).then(() => {
        console.log("Tickets updated.");
      });
}


function getLatestRoom()
{
    var _curr_room;
    
    firebase.database().ref('/latestRoomCreated/' + initial_roomID).once('value').then(function(snapshot) {
        _curr_room = snapshot.val(); 
        console.log("Vacent Room : " + _curr_room);
        
        if(_curr_room == null)  //meaning this is first try for this Activity,Couse,chatpter
        {
            _curr_room = initial_roomID; 

            /* if the Vacent Room is null so, create the record for new room. */
            firebase.database().ref("latestRoomCreated/" + initial_roomID).transaction(function(latest_room_ID) {
                if(latest_room_ID == null)
                {
                    return _curr_room;
                }
            }, function(err, comm, sn)
            {
                if(comm)
                {
                    CreatedRoom("-------------This Person just Created the First Room---------------");
                }
            }, false);
        }

        connectToRoom(_curr_room);

    });
    return _curr_room;
}



room_id = getLatestRoom();


$( "#Start_RR" ).click(function() {
    console.log("ROOM ID : " + room_id);
    firebase.database().ref(room_id + "/people").set(4)
    .then((snapshot)=>{
        console.log("Status Update to 4 (RR should start NOW)");
    });
});



function MyTurn_First(rm_id) {
    firebase.database().ref(rm_id + "/users/" + user_id).set(1).then(() => {
        console.log("MY TURN NOW...");
    });
}


function listenforRR_Start(rm_id) {

    //Toster Command
    Command: toastr["success"]("Connected To Room");
    $('#chatOpner').css('display','block');

    var rr_startedListner = firebase.database().ref(rm_id + "/people");
    rr_startedListner.on('value', (snap) =>
    {
        if(snap.val() > 3)
        {
            RR_Started(rm_id);
            rr_startedListner.off("value");
        }
        console.log("Total Users : " + snap.val());
    });

}

function RR_Started(rm_id) {

    //Toster Command
    Command: toastr["success"]("Round Robin Started");
    console.log("Round Robin Started");
    
    $('#questions').css("display", "block");

    //Manage User Removed
    firebase.database().ref(rm_id + "/users").on('child_removed',function(snapshot){
            
            var index;
            for(index = 0 ; index < users.length; index++) {
                if (users[index][0] == snapshot.key)
                {
                    break;
                }
            }
            if (index > -1) {
                users.splice(index, 1);
            }
            console.log(users);

            //check if the user that has Turn Open is disconnected. then open Turn for first user.
            var deadlock = true;
            for(var index = 0 ; index < users.length; index++) 
            {
                if (users[index][1] == 1)
                {
                    /* if there is any user that has the Turn open and he is currently connected.
                    then this means that there is no deadlock. */
                    deadlock = false
                }
            }
            if(deadlock)
            {
                //give turn to 1st User in the Array
                users[0][1] = 1;

                firebase.database().ref(room_id + "/users/" + users[0][0]).set(1).then(() => {
                    console.log("User Turn Updated");
                });
                //Find Out whose Turn is it.
                findWhoTurn();
            }


    });

    //Manage User's state and Turn here
    firebase.database().ref(rm_id + "/users").on('child_changed',function(snapshot){
        
            console.log("------TURN UPDATED------");
            for(var index = 0 ; index < users.length; index++) {
                if (users[index][0] == snapshot.key)
                {
                    users[index][1] = snapshot.val();
                    console.log(users);
                }
            }
            //Find Out whose Turn is it.
            findWhoTurn();

    });

    
    //After Round Robin Start, Update the Turn for First User in the NodeList
    var deploy_first_turn = firebase.database().ref(rm_id + "/users");
    deploy_first_turn.once('value', function(snapshot){
        
        //Get all userIds
        snapshot.forEach(function(_child){
            users.push([_child.key, _child.val()]);
        });
        
        console.log(users);

        //if first User is me, Update the Value to 1 for me.
        if(users[0][0] == user_id)
        {
            MyTurn_First(rm_id);
        }
        //Turn off get_connected_users
        deploy_first_turn.off("value");
    });



    
    //Manage New Message Added to Room in Database

    //Message Added Event
    firebase.database().ref(rm_id + "/messages").on('child_added',function(snapshot){
        
            
            _msg_user = snapshot.key;
            _message = snapshot.val();
            console.log("INCOMING MESSAGE >>>>" + _message);
            var today = new Date();

            local_messageUser = _msg_user.split('__')[1];
            date = local_messageUser + ', ' + today.getHours() + ":" + today.getMinutes() + ", " + today.getDate() + "-" + (today.getMonth() + 1) + "-" + today.getFullYear();
                
            
            if(_msg_user == user_id + "__" + user_name)
            {
                
                createElement = '<div class="row msg_container base_sent">';
                createElement +=    '<div class="col-md-10 col-xs-10">'
                createElement +=        '<div class="messages msg_sent">'
                createElement +=            '<p msg-owner="'+ _msg_user +'">'+ _message +'</p>'
                createElement +=            '<msg class="msg_date" date="'+ date +'">'+ date +'</msg>'
                createElement +=        '</div>'
                createElement +=    '</div>'
                createElement += '</div>'

                $("#msgArea").append(createElement);
            }
            else if(_msg_user != user_id)
            {

                createElement = '<div class="row msg_container base_receive">';
                createElement +=    '<div class="col-xs-10">'
                createElement +=        '<div class="messages msg_receive">'
                createElement +=            '<p msg-owner="'+ _msg_user +'">'+ _message +'</p>'
                createElement +=            '<msg class="msg_date" date="'+ date +'">'+ date +'</msg>'
                createElement +=        '</div>'
                createElement +=    '</div>'
                createElement += '</div>'

                $("#msgArea").append(createElement);
            }

            $("#msgArea").animate({ scrollTop: $('#msgArea').prop("scrollHeight")}, 250);
            

    });

    //Message change Event
    firebase.database().ref(rm_id + "/messages").on('child_changed',function(snapshot){
        
            
        _msg_user = snapshot.key;
        _message = snapshot.val();
        console.log("INCOMING MESSAGE >>>>" + _message);
        
        var today = new Date();

        local_messageUser = _msg_user.split('__')[1];
        date = local_messageUser + ', ' + today.getHours() + ":" + today.getMinutes() + ", " + today.getDate() + "-" + (today.getMonth() + 1) + "-" + today.getFullYear();
            
        
        if(_msg_user == user_id + "__" + user_name)
        {
            
            createElement = '<div class="row msg_container base_sent">';
            createElement +=    '<div class="col-md-10 col-xs-10">'
            createElement +=        '<div class="messages msg_sent">'
            createElement +=            '<p msg-owner="'+ _msg_user +'">'+ _message +'</p>'
            createElement +=            '<msg class="msg_date" date="'+ date +'">'+ date +'</msg>'
            createElement +=        '</div>'
            createElement +=    '</div>'
            createElement += '</div>'

            $("#msgArea").append(createElement);
        }
        else if(_msg_user != user_id)
        {

            createElement = '<div class="row msg_container base_receive">';
            createElement +=    '<div class="col-xs-10">'
            createElement +=        '<div class="messages msg_receive">'
            createElement +=            '<p msg-owner="'+ _msg_user +'">'+ _message +'</p>'
            createElement +=            '<msg class="msg_date" date="'+ date +'">'+ date +'</msg>'
            createElement +=        '</div>'
            createElement +=    '</div>'
            createElement += '</div>'

            $("#msgArea").append(createElement);
        }

        $("#msgArea").animate({ scrollTop: $('#msgArea').prop("scrollHeight")}, 250);
        

    });

    $( "#send_msg" ).click(function() {
        msg = document.getElementById('user_msg').value;
        m = {};
        m[user_id + "__" + user_name] = msg
        firebase.database().ref(rm_id + "/messages").set(m, function () {
                console.log("Message Sent : " + m);
                document.getElementById('user_msg').value = "";
            });
    });




    //Manage New Answer Added to Room in Database
    firebase.database().ref(rm_id + "/answers").on('child_added',function(snapshot){
        _msg_user = snapshot.key;
        _message = snapshot.val();
        console.log("INCOMING ANSWER >>>>" + _message);
        
        if(_msg_user != (user_id + "__" + user_name))
        {
            textareas = $("#questions")[0].querySelectorAll("textarea");
            for(var i = 0 ; i < textareas.length; i++)
            {
                if(textareas[i].value == "")
                {
                    $(textareas[i]).attr('answer-owner', _msg_user);
                    textareas[i].value = _message;
                    break;
                }
            }
        }

        //Scroll Down the Questions Div
        $("#questions").animate({ scrollTop: $('#questions').prop("scrollHeight")}, 250);
        
    });

    //Manage when all answers are submitted to fireabse and we are ready to go to dashboard
    firebase.database().ref(rm_id + "/submitted").on('child_added',function(snapshot){
        _msg_user = snapshot.key;
        _message = snapshot.val();

        //if someone else submitted it then, if i was to submit it i would already have gone before this event listner is called.
        if(_message == 1 && _msg_user != user_id + "__" + user_name)
        {
            window.location.href = '/student/' + {{request()->route('courseId')}};
        }
    });
}

function findWhoTurn(index) {
    
    for(var index = 0 ; index < users.length; index++) 
    {
        if (users[index][0] == user_id)
        {
            if(users[index][1] == 1)
            {
                MyTurn(true)
            }
            else
            {
                MyTurn(false)
            }
        }
    }

    $("#questions").animate({ scrollTop: $('#questions').prop("scrollHeight")}, 250);
}

function MyTurn(check) {

    
    console.log("MY TRUN >>>>>>>>>" + check)

    if(check)
    {
        textareas = $("#questions")[0].querySelectorAll("textarea");
        for(var i = 0 ; i < textareas.length; i++)
        {
            if(textareas[i].value == "")
            {
                $(textareas[i]).removeProp('disabled');
                $(textareas[i]).prop('placeholder', "Type your answer...");
                $(textareas[i]).parent().show();
                break;
            }
        }

        $( "#next_RR" ).prop('disabled', false);
        $( "#next_RR" ).css('background-color','blue');

        //If it is my Turn and all the questions are already answered, then Change the text from 'Next' to 'Submit'
        textareas = $("#questions")[0].querySelectorAll("textarea:enabled");
        if(textareas.length <= 0)
        {
            $( "#next_RR" ).html('Submit');
            $( "#next_RR" ).toggleClass("btn-success");
            $( "#next_RR" ).toggleClass("btn-info");
        }
    }
    else
    {
        textareas = $("#questions")[0].querySelectorAll("textarea");

        //Show the first unanswered question.
        for(var i = 0 ; i < textareas.length; i++)
        {
            if(textareas[i].value == "")
            {
                $(textareas[i]).parent().show();
                break;
            }
        }

        for(var i = 0 ; i < textareas.length; i++)
        {
            $(textareas[i]).prop('disabled', true);
        }

        $( "#next_RR" ).prop('disabled', true);
        $( "#next_RR" ).css('background-color','red');
    }
}

$( "#next_RR" ).click(function() {

    textareas = $("#questions")[0].querySelectorAll("textarea:enabled");

    if(textareas.length > 0)    //if it is my turn and is any answer left that should be answered
    {
        for(var i = 0 ; i < textareas.length; i++)
        {
            if(textareas[i].value == "")
            {
                //If i have not answered it and i click next, then retun and don't let him 
                return;
            }

            answer = textareas[i].value;
            console.log("ANSWER >>>> " + answer);
            $(textareas[i]).prop('disabled', true);
            $(textareas[i]).attr('answer-owner', user_id + "__" + user_name);

            m = {};
            m[user_id + "__" + user_name] = answer
            firebase.database().ref(room_id + "/answers").set(m, function () {
                    
                            console.log("Answer Sent : " + m);
                            for(var index = 0 ; index < users.length; index++) 
                            {
                                if (users[index][0] == user_id)
                                {
                                    if(users[index][1] == 1)
                                    {
                                        users[index][1] = 0;

                                        index++;
                                        if(index > (users.length - 1))
                                        {
                                            index = 0;
                                        }
                                        firebase.database().ref(room_id + "/users/" + user_id).set(0).then(() => {
                                            console.log("MY TURN - 0");

                                            firebase.database().ref(room_id + "/users/" + users[index][0]).set(1).then(() => {
                                                console.log("User Turn Updated");
                                            });

                                        });
                                        break;
                                    }
                                }
                            }
                });
        }
    }
    else    //if it is my turn and there is no question to be answered left
    {
        console.clear();

        qs = $("#questions")[0].querySelectorAll("label");
        ans = $("#questions")[0].querySelectorAll("textarea");

        

        if(qs.length == ans.length)
        {
            //get all Answers and store it in jsonObj array
            jsonObj = new Array();
            for(var i = 0 ; i < ans.length; i++)
            {
                item = new Object();

                item['question'] = qs[i].innerText;
                item['answer-owner'] = $(ans[i]).attr("answer-owner").split('__')[0];
                item['answer-owner-name'] = $(ans[i]).attr("answer-owner").split('__')[1];
                item['answer'] = ans[i].value;

                jsonObj.push(item);
            }


            //get all messages and store it in jsonObj_message array
            jsonObj_message = new Array();
            messages = $("#msgArea")[0].querySelectorAll("p");
            timestamps = $("#msgArea")[0].querySelectorAll("msg");
            for(var i = 0 ; i < messages.length; i++)
            {
                item = new Object();

                item['msg-owner'] = $(messages[i]).attr("msg-owner");
                item['message'] = messages[i].innerText;
                item['msg-timestamp'] = $(timestamps[i]).attr("date");

                jsonObj_message.push(item);
            }
            
            console.log(jsonObj);
            console.log(jsonObj_message);
            





            const formData = new FormData();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            formData.append('_token', CSRF_TOKEN);
            formData.append('data', JSON.stringify(jsonObj));
            formData.append('messages', JSON.stringify(jsonObj_message));
            formData.append('users', JSON.stringify(users));

            console.clear();
            console.log(formData);

            $.ajax({
                method: 'POST', // Type of response and matches what we said in the route
                url: '/student/' + '{!! $course_id !!}' + '/' + '{!! $chapter_id !!}' + '/submitRR', // This is the url we gave in the route
                data: formData, // a JSON object to send back
                cache: false,
                contentType: false,
                processData: false,

                xhr: function() {
                                var myXhr = $.ajaxSettings.xhr();
                                return myXhr;
                            },

                success: function(response){ // What to do if we succeed
                    console.log(response);
                    if(response == "success")
                    {
                        Command: toastr["success"]("Answers Saved Successfully");
                        //since it is saved successfully now to inform others in firebase make submitted == 1
                        m = {};
                        m[user_id + "__" + user_name] = 1;
                        firebase.database().ref(room_id + "/submitted").set(m, function () {
                                window.location.href = '/student/' + {{request()->route('courseId')}};
                            });
                    }

                    
                },

                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    alert("Couldn't Save Answers");
                }
            });

        }
        else
        {
            alert("Question and Answers Lenght does not match.");
        }
    }
});
</script>



<script>
    // Credit: Mateusz Rybczonec

const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};

const TIME_LIMIT = 13;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;



function onTimesUp() {

    clearInterval(timerInterval);
    //When Time is Up, Start the Round Robin.
    $( "#Start_RR" ).prop('disabled', false);
    //$( "#Start_RR" ).css('display', 'inline-block');
    $( "#Start_RR" ).click();

    $("#card-body").find('center').first().remove();
}

function startTimer() {

    //Add Clock to the Div
    $("#card-body").prepend("<center> <div id='clock'></div> </center>");

    document.getElementById("clock").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;





  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}







/*
Incase- When Room Owner while creating room and waiting for the timer to start room quits while room was preapring,
the room is left in-completed, when someone other wants to creaete the room, 
2 times will they have problem (they will connect to room but it would never start becasue the owner who starts it is gone)
To solve this problem, every user will start room after 15 seconds, if it is already started then below code won't do any effect
if not started then it will start the room.
*/
setInterval(() => {
    
    $( "#Start_RR" ).prop('disabled', false);
    //$( "#Start_RR" ).css('display', 'inline-block');
    $( "#Start_RR" ).click();
    
}, 15000);


</script>
@endsection
