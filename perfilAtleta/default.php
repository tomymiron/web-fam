<?php
include('../private/database/db.php');
include('../private/modules/getSetTime.php');

if(!isset($_GET["user"])){
	header('location: ../');
}

$sql = "select athletes.ID_athlete, athletes.born, categories.name as 'category', athletes.name, clubs.name as 'club' from  athletes left join clubs on clubs.ID_club = athletes.ID_club left join categories on 2023 - year(athletes.born) >= categories.minAge and 2023 - year(athletes.born) < categories.limitAge  where athletes.ID_athlete = '" . $_GET["user"] . "';";
$query = mysqli_query($conn,$sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_array($query)){
        $user = $row;
    }
}else{
    header('location: ../');
}
include('../public/pages/header.html');
?>

<title>Athleta</title>
<style><?php include('../public/resources/css/athletesProfile.css')?></style>
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
    <section class="container-xxl">
        <p id="alert"></p>
        <div class="row container-fluid">
            <h1>Atleta</h1>
            <div id="leftSide" class="col-12 col-lg-5 col-xl-4">
                <div id="box1" class="box">
                    <?php
                    $sql = "select image from images where ID_athlete = " . $user['ID_athlete'];
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo '<img class="profileImg" src="data:image/png;base64,'.base64_encode($row['image']).'" />';
                        }
                    }else{
                        echo "<img class='profileImg' src='../public/img/user.png'>";
                    }
                    ?>
                    <div>
                        <h3><?php echo($user['name']);?></h3>
                        <p><?php echo($user['club']);?></p>
                        <p><?php echo($user['born']);?></p>
                    </div>
                </div>
                <div id="box2" class="box">
                    <h2>Ultimas participaciones</h2>
                    <div id="leContainer">
                        <?php
                        $sql = "select competitionlog.ID_competitionlog, disciplines.campus, disciplines.name as 'discipline', competitions.name as 'competition', competitions.date, competitionlog.result from competitionlog left join events on events.ID_event = competitionlog.ID_event left join competitions on competitions.ID_competition = events.ID_competition left join disciplines on disciplines.ID_discipline = events.ID_discipline where competitionlog.ID_athlete = " . $user['ID_athlete'] . " order by competitions.date DESC, events.time DESC limit 4;";
                        $result = $conn->query($sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = $result->fetch_assoc()){
                                if($row['campus'] == 0){
                                    $campus = "s";
                                }else{
                                    $campus = "m";
                                }
                                if($row['result'] == 0.0125){
                                    $auxResult = "DNS"; // do not start
                                }elseif($row['result'] == 0.00125){
                                    $auxResult = "DNF"; // do not finish
                                }elseif($row['result'] == 0.000125){
                                    $auxResult = "DQ"; // desqualified
                                }else{
                                    $auxResult = getTime($row['result']) . $campus;
                                }
                            ?>
                                <div class="le" data-bs-toggle="collapse" data-bs-target="#lastEvent<?php echo($row['ID_competitionlog']);?>">
                                    <div class="leMain">
                                        <p class="leMainItem"><?php echo($row['discipline']);?></p>
                                        <p><?php echo($auxResult);?></p>
                                    </div>
                                    <div class="leOpen collapse" id="lastEvent<?php echo($row['ID_competitionlog']);?>">
                                        <div class="auxiliar">
                                            <p><?php echo($row['competition']);?></p>
                                            <p><?php echo($row['date']);?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }else{
                            echo('<p class="query0">Aun no hay participaciones.</p>');
                        }
                        ?>
                    </div>
                </div>
                <div id="box5" class="box">
                    <h2>Records de temporada</h2>
                    <div id="seasonBestContainer" class="row">
                        <?php
                        $sql = "select disciplines.ID_discipline from competitionlog left join events on events.ID_event = competitionlog.ID_event left join disciplines on disciplines.ID_discipline = events.ID_discipline left join competitions on competitions.ID_competition = events.ID_competition where competitionlog.ID_athlete = '" . $user['ID_athlete'] . "' and year(competitions.date) = year(curdate()) and (competitionlog.result <> 0.0125 and competitionlog.result <> 0.00125 and competitionlog.result <> 0.000125) group by disciplines.ID_discipline;";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                $query = "select competitionlog.ID_athlete, competitionlog.result, disciplines.campus, disciplines.name as 'discipline', competitions.date, places.name as 'place' from competitionlog left join events on events.ID_event = competitionlog.id_event left join disciplines on disciplines.ID_discipline = events.ID_discipline left join competitions on competitions.ID_competition = events.ID_competition left join places on places.ID_place = competitions.id_place where disciplines.ID_discipline = '" . $row['ID_discipline'] . "' and competitionlog.ID_athlete = '" . $user['ID_athlete'] . "' and year(competitions.date) = year(curdate()) order by competitionlog.result ASC limit 1";
                                $resultItem = mysqli_query($conn,$query);
                                while($rowItem = mysqli_fetch_array($resultItem)){ 
                                    if($rowItem['campus'] == 0){
                                        $campus = "s";
                                    }else{
                                        $campus = "m";
                                    }
                                    $auxResult = getTime($rowItem['result']) . $campus;
                                    ?>
                                    <div class="seasonBestItem col-6">
                                        <div class="seasonBestItemInner">
                                                <div class="seasonBestItem1">
                                                    <h3><?php echo($rowItem['discipline']);?></h3>
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1169 3.66277C11.4929 2.95486 12.5073 2.95486 12.8833 3.66277L14.8393 7.34562C14.9838 7.61777 15.2458 7.80807 15.5493 7.86144L19.6563 8.58368C20.4458 8.7225 20.7592 9.68721 20.2021 10.2635L17.304 13.2619C17.0898 13.4834 16.9898 13.7914 17.0328 14.0965L17.6151 18.2257C17.727 19.0194 16.9063 19.6156 16.1861 19.2639L12.4389 17.4342C12.162 17.2989 11.8382 17.2989 11.5613 17.4342L7.81412 19.2639C7.09384 19.6156 6.27321 19.0194 6.38513 18.2257L6.96739 14.0965C7.01042 13.7914 6.91037 13.4834 6.69621 13.2619L3.79806 10.2635C3.24098 9.68721 3.55444 8.7225 4.34389 8.58368L8.45093 7.86144C8.75442 7.80807 9.01636 7.61776 9.1609 7.34562L11.1169 3.66277Z" stroke="#36B9CC" stroke-width="1.5"/>
                                                    </svg>
                                                </div>
                                                <div class="seasonBestItem2">
                                                    <h4><?php echo($auxResult);?></h4>
                                                </div>
                                                <div class="seasonBestItem3">
                                                    <p><?php echo($rowItem['date']);?></p>
                                                    <p><?php echo($rowItem['place']);?></p>
                                                </div>
                                        </div>
                                    </div>
                                <?php }
                            }
                        }else{
                            echo('<p class="query0">No hay marcas registradas esta temporada.</p>');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="rightSide" class="col-12 col-lg-7 col-xl-8">
                <div id="box4" class="box">
                    <h2>Rankings <?php echo($user['category'] . ' - ' . date("Y"));?></h2>
                    <div id="rankingItemsAuxiliar">
                            <?php
                                $getDisciplinesQuery =   "select disciplines.ID_discipline from competitionlog
                                                            left join events on events.ID_event = competitionlog.ID_event
                                                            left join disciplines on disciplines.ID_discipline = events.ID_discipline
                                                            where competitionlog.ID_athlete = " . $user['ID_athlete'] . " and (competitionlog.result <> 0.0125 and competitionlog.result <> 0.00125 and competitionlog.result <> 0.000125) group by disciplines.name";
                                $getDisciplinesResult = $conn->query($getDisciplinesQuery);
                                if ($getDisciplinesResult->num_rows > 0) {
                                    while($getDisciplinesRow = $getDisciplinesResult->fetch_assoc()){
                                        mysqli_next_result($conn);
                                        $getRankingQuery = "call getDeterminatedRanking(" . $user['ID_athlete'] . ", " . $getDisciplinesRow['ID_discipline'] . ")";
                                        $getRankingResult = $conn->query($getRankingQuery);
                                        while($getRankingRow = $getRankingResult->fetch_assoc()){ ?>
                                            <div class="rankItem">
                                                <div class="rankItem1">
                                                    <div>
                                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.3029 3.66666C8.84685 3.66666 7.6665 4.847 7.6665 6.30302V13.3333C7.6665 17.9357 11.3975 21.6667 15.9998 21.6667C20.6022 21.6667 24.3332 17.9357 24.3332 13.3333V6.30302C24.3332 4.847 23.1528 3.66666 21.6968 3.66666H10.3029Z" stroke="#36B9CC" stroke-width="1.5"/>
                                                            <path d="M16 22.6667V24" stroke="#36B9CC" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M20.0002 25H12.0002C11.0797 25 10.3335 25.7462 10.3335 26.6667C10.3335 27.5871 11.0797 28.3333 12.0002 28.3333H20.0002C20.9206 28.3333 21.6668 27.5871 21.6668 26.6667C21.6668 25.7462 20.9206 25 20.0002 25Z" stroke="#36B9CC" stroke-width="1.5"/>
                                                            <path d="M7.33333 6.66666C5.49239 6.66666 4 8.15904 4 9.99999V10.4379C4 11.4381 4.39732 12.3973 5.10457 13.1046L8 16" stroke="#36B9CC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M24.6667 6.66666C26.5076 6.66666 28 8.15904 28 9.99999V10.4379C28 11.4381 27.6027 12.3973 26.8955 13.1046L24 16" stroke="#36B9CC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <p><?php echo($getRankingRow['rank']);?></p>
                                                </div>
                                                <p><?php echo($getRankingRow['discipline']);?></p>
                                            </div>
                                        <?php }
                                    }
                                }else{
                                    echo('<p class="query0">No posees rankings.</p>');
                                }
                            ?>
                        </div>
                </div>
                <div id="box6" class="box">
                    <h2>Records personales</h2>
                    <div id="personalBestContainer" class="row">
                        <?php
                        mysqli_next_result($conn);
                        $sql = "select disciplines.ID_discipline from competitionlog left join events on events.ID_event = competitionlog.ID_event left join disciplines on disciplines.ID_discipline = events.ID_discipline where competitionlog.ID_athlete = '" . $user['ID_athlete'] . "' and (competitionlog.result <> 0.0125 and competitionlog.result <> 0.00125 and competitionlog.result <> 0.000125) group by disciplines.ID_discipline;";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                $query = "select competitionlog.ID_athlete, disciplines.campus, competitionlog.result, disciplines.name as 'discipline', competitions.name, competitions.date, places.name as 'place' from competitionlog left join events on events.ID_event = competitionlog.id_event left join disciplines on disciplines.ID_discipline = events.ID_discipline left join competitions on competitions.ID_competition = events.ID_competition left join places on places.ID_place = competitions.id_place where disciplines.ID_discipline = '" . $row['ID_discipline'] . "' and competitionlog.ID_athlete = '" . $user['ID_athlete'] . "' order by competitionlog.result ASC limit 1;";
                                mysqli_next_result($conn);
                                $resultItem = mysqli_query($conn,$query);
                                while($rowItem = mysqli_fetch_array($resultItem)){
                                    if($rowItem['campus'] == 0){
                                        $campus = "s";
                                    }else{
                                        $campus = "m";
                                    }
                                    $auxResult = getTime($rowItem['result']) . $campus;?>
                                    <div class="personalBestItem col-6 col-lg-4 col-xxl-3">
                                        <div class="personalBestItemInner">
                                                <div class="personalBestItem1">
                                                    <h3><?php echo($rowItem['discipline']);?></h3>
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1169 3.66277C11.4929 2.95486 12.5073 2.95486 12.8833 3.66277L14.8393 7.34562C14.9838 7.61777 15.2458 7.80807 15.5493 7.86144L19.6563 8.58368C20.4458 8.7225 20.7592 9.68721 20.2021 10.2635L17.304 13.2619C17.0898 13.4834 16.9898 13.7914 17.0328 14.0965L17.6151 18.2257C17.727 19.0194 16.9063 19.6156 16.1861 19.2639L12.4389 17.4342C12.162 17.2989 11.8382 17.2989 11.5613 17.4342L7.81412 19.2639C7.09384 19.6156 6.27321 19.0194 6.38513 18.2257L6.96739 14.0965C7.01042 13.7914 6.91037 13.4834 6.69621 13.2619L3.79806 10.2635C3.24098 9.68721 3.55444 8.7225 4.34389 8.58368L8.45093 7.86144C8.75442 7.80807 9.01636 7.61776 9.1609 7.34562L11.1169 3.66277Z" stroke="#36B9CC" stroke-width="1.5"/>
                                                    </svg>
                                                </div>
                                                <div class="personalBestItem2">
                                                    <h4><?php echo($auxResult);?></h4>
                                                </div>
                                                <div class="personalBestItem3">
                                                    <p><?php echo($rowItem['date']);?></p>
                                                    <p><?php echo($rowItem['place']);?></p>
                                                </div>
                                        </div>
                                    </div>
                                <?php }
                         }
                        }else{
                            echo('<p class="query0">No hay marcas registradas.</p>');
                        }
                        ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script> <?php include('../public/resources/js/athletesProfile.js'); ?> </script>
<?php include('../public/pages/footer.html'); ?>