const menuIcon = document.getElementById("menuIcon");                                    
const closeArrow = document.getElementById("closeArrow");
const menu = document.getElementById("menu");
menuIcon.addEventListener("click", ()=>{
    menu.classList.add("active");
});
closeArrow.addEventListener("click", ()=>{
    menu.classList.remove("active");
})

addEventListener("load",()=>{
    $('#boxedContainer').load(document.URL +  ' #boxedContainerAux');
    $('#box3MainContent').load(document.URL +  ' #results');
});


function selectCompetition(){
    var selection = $("#selectInscription").val();
    document.cookie = "mainCompetitionResults=" + selection[0];
    $('#boxedContainer').load(document.URL +  ' #boxedContainerAux');
    $('#box3MainContent').load(document.URL +  ' #results');
}