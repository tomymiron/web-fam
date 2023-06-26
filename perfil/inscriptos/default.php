<?php
include('../../private/database/db.php');
include('../checkUserExtended.php');
include('../../private/modules/getSetTime.php');
include('../../public/pages/header.html');
?>

<?php $sql = "SELECT * FROM `pendingcompetitions` ORDER BY `pendingcompetitions`.`date` ASC limit 1";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ 
    $mainCompetition =  $row['ID_competition']; 
    setcookie('mainCompetitionInscriptions', $mainCompetition, time() + 10000);
} ?>

    <title>Inscriptos</title>
    <style><?php include('../../public/resources/css/inscribedP.css')?></style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    
    <input type="hidden" id="ID_athlete" value="<?php echo($user['ID_athlete'])?>">
    <input type="hidden" id="password" value="<?php echo($user['password'])?>">

    <nav>
        <div id="menuIconContainer">
            <svg id="menuIcon" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="18" cy="18" r="18" fill="white"/>
                <path d="M26.25 12.5H9.75" stroke="black" stroke-width="1.65" stroke-linecap="round"/>
                <path d="M26.25 18H9.75" stroke="black" stroke-width="1.65" stroke-linecap="round"/>
                <path d="M26.25 23.5H9.75" stroke="black" stroke-width="1.65" stroke-linecap="round"/>
            </svg>
        </div>

        <div id="navUserContainer">
            <div id="imgContainer">
                <div id="imgContainerAux">
                    <?php
                        $sql = "SELECT image FROM images where ID_athlete = " . $user['ID_athlete'];
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){echo '<img class="profileImg" src="data:image/png;base64,'.base64_encode($row['image']).'" />';}
                        }else{echo "<img class='profileImg' src='../../public/img/user.png'>";}
                    ?>
                </div>
            </div>
            <h3><?php echo $user['name'];?></h3>
        </div>
    </nav>

    <main>
        <aside id="menu">
            <a title="home" id="famIcon" href="../../">
                <svg width="89" height="110" viewBox="0 0 89 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M53.0289 88.1061C49.5519 95.0011 39.7073 95.0011 36.2303 88.1061L17.1297 50.2292C13.9747 43.9728 18.5221 36.5868 25.529 36.5868H63.7302C70.7371 36.5868 75.2845 43.9728 72.1295 50.2292L53.0289 88.1061Z" stroke="#36B9CC" stroke-width="1.5"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M39.2627 41.9326C39.2627 41.7347 39.1023 41.5742 38.9044 41.5742H23.4048C21.508 41.5742 20.2575 43.5496 21.0689 45.2641L38.5805 82.2655C38.744 82.6111 39.2627 82.4946 39.2627 82.1122V41.9326ZM50.1964 81.6924C50.1964 82.0747 50.7151 82.1913 50.8787 81.8457L68.1915 45.2641C69.003 43.5496 67.7524 41.5742 65.8556 41.5742H50.5548C50.3568 41.5742 50.1964 41.7347 50.1964 41.9326V81.6924Z" fill="#36B9CC"/>
                    <path d="M18.2433 5.70957V26H14.0626V5.70957H18.2433ZM26.3261 14.3776V17.6386H17.1006V14.3776H26.3261ZM27.3016 5.70957V8.98447H17.1006V5.70957H27.3016ZM37.8381 9.17957L32.3195 26H27.874L35.4133 5.70957H38.2422L37.8381 9.17957ZM42.423 26L36.8905 9.17957L36.4445 5.70957H39.3014L46.8824 26H42.423ZM42.1721 18.4468V21.7217H31.4555V18.4468H42.1721ZM53.0988 5.70957H56.6385L61.8505 20.6069L67.0624 5.70957H70.6021L63.2719 26H60.429L53.0988 5.70957ZM51.1896 5.70957H54.7154L55.3564 20.2306V26H51.1896V5.70957ZM68.9856 5.70957H72.5253V26H68.3445V20.2306L68.9856 5.70957Z" fill="#36B9CC"/>
                </svg>
            </a>
            <a title="Perfil" class="option" href="../">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M25.4989 26.562C31.3575 26.562 36.1239 21.7956 36.1239 15.937C36.1239 10.0784 31.3575 5.31201 25.4989 5.31201C19.6403 5.31201 14.8739 10.0784 14.8739 15.937C14.8739 21.7956 19.6403 26.562 25.4989 26.562ZM25.4989 7.43701C30.1867 7.43701 33.9989 11.2493 33.9989 15.937C33.9989 20.6248 30.1867 24.437 25.4989 24.437C20.8112 24.437 16.9989 20.6248 16.9989 15.937C16.9989 11.2493 20.8112 7.43701 25.4989 7.43701ZM41.4364 38.1794V40.3278C41.4364 42.1829 40.7586 43.9594 39.5303 45.3322C39.32 45.5659 39.0309 45.687 38.7376 45.687C38.4847 45.687 38.2318 45.5977 38.03 45.4171C37.5922 45.024 37.5561 44.3546 37.9471 43.9169C38.829 42.9351 39.3135 41.6601 39.3135 40.3299V38.1815C39.3135 34.722 37.0143 31.7258 33.7206 30.897C33.0491 30.7292 32.3286 30.8205 31.7421 31.1562C27.8683 33.311 23.1232 33.3046 19.2663 31.1605C18.6713 30.8205 17.953 30.727 17.2815 30.897C13.9878 31.7258 11.6864 34.7199 11.6864 38.1815V40.3299C11.6864 41.6601 12.1709 42.9351 13.0528 43.9169C13.4438 44.3546 13.4077 45.024 12.9699 45.4171C12.5343 45.8081 11.8649 45.772 11.4697 45.3342C10.2393 43.9615 9.56348 42.185 9.56348 40.3299V38.1815C9.56348 33.7466 12.5257 29.9025 16.763 28.8379C17.9594 28.5362 19.2535 28.7061 20.3096 29.3096C23.5141 31.0925 27.4773 31.0967 30.6988 29.3054C31.7464 28.7061 33.0405 28.5362 34.239 28.8379C38.4762 29.9004 41.4364 33.7424 41.4364 38.1794Z" fill="white"/>
                </svg>
            </a>
            <a title="Competencias" class="option" href="../competencias">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M36.125 7.4375H35.0625V6.375C35.0625 5.7885 34.5865 5.3125 34 5.3125C33.4135 5.3125 32.9375 5.7885 32.9375 6.375V7.4375H18.0625V6.375C18.0625 5.7885 17.5865 5.3125 17 5.3125C16.4135 5.3125 15.9375 5.7885 15.9375 6.375V7.4375H14.875C9.60288 7.4375 5.3125 11.7279 5.3125 17V36.125C5.3125 41.3971 9.60288 45.6875 14.875 45.6875H36.125C41.3971 45.6875 45.6875 41.3971 45.6875 36.125V17C45.6875 11.7257 41.3971 7.4375 36.125 7.4375ZM14.875 9.5625H15.9375V12.75C15.9375 13.3365 16.4135 13.8125 17 13.8125C17.5865 13.8125 18.0625 13.3365 18.0625 12.75V9.5625H32.9375V12.75C32.9375 13.3365 33.4135 13.8125 34 13.8125C34.5865 13.8125 35.0625 13.3365 35.0625 12.75V9.5625H36.125C40.2262 9.5625 43.5625 12.8988 43.5625 17V18.0625H7.4375V17C7.4375 12.8988 10.7738 9.5625 14.875 9.5625ZM36.125 43.5625H14.875C10.7738 43.5625 7.4375 40.2262 7.4375 36.125V20.1875H43.5625V36.125C43.5625 40.2241 40.2262 43.5625 36.125 43.5625ZM36.125 27.625C36.125 28.798 35.173 29.75 34 29.75C32.827 29.75 31.875 28.798 31.875 27.625C31.875 26.452 32.827 25.5 34 25.5C35.173 25.5 36.125 26.4499 36.125 27.625ZM27.625 27.625C27.625 28.798 26.673 29.75 25.5 29.75C24.327 29.75 23.375 28.798 23.375 27.625C23.375 26.452 24.327 25.5 25.5 25.5C26.673 25.5 27.625 26.4499 27.625 27.625ZM19.125 27.625C19.125 28.798 18.173 29.75 17 29.75C15.827 29.75 14.875 28.798 14.875 27.625C14.875 26.452 15.827 25.5 17 25.5C18.173 25.5 19.125 26.4499 19.125 27.625ZM36.125 36.125C36.125 37.298 35.173 38.25 34 38.25C32.827 38.25 31.875 37.298 31.875 36.125C31.875 34.952 32.827 34 34 34C35.173 34 36.125 34.9499 36.125 36.125ZM27.625 36.125C27.625 37.298 26.673 38.25 25.5 38.25C24.327 38.25 23.375 37.298 23.375 36.125C23.375 34.952 24.327 34 25.5 34C26.673 34 27.625 34.9499 27.625 36.125ZM19.125 36.125C19.125 37.298 18.173 38.25 17 38.25C15.827 38.25 14.875 37.298 14.875 36.125C14.875 34.952 15.827 34 17 34C18.173 34 19.125 34.9499 19.125 36.125Z" fill="white"/>
                </svg>
            </a>
            <a title="Inscriptos" class="option active">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.9375 21.25C15.9375 20.6635 16.4135 20.1875 17 20.1875H34C34.5865 20.1875 35.0625 20.6635 35.0625 21.25C35.0625 21.8365 34.5865 22.3125 34 22.3125H17C16.4135 22.3125 15.9375 21.8365 15.9375 21.25ZM19.125 15.9375H31.875C32.4615 15.9375 32.9375 15.4615 32.9375 14.875C32.9375 14.2885 32.4615 13.8125 31.875 13.8125H19.125C18.5385 13.8125 18.0625 14.2885 18.0625 14.875C18.0625 15.4615 18.5385 15.9375 19.125 15.9375ZM45.6875 28.6599V34C45.6875 39.2721 41.3971 43.5625 36.125 43.5625H14.875C9.60288 43.5625 5.3125 39.2721 5.3125 34V28.6599C5.3125 27.8587 5.44211 27.0661 5.69498 26.3075L9.80685 13.9762C11.1095 10.0662 14.7559 7.4375 18.8784 7.4375H32.1257C36.2482 7.4375 39.8927 10.0641 41.1974 13.9762L45.3093 26.3075C45.5579 27.0661 45.6875 27.8587 45.6875 28.6599ZM7.84761 26.5625H19.125C19.7115 26.5625 20.1875 27.0385 20.1875 27.625C20.1875 30.5533 22.5717 32.9375 25.5 32.9375C28.4283 32.9375 30.8125 30.5533 30.8125 27.625C30.8125 27.0385 31.2885 26.5625 31.875 26.5625H43.1524L39.1807 14.6476C38.165 11.6046 35.3302 9.5625 32.1257 9.5625H18.8784C15.6718 9.5625 12.8372 11.6046 11.8236 14.6476L7.84761 26.5625ZM43.5625 34V28.6875H32.861C32.3446 32.2873 29.24 35.0625 25.5 35.0625C21.76 35.0625 18.6554 32.2873 18.139 28.6875H7.4375V34C7.4375 38.1012 10.7738 41.4375 14.875 41.4375H36.125C40.2262 41.4375 43.5625 38.0991 43.5625 34Z" fill="white"/>
                </svg>
            </a>
            <a title="Resultados" class="option" href="../resultados">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.9375 14.3438H22.3125M15.9375 25.5H35.0625M15.9375 31.875H35.0625M15.9375 38.25H22.3125M12.75 46.2188H38.25C40.0104 46.2188 41.4375 44.7917 41.4375 43.0312V7.96875C41.4375 6.20834 40.0104 4.78125 38.25 4.78125H12.75C10.9896 4.78125 9.5625 6.20834 9.5625 7.96875V43.0312C9.5625 44.7917 10.9896 46.2188 12.75 46.2188Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="35.0625" cy="14.3438" r="1.09375" fill="white" stroke="white"/>
                </svg>
            </a>
            <a title="Ranking" class="option" href="../ranking">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.4204 5.84375C14.0999 5.84375 12.2188 7.72493 12.2188 10.0454V21.25C12.2188 28.5851 18.165 34.5312 25.5 34.5312C32.8351 34.5312 38.7812 28.5851 38.7812 21.25V10.0454C38.7812 7.72493 36.9 5.84375 34.5795 5.84375H16.4204Z" stroke="white" stroke-width="1.5"/>
                    <path d="M25.5 36.125V38.25" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M31.875 39.8438H19.125C17.658 39.8438 16.4688 41.033 16.4688 42.5C16.4688 43.967 17.658 45.1562 19.125 45.1562H31.875C33.342 45.1562 34.5312 43.967 34.5312 42.5C34.5312 41.033 33.342 39.8438 31.875 39.8438Z" stroke="white" stroke-width="1.5"/>
                    <path d="M11.6875 10.625C8.75349 10.625 6.375 13.0035 6.375 15.9375V16.6354C6.375 18.2295 7.00823 19.7582 8.13541 20.8854L12.75 25.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M39.3125 10.625C42.2465 10.625 44.625 13.0035 44.625 15.9375V16.6354C44.625 18.2295 43.9918 19.7582 42.8647 20.8854L38.25 25.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a title="Clubs" class="option" href="../clubs">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M25.5 26.5625C30.7721 26.5625 35.0625 22.2721 35.0625 17C35.0625 11.7279 30.7721 7.4375 25.5 7.4375C20.2279 7.4375 15.9375 11.7279 15.9375 17C15.9375 22.2721 20.2279 26.5625 25.5 26.5625ZM25.5 9.5625C29.6012 9.5625 32.9375 12.8988 32.9375 17C32.9375 21.1012 29.6012 24.4375 25.5 24.4375C21.3988 24.4375 18.0625 21.1012 18.0625 17C18.0625 12.8988 21.3988 9.5625 25.5 9.5625ZM39.3125 36.975V38.8152C39.3125 40.4409 38.7197 42.0006 37.6402 43.2076C37.4277 43.4414 37.1387 43.5625 36.8476 43.5625C36.5947 43.5625 36.3418 43.4732 36.1399 43.2926C35.7022 42.9016 35.6638 42.2301 36.0548 41.7924C36.7858 40.9764 37.1875 39.9203 37.1875 38.8174V36.975C37.1875 34.0786 35.2643 31.5711 32.5082 30.8784C31.9727 30.7403 31.3948 30.8167 30.9273 31.0845C27.5613 32.9566 23.4302 32.9503 20.0834 31.0888C19.6052 30.8168 19.0337 30.7381 18.4918 30.8762C15.7357 31.569 13.8125 34.0765 13.8125 36.9728V38.8132C13.8125 39.916 14.2142 40.9721 14.9452 41.7881C15.3362 42.2258 15.2978 42.8973 14.8601 43.2883C14.4266 43.6772 13.753 43.6432 13.3598 43.2054C12.2803 41.9984 11.6875 40.4388 11.6875 38.8132V36.975C11.6875 33.1032 14.2736 29.7479 17.9733 28.8171C19.04 28.5473 20.1854 28.7024 21.1268 29.2379C23.8213 30.7381 27.1682 30.7424 29.8818 29.2336C30.8125 28.7024 31.9622 28.5515 33.0247 28.8193C36.7264 29.7479 39.3125 33.1032 39.3125 36.975ZM37.247 8.5085C37.4447 7.95387 38.0502 7.67126 38.6049 7.86039C41.5714 8.90801 43.5625 11.7279 43.5625 14.875C43.5625 16.9894 42.6594 19.0081 41.0826 20.417C40.8808 20.5976 40.6279 20.6868 40.375 20.6868C40.0839 20.6868 39.7928 20.5679 39.5824 20.332C39.1914 19.8942 39.2296 19.2227 39.6674 18.8317C40.7915 17.8245 41.4375 16.3816 41.4375 14.8729C41.4375 12.6246 40.0138 10.6122 37.8951 9.86425C37.3426 9.66875 37.0537 9.061 37.247 8.5085ZM45.6875 31.5201V33.0544C45.6875 33.6409 45.2115 34.1169 44.625 34.1169C44.0385 34.1169 43.5625 33.6409 43.5625 33.0544V31.5201C43.5625 29.1869 42.0134 27.1681 39.7971 26.6114C39.2276 26.469 38.8832 25.891 39.0256 25.3236C39.1701 24.7541 39.7375 24.4056 40.3155 24.5522C43.4775 25.3448 45.6875 28.2115 45.6875 31.5201ZM9.91736 21.3605C8.34273 19.9495 7.4375 17.9308 7.4375 15.8185C7.4375 12.6714 9.43077 9.85151 12.3951 8.80389C12.9498 8.61264 13.5532 8.89737 13.753 9.452C13.9485 10.0045 13.6574 10.6122 13.1049 10.8077C10.9862 11.5557 9.5625 13.5681 9.5625 15.8164C9.5625 17.3251 10.2085 18.768 11.3326 19.7752C11.7704 20.1662 11.8086 20.8377 11.4176 21.2755C11.2051 21.5092 10.9161 21.6303 10.625 21.6303C10.3721 21.6325 10.1192 21.5433 9.91736 21.3605ZM11.2029 27.557C8.98657 28.1137 7.4375 30.1325 7.4375 32.4658V34C7.4375 34.5865 6.9615 35.0625 6.375 35.0625C5.7885 35.0625 5.3125 34.5865 5.3125 34V32.4658C5.3125 29.1572 7.52253 26.2905 10.6845 25.4957C11.2583 25.3512 11.8299 25.6997 11.9744 26.2671C12.1168 26.8366 11.7724 27.4125 11.2029 27.557Z" fill="white"/>
                </svg>
            </a>
            <a title="Atletas" class="option" href="../atletas">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M44.524 18.7729C42.0335 11.6626 35.8519 6.5817 28.3932 5.51282C26.521 5.24507 24.4809 5.24507 22.6088 5.51282C15.1501 6.5817 8.97058 11.6626 6.4822 18.7622C5.70658 20.9064 5.31348 23.1737 5.31348 25.4984C5.31348 27.8232 5.70655 30.0906 6.47792 32.2262C8.96842 39.3365 15.1501 44.4173 22.6088 45.4862C23.5502 45.6201 24.5235 45.6881 25.4989 45.6881C26.4743 45.6881 27.4474 45.6201 28.3909 45.4862C35.8497 44.4173 42.0292 39.3365 44.5175 32.2369C45.2932 30.0927 45.6864 27.8253 45.6864 25.5006C45.6864 23.1758 45.2954 20.9085 44.524 18.7729ZM41.9124 18.0652H34.2241C33.4803 14.5526 32.2033 11.2227 30.4183 8.11596C35.5353 9.55034 39.7194 13.182 41.9124 18.0652ZM32.9385 25.5006C32.9385 27.2813 32.76 29.06 32.4668 30.8152H18.5352C18.2419 29.0642 18.0635 27.2835 18.0635 25.5006C18.0635 23.7198 18.2419 21.9455 18.5352 20.1902H32.4688C32.76 21.9391 32.9385 23.7177 32.9385 25.5006ZM27.6174 7.58471C29.7212 10.8083 31.1939 14.3274 32.0417 18.0652H18.9623C19.808 14.3337 21.2787 10.8126 23.3845 7.58471C24.0773 7.50396 24.7806 7.43809 25.501 7.43809C26.2214 7.43809 26.9247 7.50396 27.6174 7.58471ZM20.5859 8.11596C18.7988 11.227 17.5195 14.559 16.7779 18.0652H9.08955C11.2783 13.1841 15.4646 9.55034 20.5859 8.11596ZM8.2609 20.1902H16.3911C16.117 21.9434 15.9406 23.7198 15.9406 25.5006C15.9406 27.2856 16.117 29.0642 16.3932 30.8152H8.26505C7.72955 29.1089 7.44055 27.3281 7.44055 25.5006C7.43843 23.6752 7.7254 21.8987 8.2609 20.1902ZM9.09383 32.9402H16.782C17.5258 36.4486 18.803 39.7784 20.588 42.8831C15.4688 41.4508 11.2868 37.8214 9.09383 32.9402ZM23.3845 43.4143C21.2808 40.1907 19.8102 36.6739 18.9623 32.9402H32.0397C31.1939 36.6717 29.7212 40.1886 27.6174 43.4143C26.2234 43.5758 24.7785 43.5758 23.3845 43.4143ZM30.4161 42.8852C32.2011 39.7785 33.4804 36.4465 34.222 32.9424H41.9102C39.7193 37.8192 35.5352 41.4508 30.4161 42.8852ZM42.739 30.8152H34.6108C34.8871 29.06 35.0635 27.2813 35.0635 25.5006C35.0635 23.7177 34.8872 21.9412 34.613 20.1902H42.7411C43.2766 21.8945 43.5635 23.6731 43.5635 25.5006C43.5635 27.326 43.2766 29.1067 42.739 30.8152Z" fill="white"/>
                </svg>
            </a>
            <a title="Cerrar Sesion" class="option" href="../../private/modules/logout.php">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.75 21.25L21.25 29.75" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M29.75 29.75L21.25 21.25" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M45.1562 25.5C45.1562 14.6442 36.3558 5.84375 25.5 5.84375C14.6442 5.84375 5.84375 14.6442 5.84375 25.5C5.84375 36.3558 14.6442 45.1562 25.5 45.1562C36.3558 45.1562 45.1562 36.3558 45.1562 25.5Z" stroke="white" stroke-width="1.5"/>
                </svg>
            </a>
            <div title="Cerrar Menu" id="closeArrow">
                <svg width="51" height="51" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="27" cy="27" r="27" transform="rotate(180 27 27)" fill="white"/>
                    <path d="M15.7083 26.3172L22.2122 34.6083M38.8333 26.3172L15.7083 26.3172L38.8333 26.3172ZM15.7083 26.3172L22.2122 18.7917L15.7083 26.3172Z" stroke="#1E1F25" stroke-width="2.31094" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </aside>
        <section class="container-xxl">
            <p id="alert"></p>
            <div id="mainContent" class="row container-fluid">
                <h1>Inscriptos</h1>
                <div id="leftSide" class="col-12 col-lg-5 col-xl-4">
                    <div id="box1" class="box">
                        <h2>Ver inscriptos</h2>
                        <form id="viewForm" spellcheck="false">
                            <select id="selectInscription">
                                <?php $sql = "SELECT * FROM `pendingcompetitions` ORDER BY `pendingcompetitions`.`date` ASC limit 10";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()){ ?>
                                <option name="selection" value="<?php echo($row['ID_competition'])?>"><?php echo($row['name'])?></option>
                                <?php } ?>
                            </select>
                            <button type="button" onclick="selectCompetition()">Aceptar</button>
                        </form>  
                    </div>
                    <div id="boxedContainer">
                        <div id="boxedContainerAux">
                            <?php
                            if(isset($_COOKIE['mainCompetitionInscriptions'])){
                                $sql = "select disciplines.name, events.time from inscriptions
                                left join events on inscriptions.ID_event = events.ID_event
                                left join disciplines on events.ID_discipline = disciplines.ID_discipline
                                where events.ID_competition = " . $_COOKIE['mainCompetitionInscriptions'] . " and inscriptions.ID_athlete = " . $user['ID_athlete'];
                            }else{
                                $sql = "select disciplines.name, events.time from inscriptions
                                left join events on inscriptions.ID_event = events.ID_event
                                left join disciplines on events.ID_discipline = disciplines.ID_discipline
                                where events.ID_competition = " . $mainCompetition . " and inscriptions.ID_athlete = " . $user['ID_athlete'];
                            }
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()){ ?>   

                            <div class="boxed">
                                <div>
                                    <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M35.4375 7.21875H27.5625C25.0254 7.21875 22.9688 9.27544 22.9688 11.8125C22.9688 14.3496 25.0254 16.4062 27.5625 16.4062H35.4375C37.9746 16.4062 40.0312 14.3496 40.0312 11.8125C40.0312 9.27544 37.9746 7.21875 35.4375 7.21875Z" stroke="#6597FF" stroke-width="1.5"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.122 10.5869C21.0419 11.0089 21 11.4445 21 11.8898C21 12.8176 21.1818 13.7029 21.5118 14.512C20.1165 14.5623 18.924 14.6463 17.8783 14.7869C15.4556 15.1126 14.4188 15.6756 13.7346 16.3597C13.0505 17.0439 12.4875 18.0807 12.1618 20.5034C11.8209 23.0393 11.8125 26.4391 11.8125 31.5001V36.7501C11.8125 41.8111 11.8209 45.2107 12.1618 47.7467C12.4875 50.1693 13.0505 51.2062 13.7346 51.8906C14.4188 52.5746 15.4556 53.1377 17.8783 53.4632C20.4143 53.8042 23.8139 53.8126 28.875 53.8126H34.125C39.186 53.8126 42.5856 53.8042 45.1216 53.4632C47.5443 53.1377 48.5811 52.5746 49.2655 51.8906C49.9495 51.2062 50.5123 50.1693 50.8381 47.7467C51.1791 45.2107 51.1875 41.8111 51.1875 36.7501V31.5001C51.1875 26.4391 51.1791 23.0393 50.8381 20.5034C50.5123 18.0807 49.9495 17.0439 49.2655 16.3597C48.5811 15.6756 47.5443 15.1126 45.1216 14.7869C44.0761 14.6463 42.8836 14.5623 41.4881 14.512C41.8181 13.7029 42 12.8176 42 11.8898C42 11.4445 41.958 11.0089 41.8779 10.5869C46.8649 10.7852 49.9107 11.4365 52.0495 13.5755C55.125 16.6508 55.125 21.6006 55.125 31.5001V36.7501C55.125 46.6495 55.125 51.5994 52.0495 54.6746C48.9744 57.7501 44.0244 57.7501 34.125 57.7501H28.875C18.9755 57.7501 14.0258 57.7501 10.9504 54.6746C7.875 51.5994 7.875 46.6495 7.875 36.7501V31.5001C7.875 21.6006 7.875 16.6508 10.9504 13.5755C13.0893 11.4365 16.135 10.7852 21.122 10.5869Z" fill="#6597FF"/>
                                        <path d="M26.25 35.4375L30.1875 39.375L38.0625 31.5" stroke="#6597FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="boxed1">
                                    <p class="boxedEvent"><?php echo($row['name']);?></p>
                                    <p class="boxedTime"><?php echo($row['time']);?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div id="rightSide" class="col-12 col-lg-7 col-xl-8">
                    <div id="box3" class="box">
                        <h2>Resultados de busqueda</h2>
                        <div id="box3MainContent">
                            <div id="results">
                            <?php
                                if(isset($_COOKIE['mainCompetitionInscriptions'])){
                                    $sql = "select events.ID_event, events.gender, date_format(time,'%H:%i') as `startTime`, disciplines.name, disciplines.maxHeat, disciplines.minHeat, disciplines.category, count(inscriptions.ID_inscription) as 'inscriptions' from events left join disciplines on disciplines.ID_discipline = events.ID_discipline left join inscriptions on inscriptions.ID_event = events.ID_event where ID_competition = " . $_COOKIE['mainCompetitionInscriptions'] . " group by events.ID_event order by events.time ASC";
                                }else{
                                    $sql = "select events.ID_event, events.gender, date_format(time,'%H:%i') as `startTime`, disciplines.name, disciplines.maxHeat, disciplines.minHeat, disciplines.category, count(inscriptions.ID_inscription) as 'inscriptions' from events left join disciplines on disciplines.ID_discipline = events.ID_discipline left join inscriptions on inscriptions.ID_event = events.ID_event where ID_competition = " . $mainCompetition . " group by events.ID_event order by events.time ASC";
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
                                            <p><?php echo($row['inscriptions'])?></p>
                                        </div>
                                        <div class="resultItemOpen collapse" id="result<?php echo($row['ID_event']);?>">
                                            <div class="auxiliar">
                                                <?php if($row['inscriptions'] > 0){
                                                $initialAux = 0;
                                                $heatsAmount = array();
                                                // discipline.category => individual track lane
                                                if($row['category'] == 0){
                                                    if($row['inscriptions'] > $row['maxHeat']){
                                                        $operation = $row['inscriptions'] / $row['maxHeat'];
                                                        if($operation < 2 && $operation > 1){
                                                            $heatsAmount = [intdiv($row['inscriptions'], 2) + $row['inscriptions'] - intdiv($row['inscriptions'], 2) * 2, intdiv($row['inscriptions'], 2)];
                                                        }if($operation >= 2){
                                                            while($row['inscriptions'] > 0){
                                                                if($row['inscriptions'] - 8 >= 0){
                                                                    array_push($heatsAmount, 8);
                                                                    $row['inscriptions'] -= 8;
                                                                }else{
                                                                    array_push($heatsAmount, $row['inscriptions']);
                                                                    $row['inscriptions'] = 0;
                                                                }
                                                            }
                                                            for($i = count($heatsAmount) - 1; $i >= 0; $i--){
                                                                if($heatsAmount[$i] < 6){
                                                                    while($heatsAmount[$i] < 6){
                                                                    $heatsAmount[$i - 1] -= 1;
                                                                    $heatsAmount[$i] += 1;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        $heatsAmount = [$row['inscriptions']];
                                                    }
                                                }

                                                for($i = 0; $i < count($heatsAmount); $i++){
                                                    echo "<h5>Serie " . $i + 1 . "</h5>";
                                                    echo "<div class='listResults'>
                                                            <table>
                                                                <tr>
                                                                    <th>N°</th>
                                                                    <th>Nombre</th>
                                                                    <th>Año</th>
                                                                    <th>Club</th>
                                                                    <th class='d-none d-md-table-cell'>Fed.</th>
                                                                    <th class='d-none d-md-table-cell'>Pais</th>
                                                                </tr>";
                                                    $heatQuery = "select inscriptions.record, athletes.name, athletes.ID_athlete, year(athletes.born) as 'year', clubs.resumed as 'club', federation.resumed as 'federation', countrys.resumed as 'country'
                                                    from inscriptions 
                                                    left join athletes on inscriptions.ID_athlete = athletes.ID_athlete
                                                    left join clubs on athletes.ID_club = clubs.ID_club 
                                                    left join federation on athletes.ID_federation = federation.ID_federation 
                                                    left join countrys on athletes.ID_country = countrys.ID_country 
                                                    where inscriptions.ID_event = " . $row['ID_event'] . " order by -inscriptions.record DESC limit $initialAux, " . $heatsAmount[$i];
                                                    $heatsResult = $conn->query($heatQuery);

                                                    $reference = array(4,5,3,6,2,7,1,8);
                                                    $outputAux = array();
                                                    $heatsAux = 0;

                                                    while($heat = $heatsResult->fetch_assoc()){
                                                        if($heat['ID_athlete'] != $user['ID_athlete']){
                                                            $outputAux[$reference[$heatsAux]] = "<tr>
                                                                                                    <td class='listNumber'>$reference[$heatsAux]</td>
                                                                                                    <td>".$heat['name']."</td>
                                                                                                    <td>".$heat['year']."</td>
                                                                                                    <td>".$heat['club']."</td>
                                                                                                    <td class='d-none d-md-table-cell'>".$heat['federation']."</td>
                                                                                                    <td class='d-none d-md-table-cell'>".$heat['country']."</td>
                                                                                                </tr>";
                                                        }else{
                                                            $outputAux[$reference[$heatsAux]] = "<tr>
                                                                                                    <td class='listNumber' style='color:#08ffff'>$reference[$heatsAux]</td>
                                                                                                    <td style='color:#08ffff'>".$heat['name']."</td>
                                                                                                    <td style='color:#08ffff'>".$heat['year']."</td>
                                                                                                    <td style='color:#08ffff'>".$heat['club']."</td>
                                                                                                    <td class='d-none d-md-table-cell' style='color:#08ffff'>".$heat['federation']."</td>
                                                                                                    <td class='d-none d-md-table-cell' style='color:#08ffff'>".$heat['country']."</td>
                                                                                                </tr>";
                                                        }
                                                        
                                                        $heatsAux++;
                                                    }

                                                    ksort($outputAux);
                                                    foreach($outputAux as $x => $value){
                                                        echo($value);
                                                    }
                                                    echo "</table>
                                                    </div>";
                                                    $initialAux += $heatsAmount[$i];
                                                }
                                                }else{
                                                    echo("<p class='inscriptionIndicator'>Aun no hay inscriptos</p>");
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
        </section>
    </main>

    <script><?php include('../../public/resources/js/inscribedP.js');?></script>
    <?php include('../../public/pages/footer.html'); ?>