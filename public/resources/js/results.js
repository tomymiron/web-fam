const menuIcon = document.getElementById("menuIcon");                                    
const closeArrow = document.getElementById("closeArrow");
const menu = document.getElementById("menu");
const alertBox = document.getElementById("alert");

menuIcon.addEventListener("click", ()=>{
    menu.classList.add("active");
});
closeArrow.addEventListener("click", ()=>{
    menu.classList.remove("active");
});

addEventListener("load",()=>{
    $('#box3MainContent').load(document.URL +  ' #results');
    $('#newResultContainer').load(document.URL +  ' #newResult');
    $('#box4ContentContainer').load(document.URL +  ' #box4Content');
});

function selectCompetition(){
    var selection = document.getElementById('selectInscription').value;
    document.cookie = "mainCompetitionResults=" + selection;
    $('#box3MainContent').load(document.URL +  ' #results');
    $('#newResultContainer').load(document.URL +  ' #newResult');
    $('#box4ContentContainer').load(document.URL +  ' #box4Content');
    return selection;
}



function sendResults(event, heat){

    var athletes = {};
    var ele = document.getElementsByName('result-' + event + '-' + heat);
    for(i = 0; i < ele.length; i++) {
        athletes[ele[i].getAttribute('athlete')] = parseFloat(ele[i].value);
    }
    var wind = null;
    try{
        wind = document.getElementById('wind-' + event + "-" + heat).value;
    }catch{}
    $.ajax({
        url: "../modules/sendResults.php",
        type: "POST",
        data: {
            event: event,
            wind: wind,
            athletes: JSON.stringify(athletes)
        },
        success: function($data){
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function newResult(){

    var newResultDNI = $("#newResultDNI").val();
    var newResultEvent = $("#newResultEvent").val();
    var newResultResult = $("#newResultResult").val();
    var newResultWind = null;
    try{
        newResultWind = document.getElementById('newResultWind').value;
    }catch{}
    $.ajax({
        url: "../modules/newResultAux.php",
        type: "POST",
        data: {
            newResultDNI : newResultDNI,
            newResultEvent: newResultEvent,
            newResultResult: newResultResult,
            newResultWind: newResultWind
        },
        success: function($data){
            $('#box4ContentContainer').load(document.URL +  ' #box4Content');
            alertBox.style.opacity = "1";
            $('#newResult').trigger("reset");
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function deleteAuxiliarResultItem(competitionLog){
    $.ajax({
        url: "../modules/deleteResultAux.php",
        type: "POST",
        data: {
            competitionLog : competitionLog,
        },
        success: function($data){
            $('#box4ContentContainer').load(document.URL +  ' #box4Content');
            alertBox.style.opacity = "1";
            $('#newResult').trigger("reset");
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}