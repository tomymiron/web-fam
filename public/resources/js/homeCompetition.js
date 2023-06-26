addEventListener("load",()=>{
    $('#box3MainContent').load(document.URL +  ' #results');
    $('#boxedContainer').load(document.URL +  ' #boxedAuxiliar');
});

function selectCompetitions(){
    var selection = $("#selectCompetition").val();
    document.cookie = "mainCompetitionSelected=" + selection[0];
    $('#box3MainContent').load(document.URL +  ' #results');
    $('#boxedContainer').load(document.URL +  ' #boxedAuxiliar');
}
