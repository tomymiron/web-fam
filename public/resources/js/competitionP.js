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

function newInscription(competition){
    var eventsToInscript = [];
    var ele = document.getElementsByName('events' + competition);
    for(i = 0; i < ele.length; i++) {
        if(ele[i].checked)
            eventsToInscript.push(ele[i].value);
    }
    var user = document.getElementById('ID_athlete').value;
    $.ajax({
        url: "../../private/modules/newInscription.php",
        type: "POST",
        data: {
            eventsToInscript: JSON.stringify(eventsToInscript),
            competition: competition,
            athlete: user
        },
        success: function($data){
            $('#lComp' + competition).load(document.URL +  ' #competitionForm' + competition);
            $('#box1Content').load(document.URL +  ' #box1ContentAuxiliar');
            alertBox.style.opacity = "1";
            $("#alert").html($data);
            setTimeout(()=>{
                alertBox.style.opacity = "0";
            }, 2000);
        }
    });
}