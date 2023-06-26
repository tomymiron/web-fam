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
    $('#box4ContentContainer').load(document.URL +  ' #box4Content');
    $('#box3MainContent').load(document.URL + ' #results');
    $('#newInscriptionContainer').load(document.URL +  ' #newInscription');
});

function selectCompetition(){
    var selection = document.getElementById('selectInscription').value;
    document.cookie = "mainCompetitionInscriptions=" + selection;
    $('#box3MainContent').load(document.URL + ' #results');
    $('#newInscriptionContainer').load(document.URL +  ' #newInscription');
    $('#box4ContentContainer').load(document.URL +  ' #box4Content');
    return selection;
}

function newInscription(){

    var newInscriptionDNI = $("#newInscriptionDNI").val();
    var newInscriptionCompetition = $("#newInscriptionCompetition").val();
    var newInscriptionEvent = $("#newInscriptionEvent").val();
    $.ajax({
        url: "../modules/newInscriptionAux.php",
        type: "POST",
        data: {
            newInscriptionDNI : newInscriptionDNI,
            newInscriptionCompetition: newInscriptionCompetition,
            newInscriptionEvent: newInscriptionEvent
        },
        success: function($data){
            $('#box4ContentContainer').load(document.URL +  ' #box4Content');
            $('#box3MainContent').load(document.URL +  ' #results');
            alertBox.style.opacity = "1";
            $('#newResult').trigger("reset");
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}

function deleteAuxiliarInscriptionItem(inscription){
    $.ajax({
        url: "../modules/deleteInscriptionAux.php",
        type: "POST",
        data: {
            inscription : inscription,
        },
        success: function($data){
            $('#box4ContentContainer').load(document.URL +  ' #box4Content');
            $('#box3MainContent').load(document.URL +  ' #results');
            alertBox.style.opacity = "1";
            $('#newResult').trigger("reset");
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}