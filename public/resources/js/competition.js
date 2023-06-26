const menuIcon = document.getElementById("menuIcon");                                    
const closeArrow = document.getElementById("closeArrow");
const menu = document.getElementById("menu");
const alertBox = document.getElementById("alert");
menuIcon.addEventListener("click", ()=>{
    menu.classList.add("active");
});
closeArrow.addEventListener("click", ()=>{
    menu.classList.remove("active");
})

$(document).ready(function() {
    $("#submit").on("click", function(e) {
        e.preventDefault();
        var name = $("#name").val();
        var date = $("#date").val();
        var place = $("#place").val();
        $.ajax({
            url: "../modules/createCompetition.php",
            type: "POST",
            data: {
                name: name,
                date: date,
                place: place
            },
            success: function($data){
                setTimeout(async(a) => {
                    await $('#pendingComp').load(document.URL +  ' #pendingComp');
                    
                }, 200);
                alertBox.style.opacity = "1";
                $("#alert").html($data);
                $("#createForm").trigger("reset");
                setTimeout(()=>{
                    alertBox.style.opacity = "0";
                }, 2000);
            }
        });
    });
});

function newEvent(competition){
    var discipline;
    var ele = document.getElementsByName('eventDiscipline' + competition);
    for(i = 0; i < ele.length; i++) {
        if(ele[i].checked)
            discipline = ele[i].value;
    }
    var categories = [];
    var ele2 = document.getElementsByName('eventCategory' + competition);
    for(i = 0; i < ele2.length; i++) {
        if(ele2[i].checked)
            categories.push(ele2[i].value);
    }
    var competition = $('#eventForm' + competition + ' .eventCompetition').val();
    var time = $('#eventForm' + competition + ' .eventTime').val();
    var gender = $('#eventForm' + competition + ' .eventGender').val();
    
    $.ajax({
        url: "../modules/createEvent.php",
        type: "POST",
        data: {
            competition: competition,
            time: time,
            discipline: discipline,
            gender: gender,
            categories: JSON.stringify(categories)
        },
        success: function($data){
            $('#compEvents' + competition).load(document.URL +  ' #compEvents' + competition);
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function refreshEvents(event, competition){
    $.ajax({
        url: "../modules/deleteEvent.php",
        type: "POST",
        data: {
            event: event
        },
        success: function($data){
            $('#compEvents' + competition).load(document.URL +  ' #compEvents' + competition);
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function deleteCompetition(competition){
    $.ajax({
    url: "../modules/deleteCompetition.php",
    type: "POST",
    data: {
        competition: competition
    },
    success: function($data){
        $('#pendingComp').load(document.URL +  ' #pendingComp');
        alertBox.style.opacity = "1";
        $("#alert").html($data);
        setTimeout(()=>{
            alertBox.style.opacity = "0";
        }, 2000);
    }
    });
}

function changePlace(competition){
    var place = $('#modalPlaceValue' + competition).val();
    $.ajax({
        url: "../modules/changePlace.php",
        type: "POST",
        data: {
            competition: competition,
            place: place
        },
        success: function($data){
            $('#pendingItemMain' + competition).load(document.URL +  ' #pendingItemMainAuxiliar' + competition);
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
        });
}

function changeDate(competition){
    var date = $('#modalDateValue' + competition).val();
    console.log(date, competition)
    $.ajax({
        url: "../modules/changeDate.php",
        type: "POST",
        data: {
            competition: competition,
            date: date
        },
        success: function($data){
            $('#pendingItemMain' + competition).load(document.URL +  ' #pendingItemMainAuxiliar' + competition);
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
        });
}

function changeName(competition){
    var name = $('#modalNameValue' + competition).val();
    $.ajax({
        url: "../modules/changeName.php",
        type: "POST",
        data: {
            competition: competition,
            name: name
        },
        success: function($data){
            $('#pendingItemMain' + competition).load(document.URL +  ' #pendingItemMainAuxiliar' + competition);
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function publishCompetition(competition){
    $.ajax({
        url: "../modules/publishCompetition.php",
        type: "POST",
        data: {
            competition: competition,
        },
        success: function($data){
            $('#pendingComp').load(document.URL +  ' #pendingComp');
            $('#publishedComp').load(document.URL +  ' #publishedCompAuxiliar');
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

const dateForm = document.getElementById("date");
dateForm.addEventListener("change", ()=>{
    dateForm.placeholder = "";
})