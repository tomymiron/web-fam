<?php
include('../private/database/db.php');
include('../public/pages/header.html');
?>

<title>Clubs</title>
<style><?php include('../public/resources/css/homeClubs.css')?></style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.11/angular.min.js"></script>
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
        <div id="subHeader" class="row">
            <h1 class="col-12 col-md-6">Clubs</h1>
            <form class="col" id="viewForm" spellcheck="false">
                <input ng-app="myApp" ng-controller="myCtrl" type="text" placeholder="Nombre" id="nameToSearch" autocomplete="off" ng-model="bad" ng-change="badri(bad)"/>
                <button type="button" id="searchButton" name="post">
                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.271 21.0833C5.271 12.3502 12.3505 5.27075 21.0835 5.27075C29.8165 5.27075 36.896 12.3502 36.896 21.0833C36.896 29.8163 29.8165 36.8958 21.0835 36.8958C12.3505 36.8958 5.271 29.8163 5.271 21.0833Z" stroke="white" stroke-width="1.5"/>
                        <path d="M35.9373 38.3333C35.9373 37.0102 37.01 35.9375 38.3332 35.9375C39.6564 35.9375 40.729 37.0102 40.729 38.3333C40.729 39.6565 39.6564 40.7292 38.3332 40.7292C37.01 40.7292 35.9373 39.6565 35.9373 38.3333Z" stroke="white" stroke-width="1.5"/>
                    </svg>
                </button>
            </form>
        </div>
        <form method="GET" action="../../perfilClub/default.php" id="mainContent" class="row">
        
        </form>
    </section>
</main>

<script><?php include('../public/resources/js/homeClubs.js');?></script>
<?php include('../public/pages/footer.html'); ?>