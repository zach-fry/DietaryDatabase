<?php include ('/var/www/views/snippets/header.php'); ?>
<section>
    <div id="map_canvas" style="width: 500px; height: 500px;"></div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
    <script type="text/javascript">
        function initialize() {
            var latlng = new google.maps.LatLng(37.869565, -122.258786);
            var myOptions = {zoom: 17, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            var marker = new google.maps.Marker({position: new google.maps.LatLng(37.869565, -122.258786), map: map});
        }

        initialize();
        //alert('finished_initialize');
    </script>

</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>

