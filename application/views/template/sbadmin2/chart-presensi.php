<script>
    var presensi = $('#dataAbsensi').data('flashdata');
    var split = presensi.split('|');
    var myChart = document.getElementById('presensiChart');
    var presensiChart = new Chart(myChart, {
        type: 'pie',
        data: {
            labels: [
                'Hadir',
                'Absen',
                'Izin',
                'Sakit',
                'Cuti',
                'Dinas Luar',
            ],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: [
                    'rgb(92, 184, 92)',
                    'rgb(217, 83, 79)',
                    'rgb(2, 117, 216)',
                    'rgb(91, 192, 222)',
                    'rgb(240, 173, 78)',
                    'rgb(41, 43, 44)'
                ],
                data: [
                    split[0],
                    split[1],
                    split[2],
                    split[3],
                    split[4],
                    split[5],
                ],
            }]
        },
        options: {}
    });
</script>