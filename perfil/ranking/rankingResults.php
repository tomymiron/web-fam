<?php
include('../../private/database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(($_POST['viewFormGender'] == 1 or $_POST['viewFormGender'] == 0) && !empty($_POST['viewFormDiscipline'])){
    if($_POST['viewFormGender'] != "null" && $_POST['viewFormCategory'] != "null"){
        $viewFormYear = intval($conn->real_escape_string($_POST['viewFormYear']));
        $viewFormGender = intval($conn->real_escape_string($_POST['viewFormGender']));
        $viewFormCategory = intval($conn->real_escape_string($_POST['viewFormCategory']));
        $viewFormDiscipline = intval($conn->real_escape_string($_POST['viewFormDiscipline']));
        if(is_int($viewFormYear) && is_int($viewFormGender) && is_int($viewFormCategory) && is_int($viewFormDiscipline)){
            $query = "call getRanking(" . $viewFormYear . ", " . $viewFormCategory . ", " . $viewFormGender . ", " . $viewFormDiscipline . ");";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                $flagFirst = true;
                while($row = $result->fetch_assoc()){
                    if($row['campus'] == 0){
                        $resultAuxiliar = $row['result'] . 's';
                    }else{
                        $resultAuxiliar = $row['result'] . 'm';
                    }
                    if($flagFirst){
                        if($row['wind'] == null){
                            $resultOutput = "
                                <table>
                                    <tr>
                                        <th class='rankPlace'>
                                            <svg width='26' height='26' viewBox='0 0 37 37' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M12.1608 4.77686C10.5408 4.77686 9.22754 6.09013 9.22754 7.71012V15.5322C9.22754 20.6529 13.3787 24.804 18.4994 24.804C23.6201 24.804 27.7712 20.6529 27.7712 15.5322V7.71012C27.7712 6.09013 26.4578 4.77686 24.8379 4.77686H12.1608Z' stroke='#2BCCA2' stroke-width='2'/>
                                                <path d='M18.499 25.9165V27.4' stroke='#2BCCA2' stroke-width='2.5' stroke-linecap='round'/>
                                                <path d='M22.9496 28.5127H14.0487C13.0246 28.5127 12.1943 29.3429 12.1943 30.3671C12.1943 31.3912 13.0246 32.2214 14.0487 32.2214H22.9496C23.9738 32.2214 24.804 31.3912 24.804 30.3671C24.804 29.3429 23.9738 28.5127 22.9496 28.5127Z' stroke='#2BCCA2' stroke-width='2'/>
                                                <path d='M8.85668 8.11475C6.80841 8.11475 5.14795 9.7752 5.14795 11.8235V12.3107C5.14795 13.4235 5.59001 14.4908 6.37692 15.2777L9.59842 18.4992' stroke='#2BCCA2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                                <path d='M28.1416 8.11475C30.1899 8.11475 31.8504 9.7752 31.8504 11.8235V12.3107C31.8504 13.4235 31.4083 14.4908 30.6215 15.2777L27.3999 18.4992' stroke='#2BCCA2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                            </svg>
                                        </th>
                                        <th class='rankName'>Nombre</th>
                                        <th class='rankYear'>Año</th>
                                        <th class='rankClub'>Club</th>
                                        <th class='aux rankResult'>Marca</th>
                                    </tr>
                                    ";
                        }else{
                            $resultOutput = "
                                <table>
                                    <tr>
                                        <th class='rankPlace'>
                                            <svg width='26' height='26' viewBox='0 0 37 37' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M12.1608 4.77686C10.5408 4.77686 9.22754 6.09013 9.22754 7.71012V15.5322C9.22754 20.6529 13.3787 24.804 18.4994 24.804C23.6201 24.804 27.7712 20.6529 27.7712 15.5322V7.71012C27.7712 6.09013 26.4578 4.77686 24.8379 4.77686H12.1608Z' stroke='#2BCCA2' stroke-width='2'/>
                                                <path d='M18.499 25.9165V27.4' stroke='#2BCCA2' stroke-width='2.5' stroke-linecap='round'/>
                                                <path d='M22.9496 28.5127H14.0487C13.0246 28.5127 12.1943 29.3429 12.1943 30.3671C12.1943 31.3912 13.0246 32.2214 14.0487 32.2214H22.9496C23.9738 32.2214 24.804 31.3912 24.804 30.3671C24.804 29.3429 23.9738 28.5127 22.9496 28.5127Z' stroke='#2BCCA2' stroke-width='2'/>
                                                <path d='M8.85668 8.11475C6.80841 8.11475 5.14795 9.7752 5.14795 11.8235V12.3107C5.14795 13.4235 5.59001 14.4908 6.37692 15.2777L9.59842 18.4992' stroke='#2BCCA2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                                <path d='M28.1416 8.11475C30.1899 8.11475 31.8504 9.7752 31.8504 11.8235V12.3107C31.8504 13.4235 31.4083 14.4908 30.6215 15.2777L27.3999 18.4992' stroke='#2BCCA2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                            </svg>
                                        </th>
                                        <th class='rankName'>Nombre</th>
                                        <th class='rankYear'>Año</th>
                                        <th class='rankClub'>Club</th>
                                        <th class='aux rankWind'>Viento</th>
                                        <th class='aux rankResult'>Marca</th>
                                    </tr>
                                    ";
                        }
                        $flagFirst = false;
                    }
                    if($row['wind'] == null){
                        $resultOutput .= "
                        <tr class='rankTableItemMain' data-bs-toggle='collapse' data-bs-target='#rankTableItem" . $row['ID_athlete'] . "'>
                            <td class='rankPlace'>" . $row['rank'] . "</td>
                            <td class='rankName'>" . $row['name'] . "</td>
                            <td class='rankYear'>" . $row['year'] . "</td>
                            <td class='rankClub'>" . $row['club'] . "</td>
                            <td class='aux rankResult'>" . $resultAuxiliar . "</td>
                        </tr>
                        <tr>
                            <td colspan='10'>
                                <div class='rankTableItemOpen collapse' id='rankTableItem" . $row['ID_athlete'] . "'>
                                    <div>
                                        <div>
                                            <p><b>Fecha: </b>" . $row['date'] . "</p>
                                            <p><b>Lugar: </b>" . $row['place'] . "</p>
                                        </div>
                                        <button>Ver perfil</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        ";
                    }else{
                        $resultOutput .= "
                        <tr class='rankTableItemMain' data-bs-toggle='collapse' data-bs-target='#rankTableItem" . $row['ID_athlete'] . "'>
                            <td class='rankPlace'>" . $row['rank'] . "</td>
                            <td class='rankName'>" . $row['name'] . "</td>
                            <td class='rankYear'>" . $row['year'] . "</td>
                            <td class='rankClub'>" . $row['club'] . "</td>
                            <td class='aux rankWind'>" . $row['wind'] . "</td>
                            <td class='aux rankResult'>" . $resultAuxiliar . "</td>
                        </tr>
                        <tr>
                            <td colspan='10'>
                                <div class='rankTableItemOpen collapse' id='rankTableItem" . $row['ID_athlete'] . "'>
                                    <div>
                                        <div>
                                            <p><b>Fecha: </b>" . $row['date'] . "</p>
                                            <p><b>Lugar: </b>" . $row['place'] . "</p>
                                        </div>
                                        <button>Ver perfil</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        ";
                    }
                }
    
                $resultOutput .= "</table>";
            }else{
                $resultOutput = "<h3>No se encontraron resultados</h3>";
            }
            echo $resultOutput;
        }else{
            echo "<h3>Ocurrio un error!</h3>";
        }
    }
}else{
    echo "<h3>Completa todos los campos!</h3>";
}
$conn->close();
?>  