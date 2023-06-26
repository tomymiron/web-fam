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
    $('#boxedContainer').load(document.URL +  ' #boxedContainerAux');
    $('#box3MainContent').load(document.URL +  ' #results');
});


function selectCompetition(){
    var selection = $("#selectInscription").val();
    document.cookie = "mainCompetitionInscriptions=" + selection[0];
    $('#boxedContainer').load(document.URL +  ' #boxedContainerAux');
    $('#box3MainContent').load(document.URL +  ' #results');
}