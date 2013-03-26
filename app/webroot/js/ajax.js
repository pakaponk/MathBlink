/**
 * Created with JetBrains PhpStorm.
 * User: Apple
 * Date: 3/20/13 AD
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */

var problemCount = 0 ;
var problemId = new Array();
var problemStatus = new Array();

function getProblemIndex(id){
    for(var i =0 ;i<problemCount;i++){
        if(problemId[i] == id) return i ;
    }
    return -1;
}

function save_problemset(pid){
    var idArr = $('#problemset_problem_id').html() ;
    var id ='';
    var status = '';
    //alert(idArr);
    idArr = idArr.split(",");
    //var len = idArr.length - 2 ;
    for(var i=0;i< problemCount;i++){
        //alert(idArr[i]+' '+$('#status'+idArr[i]).html() );
        /*id += idArr[i];
        status += $('#status'+idArr[i]).html();*/
        id +=problemId[i];
        status +=problemStatus[i];
        if(i != problemCount){
            id +=';';
            status +=';';
        }
    }
    var callUrl = '/mathblink/teacher/save_problemset/'+pid+'/'+id +'/'+ status ;
    //alert(callUrl);

    //alert(problemId.join('\n'));
    //alert(problemStatus.join('\n'));
    $.ajax({
        url: callUrl,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#finish_create_problemset').show();
            //$('#debug_save').html(data);
            /*$('#TopicDiv').html(data);
            $('html, body').animate({
                scrollTop: $("#TopicDiv").offset().top - 33
            },1000);*/
        }
    });
}

function problemsetGetTopic(urlStr,id){
    var lesson_id = $('#'+id).val();
    //alert(lesson_id);
    if( lesson_id.length == 0 ){
        //alert("now");
        $('#ProblemDiv').empty();
    }
    $.ajax({
        url: urlStr+'/'+lesson_id ,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#TopicDiv').html(data);
            $('html, body').animate({
                scrollTop: $("#TopicDiv").offset().top - 50
            },1000);
        }
    });
}


function problemsetGetProblem(urlStr,id){
    var topic = $('#'+id).val();
    $.ajax({
        url: urlStr+'/'+topic ,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#ProblemDiv').html(data);
            $('html, body').animate({
                scrollTop: $("#problem_header").offset().top - 33
            },1000);
           //alert(data);
        }
    });
}

function addProblem(latex,id){
    var str = '<div style="font-size: 13px;margin-bottom: -5px;border-bottom: 1px solid #b3b3b3" id="'+id+'">';
    str += '<span style="width:50px">'+latex+'</span><a href="javascript:removeProblem(\''+latex+'\','+id+')" class="btn btn-mini">remove</a></div>';
    $('#problemset_queue').append(str);
    $('#problemset_problem_id').append(id+',');


    if( $('#status'+id).is("div,ul,blockquote") ){
        //alert("hey");
        var index = getProblemIndex(id);
        problemStatus[index] ="add";
        $('#status'+id).html("add");
    }else{
        problemId[problemCount] = id;
        problemStatus[problemCount++] = "add" ;
        var str2 = '<div id="status'+id+'">add</div>';
        $('#problemset_problem_status').append(str2);
    }
    $('#button'+id).html('<a class="btn" href="javascript:removeProblem(\''+latex+'\','+id+')">Remove</a>');
    MathJax.Hub.Typeset();
    // alert("heyy");
}

function changeStatus(latex,id){
    $('#button'+id).html('<a class="btn" href="javascript:removeProblem(\''+latex+'\','+id+')">Remove</a>');
    MathJax.Hub.Typeset();
}

function removeProblem(latex,id){
    var index = getProblemIndex(id);
    problemStatus[index] = "remove";
    $('#button'+id).html('<a class="btn" href="javascript:addProblem(\''+latex+'\','+id+')">Add</a>');
    $('#status'+id).html("remove");
    $('#'+id).remove();
}