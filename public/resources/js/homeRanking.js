function getRanking(){
    var viewFormYear = $('#viewFormYear').val();
    var viewFormGender = $('#viewFormGender').val();
    var viewFormCategory = $('#viewFormCategory').val();

    var viewFormDiscipline;
    var ele = document.getElementsByName('discipline');
    for(i = 0; i < ele.length; i++) {
        if(ele[i].checked)
            viewFormDiscipline = ele[i].value;
    }

    console.log(viewFormYear, viewFormGender, viewFormCategory, viewFormDiscipline);

    $.ajax({
        url: "rankingResults.php",
        type: "POST",
        data: {
            viewFormYear: viewFormYear,
            viewFormGender: viewFormGender,
            viewFormCategory: viewFormCategory,
            viewFormDiscipline: viewFormDiscipline
        },
        success: function($data){
            $("#rankingResultsContainer").html($data);
        }
    });
}

window.addEventListener('load',()=>{
    setTimeout(() => {
        var viewFormGender = $('#viewFormGender').val();
        var viewFormCategory = $('#viewFormCategory').val();
        if(viewFormGender != "null" && viewFormCategory != "null"){
            getRanking();
        }
    }, 100);
});