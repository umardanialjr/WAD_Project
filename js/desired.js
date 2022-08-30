
// var carpark_arr= [];
// function carpark_name_array(){

//     var request = new XMLHttpRequest();

//     request.onreadystatechange = function () {
        
//         if (this.readyState == 4 && this.status==200) {

//             var response_json = JSON.parse(this.responseText);

//             var data = response_json.result.records;

//             //console.log(data);

//             //console.log("=====================================");


            
//             for (var i=0; i<data.length; i++) {
//                 var carpark_name = data[i].carpark + " Singapore";
                
//                 //console.log( carpark_name + " | " + sat_rate + " | " + sun_ph_rate + " | " + weekday1_rate + " | " + weekday2_rate);
//                 //console.log("==========================================");
//                 carpark_array.push(carpark_name);

//             }
            
            
//             // console.log(carpark_name_array);

//             // document.getElementById("showCarparkNames").innerText = carpark_name_array;
//             //  gettomg tje [psta; ]
//             getLocation(carpark_name_array);

//         }
//     }

//     var url = "https://data.gov.sg/api/action/datastore_search?resource_id=85207289-6ae7-4a56-9066-e6090a3684a5&limit=357";
//     request.open("GET", url, true);
//     request.send();
    


//     } 

var desired = "";
function desired_location(desired){
    //desired = document.getElementById('address').value;
    //console.log(desired);
    localStorage.setItem("desired" ,desired );
    //addtoSearchHistory(desired);
    
}
function desired_fav(favor){
    // desired = document.getElementById('address').value;
    // console.log(desired);
    var locationFavourites = JSON.parse(localStorage.getItem('locationFavourites'));
    //console.log(favor);
    localStorage.setItem("desired", locationFavourites[favor]);
    //console.log('kekke')

}
// const desired_loc = localStorage.getItem("desired");
// const API = "AIzaSyCQpZNQAOiqGNbBNpWTbLq6Du7gsWcEUJI";

// var desired = localStorage.getItem("desired");
// console.log(desired);


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
    url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + desired + "&key= AIzaSyANb9cN9YpefAqmMZHzu04StSIPIi6fvRA";
    request.open("GET", url, true);
    request.send();
    // for(carpark of carpark_name_arr){
    // }
    
}
function use_desired(){
    var desired = localStorage.getItem("desired");
    console.log(desired);
    getLocation(desired);
    var long = parseFloat(localStorage.getItem("long_des"));
    var lati = parseFloat(localStorage.getItem("lat_des"));

    console.log(parseFloat(long),parseFloat(lati));
    initMap(long,lati);
    
}


    // show desired location on the map
let map, infoWindow;
function initMap(long, lati) {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 1.3521, lng: 103.8198 },
        zoom: 17,
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

    // setting up of marker on destination 
    var desti = { lat: 1.352802 , lng: 103.944565 };
    const marker = new google.maps.Marker({
    position: desti,
    map: map,
    });
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


// addEventListener('load', initMap);
    
    
    // getLocation();

    

        
    // var distances = [];
    // // direction function
    // function directions_destination() {
    //     // carpark array 
    //     for (each_carpark of carpark_array){
    //         // console.log(carpark_near);
    //         var request= new XMLHttpRequest();
            
    //         request.onreadystatechange = function() {
    //             if(this.readyState == 4 && this.status == 200){
    //                 respond_json = JSON.parse(this.responseText);
    //                 // console.log(respond_json);
    //                 // distance to destination 
                    
    //                 // distance from chosen carpark to desired location 
    //                 var total_distance = respond_json['routes'][0]['legs'][0]['distance'].value; // for eg 15196 -> "15.2km"
    //                 // console.log(total_distance);
    //                 // time taken to reach there 
    //                 var total_duration = respond_json['routes'][0]['legs'][0]['duration'].text;
    //                 // var steps_arr = respond_json['routes'][0]['legs'][0]['steps'];
    //                 // console.log(steps_arr);
    //                 // var steps_instructions = [];
    //                 // for( i=0; i< steps_arr.length; i++){
    //                 // steps_instructions.push(steps_arr[i].html_instructions);
    //                 // // console.log(steps_arr[i].html_instructions);
    //                 // }
    //                 // console.log(steps_instructions);
    //                 distances.push(total_distance,total_duration);
                    
                    
                
    //             }
    //     }
    //         // url = `https://maps.googleapis.com/maps/api/directions/json?origin=${carpark} &destination=${desired} &key=${API}`;
    //     url =`https://maps.googleapis.com/maps/api/directions/json?origin=${carpark} &destination=${desired} &mode=walking&key=AIzaSyCQpZNQAOiqGNbBNpWTbLq6Du7gsWcEUJI`;
    //     request.open("GET", url, true);
    //     request.send();

    //     }
        
        
        
    
    // }
    // console.log(distances);}




