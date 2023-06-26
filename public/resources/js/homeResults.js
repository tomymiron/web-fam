addEventListener("load",()=>{
    $('#box3MainContent').load(document.URL +  ' #results');
});


function selectCompetition(){
    var selection = $("#selectInscription").val();
    document.cookie = "mainCompetitionResults=" + selection[0];
    $('#box3MainContent').load(document.URL +  ' #results');
}