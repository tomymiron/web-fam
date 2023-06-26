<?php
include('../private/database/db.php');

function getTime($time){
	$minutes = floor($time / 60);
    $seconds = sprintf("%02d", $time - ($minutes * 60));
    $miliSeconds = ($time - ($minutes * 60) - $seconds);
    $auxiliar = $seconds + $miliSeconds;
    $auxiliar = round($auxiliar, 2);
    if($minutes > 0){return "$minutes.$auxiliar";}
    else{return $auxiliar;}
}
?>
<?php include('../public/pages/header.html'); ?>
<title>Athleta</title>
<style><?php include('../public/resources/css/homeRanking.css')?></style>
</head>
<body>
<nav>
    <button id="backButtonContainer" onclick="window.history.back()">
        <svg width="41" height="41" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.4166 19.5835L19.5833 27.4168" stroke="#C6C4CC" stroke-width="2.9375" stroke-linecap="round"/>
            <path d="M27.4166 27.4168L19.5833 19.5835" stroke="#C6C4CC" stroke-width="2.9375" stroke-linecap="round"/>
            <path d="M41.6147 23.4998C41.6147 13.4954 33.5045 5.38525 23.5001 5.38525C13.4957 5.38525 5.3855 13.4954 5.3855 23.4998C5.3855 33.5042 13.4957 41.6144 23.5001 41.6144C33.5045 41.6144 41.6147 33.5042 41.6147 23.4998Z" stroke="#C6C4CC" stroke-width="2.9375"/>
        </svg>
    </button>
</nav>
<main>
    <section class="row">
        <div id="mainContentContainer" class='col-12 col-md-11 col-lg-10'>
            <h1>Rankings</h1>
            <div id="mainContent" class="row container-fluid">
                <div id="leftSide" class="col-12 col-lg-4">
                    <div id="box2" class="box">
                        <h2>Todos los rankings</h2>
                        <form id="viewForm" spellcheck="false">
                            <select id="viewFormYear">
                                <?php
                                for($i = date('Y'); $i >= 2015; $i--){
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                                <option value="0">General</option>
                            </select>
                            <select id="viewFormGender">
                                <option selected value="null">Genero</option>
                                <option value="1">Masculino</option>
                                <option value="0">Femenino</option>
                            </select>
                            <select id="viewFormCategory">
                                <option selected value="null">Categoria</option>
                                <option value="1">U12</option>
                                <option value="2">U14</option>
                                <option value="3">U16</option>
                                <option value="4">U18</option>
                                <option value="5">U20</option>
                                <option value="6">U23</option>
                                <option value="7">Mayores</option>
                                <option value="0">General</option>
                            </select>
                            <div id="viewFormDiscipline">
                                <p>Prueba</p>
                                <div id="viewFormDisciplineContainer">
                                    <?php
                                    mysqli_next_result($conn);
                                    $viewFormDisciplinesQuery = "select * from disciplinesType";
                                    $viewFormDisciplinesResult = $conn->query($viewFormDisciplinesQuery);
                                    while($viewFormDisciplinesRow = $viewFormDisciplinesResult->fetch_assoc()){ ?>
                                        <div class="eventSelector">
                                        <div class="eventSelectorMain" data-bs-toggle="collapse" data-bs-target="#eventSelector<?php echo($viewFormDisciplinesRow['ID_disciplineType']);?>">
                                            <p><?php echo($viewFormDisciplinesRow['name']);?></p>
                                        </div>
                                        <div class="eventSelectorOpen collapse" id="eventSelector<?php echo($viewFormDisciplinesRow['ID_disciplineType']);?>">
                                            <div class="auxiliar">
                                            <?php
                                                mysqli_next_result($conn);
                                                $viewFormDisciplinesInnerQuery = "select * from disciplines where disciplines.ID_disciplineType = " . $viewFormDisciplinesRow['ID_disciplineType'] . ";";
                                                $viewFormDisciplinesInnerResult = $conn->query($viewFormDisciplinesInnerQuery);
                                                while($viewFormDisciplinesInnerRow = $viewFormDisciplinesInnerResult->fetch_assoc()){ ?>
                                                    <input type="radio" name="discipline" id="<?php echo($viewFormDisciplinesInnerRow['ID_discipline']);?>" value="<?php echo($viewFormDisciplinesInnerRow['ID_discipline']);?>"/>
                                                    <label class="eventsRadioItems" for="<?php echo($viewFormDisciplinesInnerRow['ID_discipline']);?>"><span><?php echo($viewFormDisciplinesInnerRow['name']);?></span></label>
                                                <?php } ?>
                                            </div>    
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button type="button" id="viewFormSubmit" onclick="getRanking()" name="post">Aceptar</button>
                        </form>
                    </div>
                </div>
                <div id="rightSide" class="col-12 col-lg-8">                    
                    <div id="box3" class="box">
                        <h2>Resultados de busqueda</h2>
                        <form id="rankingResultsContainer" method="GET" action="../athletesProfile/default.php">
                            
                        </form>  
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script><?php include('../public/resources/js/homeRanking.js');?></script>
<?php include('../public/pages/footer.html'); ?>