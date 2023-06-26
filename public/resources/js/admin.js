const ctx = document.getElementById('mainChart');

var competitionData;
$.ajax({
    url: "modules/competitionsData.php",
    type: "POST",
    success: function($data){
        console.log($data);
        competitionData = JSON.parse($data);
        var labelAuxiliar = [];
        var dataAuxiliar = [];
        for (const [key, value] of Object.entries(competitionData)) {
            labelAuxiliar.push(key);
            dataAuxiliar.push(value);
        }
        const data = {
            
            labels: labelAuxiliar,
            datasets: [
                {
                label: 'Inscriptos',
                data: dataAuxiliar,
                borderColor: '#5B23E3',
                backgroundColor: '#5B23E344',
                pointStyle: 'circle',
                pointRadius: 10,
                pointHoverRadius: 15
                }
            ]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true
                    }
                }
            }
        });
    }
});


const menuIcon = document.getElementById("menuIcon");                                    
const closeArrow = document.getElementById("closeArrow");
const menu = document.getElementById("menu");
menuIcon.addEventListener("click", ()=>{
    menu.classList.add("active");
});
closeArrow.addEventListener("click", ()=>{
    menu.classList.remove("active");
})
