<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ParkIt Website</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">     -->
    <!-- <link rel = "stylesheet" type = "text/css" href = "css/button.css" /> -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

    <script src="js/Availability_Rates.js"></script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANb9cN9YpefAqmMZHzu04StSIPIi6fvRA&callback=initMap&libraries=&v=weekly" defer></script>

    <script>
        header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP/1.1
    </script>

    <?php
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: loginpage.php');
        }
    ?>
    
    <style>
        /* The popup bubble styling. */
        .popup-bubble {
            /* Position the bubble centred-above its parent. */
            position: absolute;
            top: 0;
            left: 0;
            transform: translate(-50%, -100%);
            /* Style the bubble. */
            background-color: white;
            border: 5px white solid;
            padding: 5px;
            border-radius: 5px;
            font-family: sans-serif;
            overflow-y: auto;
            max-height: 60px;
            box-shadow: 0px 2px 10px 1px rgba(0, 0, 0, 0.5);
        }

        /* The parent of the bubble. A zero-height div at the top of the tip. */
        .popup-bubble-anchor {
            /* Position the div a fixed distance above the tip. */
            position: absolute;
            width: 100%;
            bottom: 8px;
            left: 0;
        }

        /* This element draws the tip. */
        .popup-bubble-anchor::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            /* Center the tip horizontally. */
            transform: translate(-50%, 0);
            /* The tip is a https://css-tricks.com/snippets/css/css-triangle/ */
            width: 0;
            height: 0;
            /* The tip is 8px high, and 12px wide. */
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid white;
        }

        /* JavaScript will position this div at the bottom of the popup tip. */
        .popup-container {
            cursor: auto;
            height: 0;
            position: absolute;
            /* The max width of the info window. */
            width: 200px;
        }

        #images {
            text-align: center;
        }
        
        /* .dropdown{
            width: 250px;
            height: 200px;
        } */
        
        .card{
            margin-top: 30px;
        }
        
        .frame{
        
            width: 100%;
            height: 100%;
            background: black;
            margin-top: 20px;
            padding: 5px 5px;
        
        }
        
        #map {
            height: 100vh;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
        
        @media screen and (max-width: 2000px) {
        #deets {
            padding-top: 82px;
        }
        }

        /* On screens that are 600px wide or less, the background color is olive */
        @media screen and (max-width: 992px) {
        #deets {
            padding-top: 0px;
        }
        }
        
    </style>
        


</head>

<body onload='static_rates()'>



<!-- Navigation -->
<?php require_once 'navbarbar.html'?>



<div class='container-fluid' style='padding:0px;'>
    <div id='carpark' class='row mx-0' style='height:100vh; z-index: -1; width: 100vw' >
        <div class='col-md-12 col-lg col-sm-12 col-12' style='padding:0px;' >
            <div id="map" style='height:100%; min-height: 500px'></div>
            <div id="allLocations"></div>
        </div>

        <div class='col-lg-5 col-md-12 col-sm-12 col-12' style='padding: 0px 0px 0px 0px; display:none;' id='deets'></div>
        
        

    </div>
    
</div>

<script>
    console.log(document.getElementById('allLocations'))
    console.log(document.getElementById('deets').innerText)
</script>








<script>
    var long_des = "";
    var lat_des = ""; 
    function getLocation(desired){
    // var address = pos.lat + "," + pos.lng;
    // carpark_name_arr = ['orchard road singapore']
    //console.log(carpark_name_array);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200) {
                var data = JSON.parse(this.responseText);
                var long_des = data['results'][0]['geometry']['location']['lng'];
                var lat_des = data['results'][0]['geometry']['location']['lat'];
                // postCode = getPostalCode(data);
                long_des= JSON.stringify(long_des);
                lat_des = JSON.stringify(lat_des);
                // console.log(lat_des, long_des);
                localStorage.setItem("long_des" ,long_des);
                localStorage.setItem("lat_des" ,lat_des);
                
            }
            

        }
        url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + desired + "&key=AIzaSyANb9cN9YpefAqmMZHzu04StSIPIi6fvRA";
        request.open("GET", url, false);
        request.send();
        
    }
    
    addEventListener('load', getAvailability);
    addEventListener('load', function(){
        var desired = localStorage.getItem("desired");
        console.log(desired);
        getLocation(desired);
        var long = parseFloat(localStorage.getItem("long_des"));
        var lati = parseFloat(localStorage.getItem("lat_des"));

        console.log(parseFloat(long),parseFloat(lati));
        // var long = 103.819; var lati=1.3521;
        initMap(long, lati);
    });


    let map, infoWindow, popup, Popup;

    function initMap(long, lati) {

        var availability_obj = JSON.parse( localStorage.getItem("availability_obj") );

        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 1.3521, lng: 103.8198 },
            zoom: 18,
        });
        infoWindow = new google.maps.InfoWindow();

        // indicate our location of interest
        var pos = {
                    lat: lati ,
                    lng: long
                };
                // get postal code of given lat, lng
        // getLocation(pos);

        infoWindow.setPosition(pos);
        infoWindow.setContent("Desired Location");
        infoWindow.open(map);
        map.setCenter(pos);

        new google.maps.Marker({
            position: {lat: lati, lng: long},
            map
        });
        //  popup icon 
        class Popup extends google.maps.OverlayView {
          constructor(position, content) {
            super();
            this.position = position;
            content.classList.add("popup-bubble");
            // This zero-height div is positioned at the bottom of the bubble.
            const bubbleAnchor = document.createElement("div");
            bubbleAnchor.classList.add("popup-bubble-anchor");
            bubbleAnchor.appendChild(content);
            // This zero-height div is positioned at the bottom of the tip.
            this.containerDiv = document.createElement("div");
            this.containerDiv.classList.add("popup-container");
            this.containerDiv.appendChild(bubbleAnchor);
            // Optionally stop clicks, etc., from bubbling up to the map.
            Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
          }
          /** Called when the popup is added to the map. */
          onAdd() {
            this.getPanes().floatPane.appendChild(this.containerDiv);
          }
          /** Called when the popup is removed from the map. */
          onRemove() {
            if (this.containerDiv.parentElement) {
              this.containerDiv.parentElement.removeChild(this.containerDiv);
            }
          }
          /** Called each frame when the popup needs to draw itself. */
          draw() {
            const divPosition = this.getProjection().fromLatLngToDivPixel(
              this.position
            );
            // Hide the popup when it is far out of view.
            const display =
              Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000
                ? "block"
                : "none";

            if (display === "block") {
              this.containerDiv.style.left = divPosition.x + "px";
              this.containerDiv.style.top = divPosition.y + "px";
            }

            if (this.containerDiv.style.display !== display) {
              this.containerDiv.style.display = display;
            }
          }
        }
        // setting up of marker on destination

        //console.log(availability_obj);
        //for this, it is looping through the 500 from datamall not the 423 that we filtered out
        var count1 =0;
        var AR_arr = JSON.parse(localStorage.getItem('rates_avail_arr'))
        
        all_obj = AR_arr.value;
        console.log(all_obj);
        // for(i=0; i< all_obj.length; i++){
        for (objj of all_obj) {
            // console.log(obj);
            count1++;
            var location = objj["Location"];
            //console.log(location);
            location = location.split(' ');
            let color = ''
            let font = ''
            if (objj['AvailableLots'].Cars<15) {
                color = '#ED3E15'; 
                font ='color: white;'               
            }
            else if (objj['AvailableLots'].Cars<50) {
                color = '#FCA106';                
            }
            else {
                color = '#C3D61B';                
            }

            document.getElementById('allLocations').innerHTML += '<h5 onclick="display_selected('+count1+')" style="background-color:' + color + '; '+font+' cursor: pointer;" class="hehe">'+objj['AvailableLots'].Cars+'</h5>'
            
            document.getElementsByClassName('hehe')
            var obj_lat = Number(location[0]);
            var obj_lng = Number(location[1]);
            var desti = { lat: obj_lat , lng: obj_lng };
            //console.log(document.getElementById('content'))

            popup = new Popup(
            new google.maps.LatLng(obj_lat, obj_lng),document.getElementsByClassName('hehe')[document.getElementsByClassName('hehe').length-1]);
            popup.setMap(map);
            // new google.maps.Marker({
            // position: desti,
            // map: map,
            // });

            // popup.addListener(("bounds_changed", showNewRect));
        }
            

    }


    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
        browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your Browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }
    
    
    



</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


</body>
</html>