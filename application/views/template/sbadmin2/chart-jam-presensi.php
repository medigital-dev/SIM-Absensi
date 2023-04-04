<script>
    var jamDatang = $('#jamDatang').data('flashdata');
    var splitJamDatang = jamDatang.split('|');
    var jamPulang = $('#jamPulang').data('flashdata');
    var splitJamPulang = jamPulang.split('|');
    var jamHadir = $('#jamHadir').data('flashdata');
    var splitJamHadir = jamHadir.split('|');
    const label = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
    var myChart = document.getElementById('chartJam');
    var chartJam = new Chart(myChart, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                    label: 'Jam Datang',
                    borderColor: 'rgb(2, 117, 216)',
                    backgroundColor: 'rgb(2, 117, 216)',
                    data: splitJamDatang,
                },
                {
                    label: 'Jam Pulang',
                    borderColor: 'rgb(92, 184, 92)',
                    backgroundColor: 'rgb(92, 184, 92)',
                    data: splitJamPulang,
                },
                {
                    label: 'Jumlah Jam Kehadiran',
                    borderColor: 'rgb(240, 173, 78)',
                    backgroundColor: 'rgb(240, 173, 78)',
                    data: splitJamHadir,
                }
            ],
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Jam Kehadiran'
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 24
                    }
                }
            }
        }
    });
</script>