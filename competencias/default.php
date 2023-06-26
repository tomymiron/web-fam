<?php
include('../private/database/db.php');
?>

<?php $sql = "select * from competitions where competitions.public = 1 order by competitions.date DESC limit 1;";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ 
    $mainCompetition =  $row['ID_competition']; 
    setcookie('mainCompetitionSelected', $mainCompetition, time() + 10000);
} ?>

<?php include('../public/pages/header.html'); ?>
<title>Athleta</title>
<style><?php include('../public/resources/css/homeCompetition.css')?></style>
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
            <h1>Competencias</h1>
            <div id="mainContent" class="row container-fluid">
                <div id="leftSide" class="col-12 col-lg-4">
                    <div id="box1" class="box">  
                        <h2>Selecciona el torneo</h2>
                        <form id="viewForm" spellcheck="false">
                            <select id="selectCompetition">
                                <?php $sql = "select * from competitions where competitions.public = 1 order by competitions.date DESC limit 15;";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()){ ?>
                                    <option name="selection" value="<?php echo($row['ID_competition'])?>"><?php echo($row['name'])?></option>
                                <?php } ?>
                            </select>
                            <button type="button" onclick="selectCompetitions()">Aceptar</button>
                        </form> 
                    </div>
                    <div id="boxedContainer">
                        <div id="boxedAuxiliar">
                            <?php 
                            if(isset($_COOKIE['mainCompetitionSelected'])){
                                $sql = "select competitions.date, places.name, hour(sec_to_time(unix_timestamp(now()) - unix_timestamp(competitions.date))) as 'timeLeft', count(inscriptions.ID_inscription) as 'inscriptions' from competitions left join events on events.ID_competition = competitions.ID_competition left join inscriptions on inscriptions.id_event = events.ID_event left join places on places.ID_place = competitions.ID_place where competitions.ID_competition = " . $_COOKIE['mainCompetitionSelected'] . ";";
                            }else{
                                $sql = "select competitions.date, places.name, hour(sec_to_time(unix_timestamp(now()) - unix_timestamp(competitions.date))) as 'timeLeft', count(inscriptions.ID_inscription) as 'inscriptions' from competitions left join events on events.ID_competition = competitions.ID_competition left join inscriptions on inscriptions.id_event = events.ID_event left join places on places.ID_place = competitions.ID_place where competitions.ID_competition = " . $mainCompetition . ";";
                            }                   
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()){ ?>
                                <div class="boxed">
                                    <div>
                                        <svg width="50" height="50" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M29.5312 33.2691V44.625C29.5312 45.7117 30.4132 46.5938 31.5 46.5938C32.5867 46.5938 33.4688 45.7117 33.4688 44.625V33.2691C40.131 32.3031 45.2812 26.6123 45.2812 19.6875C45.2812 12.0881 39.0994 5.90625 31.5 5.90625C23.9006 5.90625 17.7188 12.0881 17.7188 19.6875C17.7188 26.6123 22.869 32.3031 29.5312 33.2691ZM31.5 9.84375C36.9285 9.84375 41.3438 14.259 41.3438 19.6875C41.3438 25.116 36.9285 29.5312 31.5 29.5312C26.0715 29.5312 21.6562 25.116 21.6562 19.6875C21.6562 14.259 26.0715 9.84375 31.5 9.84375ZM51.8438 47.25C51.8438 52.8623 43.0973 57.0938 31.5 57.0938C19.9027 57.0938 11.1562 52.8623 11.1562 47.25C11.1562 43.1182 15.6713 39.7374 23.2339 38.207C24.3075 37.997 25.3391 38.6794 25.5543 39.7451C25.7722 40.8109 25.0818 41.8504 24.0161 42.0657C18.1597 43.2522 15.0938 45.5726 15.0938 47.25C15.0938 49.6571 21.4856 53.1562 31.5 53.1562C41.5144 53.1562 47.9062 49.6571 47.9062 47.25C47.9062 45.5726 44.8429 43.2522 38.9839 42.0657C37.9182 41.8504 37.2304 40.8109 37.4457 39.7451C37.6609 38.6794 38.703 37.997 39.7661 38.207C47.3287 39.7374 51.8438 43.1182 51.8438 47.25Z" fill="#2BCCA2"/>
                                        </svg>
                                    </div>
                                    <div class="boxed1">
                                        <p class="boxedData"><?php echo($row['name']);?></p>
                                        <p class="boxedType">Lugar</p>
                                    </div>
                                </div>
                                <div class="boxed">
                                    <div>
                                        <svg width="50" height="50" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M44.625 8.53125H43.9688V7.875C43.9688 6.78825 43.0867 5.90625 42 5.90625C40.9133 5.90625 40.0312 6.78825 40.0312 7.875V8.53125H22.9688V7.875C22.9688 6.78825 22.0868 5.90625 21 5.90625C19.9132 5.90625 19.0312 6.78825 19.0312 7.875V8.53125H18.375C11.5001 8.53125 5.90625 14.1251 5.90625 21V44.625C5.90625 51.4999 11.5001 57.0938 18.375 57.0938H44.625C51.4999 57.0938 57.0938 51.4999 57.0938 44.625V21C57.0938 14.1251 51.4999 8.53125 44.625 8.53125ZM18.375 12.4688H19.0312V15.75C19.0312 16.8368 19.9132 17.7188 21 17.7188C22.0868 17.7188 22.9688 16.8368 22.9688 15.75V12.4688H40.0312V15.75C40.0312 16.8368 40.9133 17.7188 42 17.7188C43.0867 17.7188 43.9688 16.8368 43.9688 15.75V12.4688H44.625C49.329 12.4688 53.1562 16.296 53.1562 21V21.6562H9.84375V21C9.84375 16.296 13.671 12.4688 18.375 12.4688ZM44.625 53.1562H18.375C13.671 53.1562 9.84375 49.329 9.84375 44.625V25.5938H53.1562V44.625C53.1562 49.329 49.329 53.1562 44.625 53.1562ZM44.625 34.125C44.625 35.574 43.449 36.75 42 36.75C40.551 36.75 39.375 35.574 39.375 34.125C39.375 32.676 40.551 31.5 42 31.5C43.449 31.5 44.625 32.676 44.625 34.125ZM34.125 34.125C34.125 35.574 32.949 36.75 31.5 36.75C30.051 36.75 28.875 35.574 28.875 34.125C28.875 32.676 30.051 31.5 31.5 31.5C32.949 31.5 34.125 32.676 34.125 34.125ZM23.625 34.125C23.625 35.574 22.449 36.75 21 36.75C19.551 36.75 18.375 35.574 18.375 34.125C18.375 32.676 19.551 31.5 21 31.5C22.449 31.5 23.625 32.676 23.625 34.125ZM44.625 44.625C44.625 46.074 43.449 47.25 42 47.25C40.551 47.25 39.375 46.074 39.375 44.625C39.375 43.176 40.551 42 42 42C43.449 42 44.625 43.176 44.625 44.625ZM34.125 44.625C34.125 46.074 32.949 47.25 31.5 47.25C30.051 47.25 28.875 46.074 28.875 44.625C28.875 43.176 30.051 42 31.5 42C32.949 42 34.125 43.176 34.125 44.625ZM23.625 44.625C23.625 46.074 22.449 47.25 21 47.25C19.551 47.25 18.375 46.074 18.375 44.625C18.375 43.176 19.551 42 21 42C22.449 42 23.625 43.176 23.625 44.625Z" fill="#2BCCA2"/>
                                        </svg>
                                    </div>
                                    <div class="boxed1">
                                        <p class="boxedData"><?php echo($row['date']);?></p>
                                        <p class="boxedType">Fecha</p>
                                    </div>
                                </div>
                                <div class="boxed">
                                    <div>
                                        <svg width="50" height="50" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M47.5072 20.9029L51.2689 17.1413C52.038 16.3722 52.038 15.1252 51.2689 14.3561C50.4998 13.587 49.2529 13.587 48.4838 14.3561L44.604 18.2359C41.4514 15.8288 37.6346 14.2563 33.4688 13.8809V9.84375H36.75C37.8367 9.84375 38.7188 8.96175 38.7188 7.875C38.7188 6.78825 37.8367 5.90625 36.75 5.90625H26.25C25.1632 5.90625 24.2812 6.78825 24.2812 7.875C24.2812 8.96175 25.1632 9.84375 26.25 9.84375H29.5312V13.8809C18.5115 14.881 9.84375 24.1605 9.84375 35.4375C9.84375 47.3786 19.5589 57.0938 31.5 57.0938C43.4411 57.0938 53.1562 47.3786 53.1562 35.4375C53.1562 29.841 51.0037 24.7485 47.5072 20.9029ZM31.5 53.1562C21.7297 53.1562 13.7812 45.2078 13.7812 35.4375C13.7812 25.6672 21.7297 17.7188 31.5 17.7188C41.2703 17.7188 49.2188 25.6672 49.2188 35.4375C49.2188 45.2078 41.2703 53.1562 31.5 53.1562ZM38.2856 40.7689C38.9655 41.6194 38.829 42.8556 37.9785 43.5355C37.6136 43.8269 37.1805 43.9688 36.75 43.9688C36.1725 43.9688 35.6003 43.7167 35.2118 43.2311L29.9618 36.6686C29.6835 36.3195 29.5286 35.8864 29.5286 35.4375V26.25C29.5286 25.1632 30.4106 24.2812 31.4974 24.2812C32.5841 24.2812 33.4661 25.1632 33.4661 26.25V34.7473L38.2856 40.7689Z" fill="#2BCCA2"/>
                                        </svg>
                                    </div>
                                    <div class="boxed1">
                                        <p class="boxedData"><?php if($row['date'] > date('Y-m-d H:i:s')){echo ($row['timeLeft'] . 'hs');}else{echo "Finalizado";}?></p>
                                        <p class="boxedType">Tiempo restante</p>
                                    </div>
                                </div>
                                <div class="boxed">
                                    <div>
                                        <svg width="50" height="50" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M31.5 33.4702C38.3749 33.4702 43.9688 27.8763 43.9688 21.0015C43.9688 14.1266 38.3749 8.53271 31.5 8.53271C24.6251 8.53271 19.0312 14.1266 19.0312 21.0015C19.0312 27.8763 24.6251 33.4702 31.5 33.4702ZM31.5 12.4702C36.204 12.4702 40.0312 16.2975 40.0312 21.0015C40.0312 25.7055 36.204 29.5327 31.5 29.5327C26.796 29.5327 22.9688 25.7055 22.9688 21.0015C22.9688 16.2975 26.796 12.4702 31.5 12.4702ZM49.2188 45.6765V47.9497C49.2188 50.1206 48.4234 52.2023 46.9823 53.8114C46.5964 54.2472 46.0556 54.4677 45.5148 54.4677C45.045 54.4677 44.5777 54.3022 44.2023 53.9662C43.3912 53.2417 43.3231 51.9975 44.0476 51.1864C44.8403 50.2992 45.2787 49.1493 45.2787 47.9497V45.6765C45.2787 42.3979 43.1052 39.563 39.9946 38.7833C39.4853 38.6547 38.955 38.7254 38.5218 38.9695C34.1591 41.4003 28.8146 41.3898 24.486 38.9801C24.0319 38.7228 23.5017 38.6571 23.0003 38.7805C19.8871 39.5627 17.7135 42.3979 17.7135 45.6765V47.9497C17.7135 49.1493 18.1518 50.2992 18.9446 51.1864C19.6691 51.9975 19.6009 53.2417 18.7898 53.9662C17.9813 54.688 16.7344 54.6225 16.0099 53.8114C14.5687 52.2023 13.7734 50.1179 13.7734 47.9497V45.6765C13.7734 40.5919 17.1701 36.1871 22.0342 34.9612C23.5042 34.5884 25.1082 34.8011 26.4128 35.5492C29.5392 37.2869 33.4241 37.2974 36.5872 35.5386C37.8735 34.801 39.4721 34.5858 40.9499 34.9638C45.8219 36.187 49.2188 40.5919 49.2188 45.6765ZM45.3942 10.2941C45.7565 9.27039 46.8799 8.73219 47.9062 9.09444C51.8306 10.4804 54.4688 14.2106 54.4688 18.3765C54.4688 21.1747 53.2718 23.8471 51.1875 25.7135C50.8095 26.0495 50.3422 26.2146 49.875 26.2146C49.3343 26.2146 48.7961 25.9941 48.4076 25.5584C47.6831 24.7472 47.7514 23.5031 48.5625 22.7786C49.8146 21.6603 50.5312 20.0565 50.5312 18.3765C50.5312 15.8775 48.9484 13.6385 46.5938 12.8064C45.5674 12.4441 45.032 11.3179 45.3942 10.2941ZM57.0938 38.9381V40.8335C57.0938 41.9202 56.2117 42.8022 55.125 42.8022C54.0383 42.8022 53.1562 41.9202 53.1562 40.8335V38.9381C53.1562 36.3577 51.4474 34.1264 49.0009 33.5122C47.9482 33.2471 47.3051 32.1786 47.5703 31.1234C47.838 30.0681 48.9116 29.4304 49.959 29.6929C54.1616 30.7482 57.0938 34.5491 57.0938 38.9381ZM11.8125 26.8789C9.72825 25.0125 8.53125 22.3401 8.53125 19.5419C8.53125 15.376 11.1694 11.6459 15.0938 10.2599C16.128 9.89761 17.2435 10.4358 17.6058 11.4596C17.968 12.4859 17.4326 13.6095 16.4062 13.9718C14.0516 14.8039 12.4688 17.0429 12.4688 19.5419C12.4688 21.2193 13.1854 22.8231 14.4375 23.944C15.2486 24.6685 15.3169 25.913 14.5924 26.7241C14.2066 27.1599 13.6658 27.3804 13.125 27.3804C12.6578 27.3804 12.1879 27.2149 11.8125 26.8789ZM13.9991 34.6776C11.5526 35.2919 9.84375 37.5232 9.84375 40.1035V42.0015C9.84375 43.0882 8.96175 43.9702 7.875 43.9702C6.78825 43.9702 5.90625 43.0882 5.90625 42.0015V40.1061C5.90625 35.7171 8.84105 31.9162 13.041 30.8609C14.0937 30.6037 15.1646 31.2364 15.4297 32.2917C15.6949 33.3417 15.0544 34.4125 13.9991 34.6776Z" fill="#2BCCA2"/>
                                        </svg>
                                    </div>
                                    <div class="boxed1">
                                        <p class="boxedData"><?php echo($row['inscriptions'])?></p>
                                        <p class="boxedType">Inscriptos</p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                <div id="rightSide" class="col-12 col-lg-8">                    
                    <div id="box3" class="box">
                        <h2>Pruebas de torneo</h2>
                        <div id="box3MainContent">
                            <div id="results">
                                <?php
                                if(isset($_COOKIE['mainCompetitionSelected'])){
                                    $sql = "select events.ID_event, disciplines.name as 'discipline', events.gender, DATE_FORMAT(events.time, '%H:%i') as 'time', disciplines.campus, group_concat(categories.name SEPARATOR ' ') as 'categories' from events left join eventscategories on eventscategories.ID_event = events.iD_event left join categories on categories.ID_category = eventscategories.id_category left join disciplines on disciplines.ID_discipline = events.ID_discipline where events.ID_competition = " . $_COOKIE['mainCompetitionSelected'] . " group by events.id_event order by events.time ASC";
                                }else{
                                    $sql = "select events.ID_event, disciplines.name as 'discipline', events.gender, DATE_FORMAT(events.time, '%H:%i') as 'time', disciplines.campus, group_concat(categories.name SEPARATOR ' ') as 'categories' from events left join eventscategories on eventscategories.ID_event = events.iD_event left join categories on categories.ID_category = eventscategories.id_category left join disciplines on disciplines.ID_discipline = events.ID_discipline where events.ID_competition = " . $mainCompetition . " group by events.id_event order by events.time ASC";
                                }
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()){?>
                                    <div class="resultItem">
                                        <div class="resultItem1">
                                            <p class="genderDiscipline"><?php if($row['gender'] == 0){echo "Femenino";}else{echo "Masculino";}?> | <?php echo($row['discipline']);if($row['campus'] == 0){echo "s";}else{echo "m";}?></p>
                                            <p class="categories"><?php echo($row['categories']);?></p>
                                        </div>
                                        <p class="time"><?php echo($row['time']);?>hs</p>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <a href="competitionDetails.html" target="__Blank" id="moreDetails">Mas detalles</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script><?php include('../public/resources/js/homeCompetition.js');?></script>
<?php include('../public/pages/footer.html'); ?>