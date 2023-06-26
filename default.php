<?php include('private/database/db.php');?>
<?php include('public/pages/header.html'); ?>
<title>webFam</title>
<style><?php include('public/resources/css/home.css')?></style>
</head>
<body>

<nav>
  <div id="navFamLogo">
    <img src="public/img/famLogoSmall.svg" alt="logo de fam small">
    <p>FAM</p>
  </div>
  <div id="navMenuIcon">
    <div class="menuIconElement" id="line1"></div>
    <div class="menuIconElement" id="line2"></div>
    <div class="menuIconElement" id="line3"></div>
  </div>
</nav>

<div id="menu">
  <svg id="menuBackground">
      <circle>
  </svg>
  <div id="menuContainer">
      <h2 id="menuTitle">MENU</h2>
      <div>
          <div id="subMenuContainer">
              <a href="perfil" data-text="Cuenta" id="subMenuAccount">Cuenta</a>
              <a href="ranking" data-text="Ranking" id="subMenuRanking">Ranking</a>
              <a href="resultados" data-text="Resultados" id="subMenuResults">Resultados</a>
              <a href="competencias" data-text="Competencias" id="subMenuCompetitions">Competencias</a>
              <a href="atletas" data-text="Atletas" id="subMenuAthletes">Atletas</a>
              <a href="clubs" data-text="Clubs" id="subMenuClubs">Clubs</a>
              <a href="news" data-text="Noticias" id="subMenuNews">Noticias</a>
          </div>
      </div>
  </div>
</div>  

<main>
  <section id="background">
    <div id="startCover"></div>
    <figure id="backgroundCircle" class="animate">
      <svg role="img" xmlns="http://www.w3.org/2000/svg">
        <circle class="circle-background"/>
        <circle class="circle-foreground"/>
      </svg>
    </figure>
    <p id="backgroundText" data-text="FAM">FAM</p>
    <div id="crossElements">
      <div id="firstCross">
        <?php for($e = 0; $e < 3; $e++){
          for($i = 0; $i < 6; $i++){
            echo('<svg viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>');
            }
          }?> 
        </div>
      <div id="secondCross">
        <?php for($e = 0; $e < 3; $e++){
          for($i = 0; $i < 6; $i++){
            echo('<svg viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>');
          }
        }?> 
      </div>
    </div>
  </section>
  <section id="mainContent" class="row">
    <div class="col-1"></div>
    <div class="col-9 inner">
      <h2 id="preTitle">Este es el sitio web de la</h2>
      <h1>Federacion<br>Atletica<br>Metropolitana</h1>
      <p id="subTitle">Creado para todos los atletas, brindando simplesa a la hora de las inscripciones y las ultimas noticias del deporte.</p>
      <div id="aboutUs">
        <p>sobre nosotros</p>
      </div>
      
    </div>
    <div class="col-2"></div>
  </section>
  <a id="scrollIndicator">
    <div class="arrow-2">
      <svg width="50" height="31" viewBox="0 0 50 31" fill="none">
        <rect width="35.5444" height="7.89875" rx="3.94937" transform="matrix(0.70058 -0.713574 0.70058 0.713574 19.5647 25.3638)" fill="white"/>
        <rect width="35.5444" height="7.89875" rx="3.94937" transform="matrix(-0.70058 -0.713574 0.70058 -0.713574 24.9016 31)" fill="white"/>
      </svg>
    </div>
    <div class="arrow-1"></div>
  </a>
</main>

<div id="mainContentContainer">
  <section id="afterMain" class="row container-fluid">
    <div class="col-12 col-lg-6 mainCardsContainer">
      <div class="col-12 mainCards" id="cardNextCompetition">
        <div class="cardsHeader">
          <h3>Proximo Torneo</h3>
          <div class="svgAux">
            <svg width="84" height="84" viewBox="0 0 84 84" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M27.0454 9.625C23.2234 9.625 20.125 12.7234 20.125 16.5454V35C20.125 47.0813 29.9188 56.875 42 56.875C54.0813 56.875 63.875 47.0813 63.875 35V16.5454C63.875 12.7234 60.7764 9.625 56.9544 9.625H27.0454Z" stroke="#00C7E3" stroke-width="3"/>
              <path d="M42 59.5V63" stroke="#00C7E3" stroke-width="3" stroke-linecap="round"/>
              <path d="M52.5 65.625H31.5C29.0838 65.625 27.125 67.5838 27.125 70C27.125 72.4162 29.0838 74.375 31.5 74.375H52.5C54.9162 74.375 56.875 72.4162 56.875 70C56.875 67.5838 54.9162 65.625 52.5 65.625Z" stroke="#00C7E3" stroke-width="3"/>
              <path d="M19.25 17.5C14.4175 17.5 10.5 21.4175 10.5 26.25V27.3995C10.5 30.025 11.543 32.543 13.3995 34.3995L21 42" stroke="#00C7E3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M64.75 17.5C69.5824 17.5 73.5 21.4175 73.5 26.25V27.3995C73.5 30.025 72.457 32.543 70.6006 34.3995L63 42" stroke="#00C7E3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        <?php
          $sql = "select competitions.name, competitions.date, competitions.ID_competition, places.name as 'place' from competitions left join places on places.id_place = competitions.ID_place where competitions.public = 1 and competitions.date > curdate() order by competitions.date ASC limit 1;";
          $result = $conn->query($sql);
          if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){ ?>
              <div class="widgetCardA">
                <h4><?php echo $row['name'];?></h4>
                <p><?php echo $row['place']; ?></p>
                <p><?php echo $row['date']; ?></p>
              </div>
              <a href="competencias" class="seeMoreButton"><p>Ver mas</p></a>
        <?php }}else{
            echo "<p>No hay competencias pendientes</p>";
          } ?>
        
    </div>
      <div class="col-12 mainCards" id="cardLastResults">
        <div class="cardsHeader">
          <h3>Ultimos Resultados</h3>
          <div class="svgAux">
            <svg width="81" height="81" viewBox="0 0 81 81" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M45.5625 9.28125H35.4375C32.1756 9.28125 29.5312 11.9256 29.5312 15.1875C29.5312 18.4494 32.1756 21.0938 35.4375 21.0938H45.5625C48.8244 21.0938 51.4688 18.4494 51.4688 15.1875C51.4688 11.9256 48.8244 9.28125 45.5625 9.28125Z" stroke="#00C7E3" stroke-width="1.5"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M27.1568 13.6113C27.0539 14.1539 27 14.7139 27 15.2865C27 16.4793 27.2338 17.6176 27.6581 18.6579C25.8641 18.7225 24.3308 18.8306 22.9864 19.0113C19.8715 19.4301 18.5384 20.1539 17.6588 21.0335C16.7792 21.9131 16.0554 23.2462 15.6366 26.3611C15.1983 29.6216 15.1875 33.9927 15.1875 40.4997V47.2497C15.1875 53.7567 15.1983 58.1276 15.6366 61.3882C16.0554 64.503 16.7792 65.8361 17.6588 66.716C18.5384 67.5955 19.8715 68.3195 22.9864 68.738C26.2469 69.1764 30.6179 69.1872 37.125 69.1872H43.875C50.382 69.1872 54.753 69.1764 58.0135 68.738C61.1283 68.3195 62.4615 67.5955 63.3413 66.716C64.2208 65.8361 64.9444 64.503 65.3633 61.3882C65.8017 58.1276 65.8125 53.7567 65.8125 47.2497V40.4997C65.8125 33.9927 65.8017 29.6216 65.3633 26.3611C64.9444 23.2462 64.2208 21.9131 63.3413 21.0335C62.4615 20.1539 61.1283 19.4301 58.0135 19.0113C56.6693 18.8306 55.136 18.7225 53.3419 18.6579C53.7661 17.6176 54 16.4793 54 15.2865C54 14.7139 53.946 14.1539 53.8431 13.6113C60.2549 13.8663 64.1709 14.7037 66.9208 17.4538C70.875 21.4078 70.875 27.7718 70.875 40.4997V47.2497C70.875 59.9775 70.875 66.3417 66.9208 70.2955C62.967 74.2497 56.6028 74.2497 43.875 74.2497H37.125C24.3971 74.2497 18.0331 74.2497 14.079 70.2955C10.125 66.3417 10.125 59.9775 10.125 47.2497V40.4997C10.125 27.7718 10.125 21.4078 14.079 17.4538C16.8291 14.7037 20.7449 13.8663 27.1568 13.6113Z" fill="#00C7E3"/>
              <path d="M33.75 45.5625L38.8125 50.625L48.9375 40.5" stroke="#00C7E3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        <?php
          $sql = "select competitions.name, competitions.date, competitions.ID_competition, places.name as 'place' from competitions left join places on places.ID_place = competitions.ID_place where competitions.public = 1 and competitions.date <= curdate() order by competitions.date DESC limit 1;";
          $result = $conn->query($sql);
          if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){ ?>
              <div class="widgetCardA">
                <h4><?php echo $row['name'];?></h4>
                <p><?php echo $row['place']; ?></p>
                <p><?php echo $row['date']; ?></p>
              </div>
              <a href="resultados" class="seeMoreButton"><p>Ver mas</p></a>
        <?php }}else{
            echo "<p>No hay competencias pendientes</p>";
          } ?>
    </div>
    </div>
    <div class="col-12 col-lg-6 mainCardsContainer">
      <div class="col-12 mainCards" id="cardNews">
      <div class="cardsHeader">
          <h3>Noticias</h3>
          <div class="svgAux">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7389 25.0186C13.039 25.0186 12.5068 25.671 12.8729 26.2674C13.5177 27.3179 14.6771 28.0186 16.0001 28.0186C17.3231 28.0186 18.4824 27.3179 19.1273 26.2674C19.4935 25.671 18.9612 25.0186 18.2613 25.0186C17.8159 25.0186 17.4333 25.3119 17.0984 25.6055C16.8052 25.8627 16.4208 26.0186 16.0001 26.0186C15.5793 26.0186 15.1951 25.8627 14.9017 25.6055C14.5669 25.3119 14.1843 25.0186 13.7389 25.0186Z" fill="#00C7E3"/>
              <mask id="mask0_111_2640" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="4" y="2" width="24" height="22">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M26.0001 14.4671C26.0001 10.4826 24.0223 6.758 20.7215 4.5262L18.9874 3.35364C17.1827 2.13342 14.8174 2.13342 13.0127 3.35364L11.2786 4.52618C7.97781 6.758 6.00008 10.4826 6.00008 14.4671V17.0189C5.18175 17.7513 4.66675 18.8157 4.66675 20.0004C4.66675 22.2096 6.45761 24.0004 8.66675 24.0004H23.3334C25.5426 24.0004 27.3334 22.2096 27.3334 20.0004C27.3334 18.8157 26.8183 17.7513 26.0001 17.0189V14.4671Z" fill="white"/>
              </mask>
              <g mask="url(#mask0_111_2640)"><path d="M20.7215 4.52619L19.6013 6.18301L20.7215 4.52619ZM26.0001 14.4671H28.0001H26.0001ZM18.9874 3.35363L20.1077 1.69682L18.9874 3.35363ZM13.0127 3.35363L11.8925 1.69682L13.0127 3.35363ZM11.2786 4.52618L12.3988 6.18301L11.2786 4.52618ZM6.00008 14.4671H8.00008H6.00008ZM6.00008 17.0189L7.33391 18.5092L8.00008 17.9129V17.0189H6.00008ZM26.0001 17.0189H24.0001V17.9129L24.6662 18.5092L26.0001 17.0189ZM19.6013 6.18301C22.3519 8.04283 24.0001 11.1467 24.0001 14.4671H28.0001C28.0001 9.81854 25.6927 5.47314 21.8418 2.86937L19.6013 6.18301ZM17.8671 5.01045L19.6013 6.18301L21.8418 2.86937L20.1077 1.69682L17.8671 5.01045ZM14.133 5.01045C15.2609 4.24782 16.7393 4.24782 17.8671 5.01045L20.1077 1.69682C17.6262 0.0190291 14.3739 0.0190286 11.8925 1.69682L14.133 5.01045ZM12.3988 6.18301L14.133 5.01045L11.8925 1.69682L10.1583 2.86937L12.3988 6.18301ZM8.00008 14.4671C8.00008 11.1467 9.64819 8.04283 12.3988 6.18301L10.1583 2.86937C6.30743 5.47314 4.00008 9.81854 4.00008 14.4671H8.00008ZM8.00008 17.0189V14.4671H4.00008V17.0189H8.00008ZM6.66675 20.0004C6.66675 19.4083 6.92155 18.8783 7.33391 18.5092L4.66625 15.5287C3.44195 16.6244 2.66675 18.2232 2.66675 20.0004H6.66675ZM8.66675 22.0004C7.56217 22.0004 6.66675 21.1049 6.66675 20.0004H2.66675C2.66675 23.3141 5.35304 26.0004 8.66675 26.0004V22.0004ZM23.3334 22.0004H8.66675V26.0004H23.3334V22.0004ZM25.3334 20.0004C25.3334 21.1049 24.4379 22.0004 23.3334 22.0004V26.0004C26.6471 26.0004 29.3334 23.3141 29.3334 20.0004H25.3334ZM24.6662 18.5092C25.0786 18.8783 25.3334 19.4083 25.3334 20.0004H29.3334C29.3334 18.2232 28.5582 16.6244 27.334 15.5287L24.6662 18.5092ZM24.0001 14.4671V17.0189H28.0001V14.4671H24.0001Z" fill="#00C7E3"/></g>
            </svg>
          </div>
        </div>
        <?php
          $sql = "select * from news limit 4";
          $result = $conn->query($sql);
          if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){ ?>
              <div class="widgetCardB">
                <img src="data:image/png;base64,<?php echo(base64_encode($row['mainImg']));?>" alt="noticia">
                <div>
                  <h4><?php echo($row['title'])?></h4>
                  <p><?php echo($row['publishDate']);?></p>
                </div>
              </div>

          <?php }}?>
        
        <a class="seeMoreButton" href="news"><p>Ver Todas</p></a>
    </div>
    <?php
          $sql = "select competitions.name, competitions.date, competitions.ID_competition, places.name as 'place' from competitions left join places on places.ID_place = competitions.id_place where competitions.date = curdate();";
          $result = $conn->query($sql);
          if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){ ?>
              <div class="col-12 mainCards" id="cardDayCompetition">
        <div class="cardsHeader">
          <h3>Torneo Del Dia</h3>
          <div class="svgAux">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.8224 4.88369C15.3237 3.93981 16.6762 3.93981 17.1776 4.88369L19.7856 9.79416C19.9782 10.157 20.3276 10.4108 20.7322 10.4819L26.2082 11.4449C27.2609 11.63 27.6787 12.9163 26.9359 13.6847L23.0718 17.6826C22.7862 17.9779 22.6529 18.3886 22.7102 18.7954L23.4866 24.301C23.6358 25.3593 22.5416 26.1542 21.5813 25.6853L16.585 23.2457C16.2158 23.0653 15.7841 23.0653 15.4149 23.2457L10.4187 25.6853C9.45829 26.1542 8.36411 25.3593 8.51334 24.301L9.28968 18.7954C9.34706 18.3886 9.21366 17.9779 8.92811 17.6826L5.06391 13.6847C4.32114 12.9163 4.73909 11.63 5.79169 11.4449L11.2677 10.4819C11.6724 10.4108 12.0216 10.157 12.2144 9.79416L14.8224 4.88369Z" stroke="#00C7E3" stroke-width="1.5"/>
            </svg>
          </div>
        </div>
        <h4><?php echo $row['name'];?></h4>
        <p><?php echo $row['place'];?></p>
        <div class="widgetCardC">
          <a href="competencias"><h5>Horarios</h5></a>
        </div>
        <div class="widgetCardC">
          <a href="resultados"><h5>Resultados</h5></a>
        </div>
      </div>
        <?php }}?>
    
    </div>
  </section>
  <footer class="row container-fluid">
  <div class="col-6 col-md-3">
    <a href="https://www.instagram.com/webfamok/" target="_blanck" class="col-12 footerSocial">
      <div class="svgAux">
        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip0_111_2675)">
            <path d="M13 2.34102C16.4734 2.34102 16.8848 2.35625 18.2508 2.41719C19.5203 2.47305 20.2059 2.68633 20.6629 2.86406C21.2672 3.09766 21.7039 3.38203 22.1559 3.83398C22.6129 4.29102 22.8922 4.72266 23.1258 5.32695C23.3035 5.78398 23.5168 6.47461 23.5727 7.73906C23.6336 9.11016 23.6488 9.52149 23.6488 12.9898C23.6488 16.4633 23.6336 16.8746 23.5727 18.2406C23.5168 19.5102 23.3035 20.1957 23.1258 20.6527C22.8922 21.257 22.6078 21.6938 22.1559 22.1457C21.6988 22.6027 21.2672 22.882 20.6629 23.1156C20.2059 23.2934 19.5152 23.5066 18.2508 23.5625C16.8797 23.6234 16.4684 23.6387 13 23.6387C9.52656 23.6387 9.11524 23.6234 7.74922 23.5625C6.47969 23.5066 5.79414 23.2934 5.33711 23.1156C4.73281 22.882 4.29609 22.5977 3.84414 22.1457C3.38711 21.6887 3.10781 21.257 2.87422 20.6527C2.69648 20.1957 2.4832 19.5051 2.42734 18.2406C2.36641 16.8695 2.35117 16.4582 2.35117 12.9898C2.35117 9.51641 2.36641 9.10508 2.42734 7.73906C2.4832 6.46953 2.69648 5.78398 2.87422 5.32695C3.10781 4.72266 3.39219 4.28594 3.84414 3.83398C4.30117 3.37695 4.73281 3.09766 5.33711 2.86406C5.79414 2.68633 6.48477 2.47305 7.74922 2.41719C9.11524 2.35625 9.52656 2.34102 13 2.34102ZM13 0C9.4707 0 9.02891 0.0152344 7.64258 0.0761719C6.26133 0.137109 5.31172 0.360547 4.48906 0.680469C3.63086 1.01562 2.90469 1.45742 2.18359 2.18359C1.45742 2.90469 1.01563 3.63086 0.680469 4.48398C0.360547 5.31172 0.137109 6.25625 0.0761719 7.6375C0.0152344 9.02891 0 9.4707 0 13C0 16.5293 0.0152344 16.9711 0.0761719 18.3574C0.137109 19.7387 0.360547 20.6883 0.680469 21.5109C1.01563 22.3691 1.45742 23.0953 2.18359 23.8164C2.90469 24.5375 3.63086 24.9844 4.48398 25.3145C5.31172 25.6344 6.25625 25.8578 7.6375 25.9188C9.02383 25.9797 9.46563 25.9949 12.9949 25.9949C16.5242 25.9949 16.966 25.9797 18.3523 25.9188C19.7336 25.8578 20.6832 25.6344 21.5059 25.3145C22.359 24.9844 23.0852 24.5375 23.8063 23.8164C24.5273 23.0953 24.9742 22.3691 25.3043 21.516C25.6242 20.6883 25.8477 19.7438 25.9086 18.3625C25.9695 16.9762 25.9848 16.5344 25.9848 13.0051C25.9848 9.47578 25.9695 9.03399 25.9086 7.64766C25.8477 6.26641 25.6242 5.3168 25.3043 4.49414C24.9844 3.63086 24.5426 2.90469 23.8164 2.18359C23.0953 1.4625 22.3691 1.01562 21.516 0.685547C20.6883 0.365625 19.7438 0.142188 18.3625 0.08125C16.9711 0.0152344 16.5293 0 13 0Z" fill="white"/>
            <path d="M13 6.32227C9.31328 6.32227 6.32227 9.31328 6.32227 13C6.32227 16.6867 9.31328 19.6777 13 19.6777C16.6867 19.6777 19.6777 16.6867 19.6777 13C19.6777 9.31328 16.6867 6.32227 13 6.32227ZM13 17.3316C10.6082 17.3316 8.66836 15.3918 8.66836 13C8.66836 10.6082 10.6082 8.66836 13 8.66836C15.3918 8.66836 17.3316 10.6082 17.3316 13C17.3316 15.3918 15.3918 17.3316 13 17.3316Z" fill="white"/>
            <path d="M21.5008 6.05801C21.5008 6.92129 20.8 7.617 19.9418 7.617C19.0785 7.617 18.3828 6.91621 18.3828 6.05801C18.3828 5.19473 19.0836 4.49902 19.9418 4.49902C20.8 4.49902 21.5008 5.19981 21.5008 6.05801Z" fill="white"/>
          </g>
          <defs><clipPath id="clip0_111_2675"><rect width="26" height="26" fill="white"/></clipPath></defs>
        </svg>
      </div>
      <div class="socialContainer">
        <h4>Instagram</h4>
        <p>@webfamok</p>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3">
    <a href="https://www.facebook.com/webfamok/" target="_blanck" class="col-12 footerSocial">
      <div class="svgAux">
        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip0_111_2692)">
            <path d="M26 13C26 5.82029 20.1797 0 13 0C5.82029 0 0 5.82029 0 13C0 19.4886 4.75389 24.8668 10.9688 25.8421V16.7578H7.66797V13H10.9688V10.1359C10.9688 6.87781 12.9096 5.07812 15.879 5.07812C17.3009 5.07812 18.7891 5.33203 18.7891 5.33203V8.53125H17.1498C15.535 8.53125 15.0313 9.53342 15.0313 10.5625V13H18.6367L18.0604 16.7578H15.0313V25.8421C21.2461 24.8668 26 19.4886 26 13Z" fill="white"/>
          </g>
          <defs><clipPath id="clip0_111_2692"><rect width="26" height="26" fill="white"/></clipPath></defs>
        </svg>
      </div>
      <div class="socialContainer">
        <h4>Facebook</h4>
        <p>@webfamok</p>
      </div>
    </a>
  </div>
  <div class="col-12 col-md-6">
    <a href="mailto:webfam@info.com.ar" class="col-12 footerSocial">
      <div class="svgAux">
        <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M26.2812 8.15625V20.8438C26.2812 21.8448 25.4698 22.6562 24.4688 22.6562H4.53125C3.53023 22.6562 2.71875 21.8448 2.71875 20.8438V8.15625M26.2812 8.15625C26.2812 7.15523 25.4698 6.34375 24.4688 6.34375H4.53125C3.53023 6.34375 2.71875 7.15523 2.71875 8.15625M26.2812 8.15625L15.5317 15.5983C14.911 16.028 14.089 16.028 13.4683 15.5983L2.71875 8.15625" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="socialContainer">
        <h4>Mail</h4>
        <p>info@webfam.com.ar</p>
      </div>
    </a>
  </div>
  <div class="col-12" id="footerText"><p>Federacion Atletica Metropolitana 2023</p></div>
</footer>
</div>

<script><?php include('public/resources/js/main.js'); ?></script>
<?php include('public/pages/footer.html');?>