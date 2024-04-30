<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets_f/lib/chart/chart.min.js') }}"></script>
<script src="{{ asset('assets_f/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="https://kit.fontawesome.com/c7890550ed.js" crossorigin="anonymous"></script>
<!-- Template Javascript -->
<script src="{{ asset('assets_f/js/main.js') }}"></script>
<!-- line-chart -->
<script>
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "line",
        data: {
            labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(0, 156, 255, .3)",
                data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
<!-- line-chart -->
