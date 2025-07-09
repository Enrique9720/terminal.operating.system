$(document).ready(function () {

    var donut_chart = Morris.Donut({
        element: 'chart',
        data: 'data'
    });

    $('#like_form').on('submit', function (event) {
        event.preventDefault();
        var checked = $('input[name=framework]:checked', '#like_form').val();
        if (checked == undefined) {
            alert("Please Like any Framework");
            return false;
        } else {
            var form_data = $(this).serialize();
            $.ajax({
                url: "../ajax/estadisticas.php",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function (data) {
                    $('#like_form')[0].reset();
                    donut_chart.setData(data);
                }
            });
        }
    });
});
