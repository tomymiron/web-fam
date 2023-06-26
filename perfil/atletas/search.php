<?php
include('../../private/database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name = $conn->real_escape_string($_POST['name']);
$results = '';
$query = "select athletes.ID_athlete, athletes.name, clubs.resumed as 'club', images.image from athletes left join clubs on clubs.ID_club = athletes.ID_club left join images on images.ID_athlete = athletes.ID_athlete where athletes.dni > 5000 and athletes.name like '%$name%' order by athletes.name ASC limit 21;";
$result = $conn->query($query);
while($row = $result->fetch_assoc()){
    if($row['image'] == NULL){
        $imageAux = "<svg width='104' height='104' viewBox='0 0 104 104' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M66.0832 26.0001C66.0832 33.7781 59.7777 40.0834 51.9998 40.0834C44.2219 40.0834 37.9165 33.7781 37.9165 26.0001C37.9165 18.2221 44.2219 11.9167 51.9998 11.9167C59.7777 11.9167 66.0832 18.2221 66.0832 26.0001Z' stroke='#36B9CC' stroke-width='4'/>
                        <path d='M79.0832 73.6667C79.0832 78.3276 76.4437 82.8542 71.5596 86.3425C66.682 89.827 59.7769 92.0833 51.9998 92.0833C44.2228 92.0833 37.3177 89.827 32.4399 86.3425C27.556 82.8542 24.9165 78.3276 24.9165 73.6667C24.9165 69.0057 27.556 64.4791 32.4399 60.9908C37.3177 57.5064 44.2228 55.25 51.9998 55.25C59.7769 55.25 66.682 57.5064 71.5596 60.9908C76.4437 64.4791 79.0832 69.0057 79.0832 73.6667Z' stroke='#36B9CC' stroke-width='4'/>
                    </svg>";
    }else{
        $imageAux = "<img src='data:image/png;base64,". base64_encode($row['image']). "' />";
    }
    $results .= "
        <button type='submit' name='user' value='" . $row['ID_athlete'] . "' class='athleteItem col-6 col-sm-4 col-lg-3 col-xl-2'>
            <div class='athleteItemContainer'>
                <div class='athletePhoto'>
                    $imageAux
                </div>
                <p class='athleteClub'>" . $row['club'] . "</p>
                <p class='athleteName'>" . $row['name'] . "</p>
            </div>
        </button>
        ";
}
echo $results;