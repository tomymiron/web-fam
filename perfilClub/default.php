<?php
include('../private/database/db.php');
include('../private/modules/getSetTime.php');

if(!isset($_GET["user"])){
	header('location: ../');
}

$sql = "select clubs.ID_club, clubs.name as 'club', clubs.resumed, clubs.description, clubs.place, clubs.president, athletes.ID_athlete, athletes.name, athletes.email, images.image, athletes.ID_country, athletes.ID_federation from clubs right join athletes on athletes.ID_club = clubs.id_club and athletes.dni > 100 and athletes.dni <= 5000 left join images on images.ID_athlete = athletes.ID_athlete where clubs.ID_club = '" . $_GET["user"] . "';";
$query = mysqli_query($conn,$sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_array($query)){
        $club = $row;
    }
}else{
    header('location: ../');
}
include('../public/pages/header.html');
?>

<title>Club</title>
<style><?php include('../public/resources/css/clubsProfile.css')?></style>
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
            <h1>Club</h1>
            <div id="leftSide" class="col-12 col-lg-5 col-xl-4">
                <div id="box1" class="box">
                    <?php
                    $sql = "SELECT image FROM images where ID_athlete = " . $club['ID_athlete'];
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo '<img class="profileImg" src="data:image/png;base64,'.base64_encode($row['image']).'" />';
                        }
                    }else{
                        echo "<img class='profileImg' src='../public/img/user.png'>";
                    }
                    ?>
                    <h3><?php echo($club['club']);?></h3>
                    <p><?php echo($club['president']);?></p>   
                    <p><?php echo($club['resumed']);?></p>
                </div>
            </div>
            <div id="rightSide" class="col-12 col-lg-7 col-xl-8">
                <div id="box2" class="box">
                    <?php 
                    $sql = "select count(athletes.ID_athlete) as 'amount' from athletes where athletes.ID_club = " . $club['ID_club'] . " and athletes.dni > 5000;";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){
                        echo('<p>Atletas: <strong>' . $row['amount'] . '</strong></p>');
                    }
                    ?>
                    <?php 
                    $sql = "select count(competitionlog.ID_competitionLog) as 'amount' from competitionlog left join events on events.id_event = competitionlog.ID_event left join competitions on competitions.ID_competition = events.ID_competition left join athletes on athletes.ID_athlete = competitionlog.ID_athlete where month(competitions.date) = month(curdate()) and athletes.id_club = " . $club['ID_club'] . " and (competitionlog.result <> 0.0125 or competitionlog.result <> 0.00125 or competitionlog.result <> 0.000125);";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){
                        echo('<p>Participaciones(mes): <strong>' . $row['amount'] . '</strong></p>');
                    }
                    ?>
                </div>
                <div id="box3" class="box">     
                    <h3>Descripcion</h3>                   
                    <p><?php echo($club['description']);?></p>
                    <h3>Sedes</h3>
                    <p><?php echo($club['place']);?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="container-xxl" id="athletesContainer">
        <div class="row container-fluid">
            <div class="col-12">
                <form method="GET" action="../../perfilAtleta/default.php" id="mainContent" class="box">
                    <?php
                    $sql = "select athletes.ID_athlete, athletes.name, year(athletes.born) as 'born', categories.name as 'category' from athletes left join categories on (year(curdate()) - year(athletes.born)) >= categories.minAge and (year(curdate()) - year(athletes.born)) < categories.limitAge where athletes.ID_club = " . $club['ID_club'] . " and athletes.dni > 5000 order by athletes.name ASC;";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){ ?>
                    <button type='submit' name='user' value='<?php echo($row['ID_athlete']);?>' class='athleteItem'>
                        <p><?php echo($row['name']);?></p>
                        <p><?php echo($row['born']);?></p>
                        <p><?php echo($row['category']);?></p>
                    </button>
                    <?php } ?>
                </form>        
            </div>
        </div>
    </section>
</main>

<script> <?php include('../public/resources/js/athletesProfile.js'); ?> </script>
<?php include('../public/pages/footer.html'); ?>