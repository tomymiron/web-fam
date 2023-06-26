<?php
include('../private/database/db.php');
?>
<?php
function getTime($time){
	$minutes = floor($time / 60);
    $seconds = sprintf("%02d", $time - ($minutes * 60));
    $miliSeconds = ($time - ($minutes * 60) - $seconds);
    $auxiliar = $seconds + $miliSeconds;
    $auxiliar = round($auxiliar, 2);
    if($auxiliar < 10){$auxiliar = '0' . $auxiliar;}
    if($minutes > 0){return "$minutes.$auxiliar";}
    else{return $auxiliar;}
}

$sql = "select * from startedcompetitions order by startedcompetitions.date DESC limit 1;";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ 
    $mainCompetition =  $row['ID_competition']; 
    setcookie('mainCompetitionResults', $mainCompetition, time() + 10000);
} ?>

<?php include('../public/pages/header.html'); ?>
<title>Athleta</title>
<style><?php include('../public/resources/css/homeResults.css')?></style>
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
            <h1>Resultados</h1>
            <div id="mainContent" class="row container-fluid">
                <div id="leftSide" class="col-12 col-lg-4">
                    <div id="box1" class="box">
                        <h2>Ver resultados</h2>
                        <form id="viewForm" spellcheck="false">
                            <select id="selectInscription">
                                <?php $sql = "SELECT * FROM `startedcompetitions` ORDER BY `startedcompetitions`.`date` DESC limit 15";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()){ ?>
                                <option name="selection" value="<?php echo($row['ID_competition'])?>"><?php echo($row['name'])?></option>
                                <?php } ?>
                            </select>
                            <button type="button" onclick="selectCompetition()">Aceptar</button>
                        </form>  
                    </div>
                </div>
                <div id="rightSide" class="col-12 col-lg-8">                    
                    <div id="box3" class="box">
                        <h2>Resultados de busqueda</h2>
                        <div id="box3MainContent">
                            <div id="results">
                            <?php
                                if(isset($_COOKIE['mainCompetitionResults'])){
                                    $sql = "select events.ID_event, events.gender, date_format(time,'%H:%i') as `startTime`, disciplines.name, disciplines.campus, disciplines.maxHeat, disciplines.minHeat, disciplines.category, count(competitionlog.ID_competitionLog) as 'amount' from events left join disciplines on disciplines.ID_discipline = events.ID_discipline left join competitionlog on competitionlog.ID_event = events.ID_event where ID_competition = " . $_COOKIE['mainCompetitionResults'] . " group by events.ID_event order by events.time ASC;";
                                }else{
                                    $sql = "select events.ID_event, events.gender, date_format(time,'%H:%i') as `startTime`, disciplines.name, disciplines.campus, disciplines.maxHeat, disciplines.minHeat, disciplines.category, count(competitionlog.ID_competitionLog) as 'amount' from events left join disciplines on disciplines.ID_discipline = events.ID_discipline left join competitionlog on competitionlog.ID_event = events.ID_event where ID_competition = " . $mainCompetition . " group by events.ID_event order by events.time ASC;";
                                }
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()){?>
                                    <div class="resultItem">
                                        <div class="resultItemMain" data-bs-toggle="collapse" data-bs-target="#result<?php echo($row['ID_event']);?>">
                                            <div class='resultItemMain1'>
                                                <h4><?php if($row['gender'] == 0){echo "Femenino";}else{echo "Masculino";} ?> | <?php echo($row['name']); ?> | <?php echo($row['startTime'])?>hs</h4>
                                                <h6>
                                                    <?php 
                                                    $getCategoriesQuery = "select categories.* from eventscategories left join categories on categories.ID_category = eventscategories.iD_category where eventscategories.ID_event = " . $row['ID_event'];
                                                    $getCategoryResult = $conn->query($getCategoriesQuery);
                                                    while($category = $getCategoryResult->fetch_assoc()){
                                                        echo ($category['name'] . " ");
                                                    }
                                                    ?>
                                                </h6>
                                            </div>
                                            <p><?php echo($row['amount'])?></p>
                                        </div>
                                        <div class="resultItemOpen collapse" id="result<?php echo($row['ID_event']);?>">
                                            <div class="auxiliar">
                                                <?php
                                                if($row['amount'] > 0){ ?>
                                                <?php 
                                                    $queryGetResults = "select athletes.ID_athlete, athletes.name, year(athletes.born) as 'year', clubs.resumed as 'club', countrys.resumed as 'country', federation.resumed as 'federation', competitionlog.result from competitionlog 
                                                    left join events on events.ID_event = competitionlog.ID_event 
                                                    left join disciplines on events.ID_discipline = disciplines.ID_discipline 
                                                    left join competitions on competitions.ID_competition = events.ID_competition 
                                                    left join athletes on athletes.ID_athlete = competitionlog.ID_athlete 
                                                    left join clubs on clubs.ID_club = athletes.ID_club
                                                    left join countrys on countrys.ID_country = athletes.ID_country
                                                    left join federation on federation.ID_federation = athletes.ID_federation
                                                    where events.ID_event = " . $row['ID_event'] . " and ISNULL(wind) order by result DESC;";
                                                    $resultGetResults =  $conn->query($queryGetResults);
                                                    if(mysqli_num_rows($resultGetResults) > 0){
                                                        $wind = false;
                                                    }else{
                                                        $wind = true;
                                                        $queryGetResults = "select athletes.ID_athlete, athletes.name, year(athletes.born) as 'year', competitionLog.wind, clubs.resumed as 'club', countrys.resumed as 'country', federation.resumed as 'federation', competitionlog.result from competitionlog 
                                                        left join events on events.ID_event = competitionlog.ID_event 
                                                        left join disciplines on events.ID_discipline = disciplines.ID_discipline 
                                                        left join competitions on competitions.ID_competition = events.ID_competition 
                                                        left join athletes on athletes.ID_athlete = competitionlog.ID_athlete 
                                                        left join clubs on clubs.ID_club = athletes.ID_club
                                                        left join countrys on countrys.ID_country = athletes.ID_country
                                                        left join federation on federation.ID_federation = athletes.ID_federation
                                                        where events.ID_event = " . $row['ID_event'] . " and !ISNULL(wind) order by result DESC;";
                                                        $resultGetResults =  $conn->query($queryGetResults);
                                                    } ?>
                                                    <div class='listResults'>
                                                    <table>
                                                        <tr>
                                                            <th class='listNumber'>
                                                                <div class='svgThContainer'>
                                                                    <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12.1608 4.77686C10.5408 4.77686 9.22754 6.09013 9.22754 7.71012V15.5322C9.22754 20.6529 13.3787 24.804 18.4994 24.804C23.6201 24.804 27.7712 20.6529 27.7712 15.5322V7.71012C27.7712 6.09013 26.4578 4.77686 24.8379 4.77686H12.1608Z" stroke="#2BCCA2" stroke-width="2"/>
                                                                        <path d="M18.499 25.9165V27.4" stroke="#2BCCA2" stroke-width="2" stroke-linecap="round"/>
                                                                        <path d="M22.9496 28.5127H14.0487C13.0246 28.5127 12.1943 29.3429 12.1943 30.3671C12.1943 31.3912 13.0246 32.2214 14.0487 32.2214H22.9496C23.9738 32.2214 24.804 31.3912 24.804 30.3671C24.804 29.3429 23.9738 28.5127 22.9496 28.5127Z" stroke="#2BCCA2" stroke-width="2"/>
                                                                        <path d="M8.85668 8.11475C6.80841 8.11475 5.14795 9.7752 5.14795 11.8235V12.3107C5.14795 13.4235 5.59001 14.4908 6.37692 15.2777L9.59842 18.4992" stroke="#2BCCA2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M28.1416 8.11475C30.1899 8.11475 31.8504 9.7752 31.8504 11.8235V12.3107C31.8504 13.4235 31.4083 14.4908 30.6215 15.2777L27.3999 18.4992" stroke="#2BCCA2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                </div>
                                                            </th>
                                                            <th class='resultName'>Nombre</th>
                                                            <th class='resultYear'>Año</th>
                                                            <th class='resultClub'>Club</th>
                                                            <th class='d-none d-xl-table-cell resultFed'>Fed.</th>
                                                            <?php if($wind){echo "<th class='resultWind'>Viento</th>";}?>
                                                            <th class='resultResult'>Marca</th>
                                                        </tr>
                                                    <?php
                                                    $resultsToEcho = array();
                                                    $resultPos = 0;
                                                    if($row['campus'] == 0){
                                                        $campus = "s";
                                                    }else{
                                                        $campus = "m";
                                                    }
                                                    while($getResultsRow = $resultGetResults->fetch_assoc()){
                                                        
                                                        if($getResultsRow['result'] == 0.0125){
                                                            $auxResult = "DNS"; // do not start
                                                        }elseif($getResultsRow['result'] == 0.00125){
                                                            $auxResult = "DNF"; // do not finish
                                                        }elseif($getResultsRow['result'] == 0.000125){
                                                            $auxResult = "DQ"; // desqualified
                                                        }else{
                                                            $auxResult = getTime($getResultsRow['result']) . $campus;
                                                            $resultPos++;
                                                        }

                                                        if($auxResult == "DNS" || $auxResult == "DNF" || $auxResult == "DQ"){
                                                            if($wind){
                                                                $auxWind = "<td class='resultWind'>-</td>";
                                                            }else{
                                                                $auxWind = "";
                                                            }
                                                            array_push($resultsToEcho,  "<tr>
                                                                        <td class='listNumber'>-</td>
                                                                        <td class='resultName'>".$getResultsRow['name']."</td>
                                                                        <td class='resultYear'>".$getResultsRow['year']."</td>
                                                                        <td class='resultClub'>".$getResultsRow['club']."</td>
                                                                        <td class='d-none d-xl-table-cell resultFed'>".$getResultsRow['federation']."</td>$auxWind
                                                                        <td class='resultResult'>" . $auxResult . "</td>
                                                                    </tr>");
                                                        }else{
                                                            if($wind){
                                                                $auxWind = "<td class='resultWind'>".$getResultsRow['wind']."</td>";
                                                            }else{
                                                                $auxWind = "";
                                                            }
                                                            array_unshift($resultsToEcho, "</td>
                                                                        <td class='resultName'>".$getResultsRow['name']."</td>
                                                                        <td class='resultYear'>".$getResultsRow['year']."</td>
                                                                        <td class='resultClub'>".$getResultsRow['club']."</td>
                                                                        <td class='d-none d-xl-table-cell resultFed'>".$getResultsRow['federation']."</td>$auxWind
                                                                        <td class='resultResult'>" . $auxResult . "</td>
                                                                    </tr>");
                                                        }
                                                    }
                                                    for($i = 0; $i < count($resultsToEcho); $i++){
                                                        if($i < $resultPos){
                                                            echo "<tr><td class='listNumber'>" . $i + 1;
                                                            echo $resultsToEcho[$i];
                                                        }else{
                                                            echo $resultsToEcho[$i];
                                                        }
                                                        
                                                    }
                                                ?>
                                                    
                                                    </table>
                                                </div>

                                                <?php
                                                }else{
                                                    echo("<p class='inscriptionIndicator'>Aun no hay resultados</p>");
                                                }?>
                                            </div>
                                        </div>
                                    </div>

                                <?php }?>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script><?php include('../public/resources/js/homeResults.js');?></script>
<?php include('../public/pages/footer.html'); ?>