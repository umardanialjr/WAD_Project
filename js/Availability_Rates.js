const API = "AIzaSyANb9cN9YpefAqmMZHzu04StSIPIi6fvRA";

var rates_avail_arr = [];
function getRatesAndAvailability(availability_obj,rates_obj) {
    //console.log(rates_obj);
    var current_avail_parking = availability_obj.value;
    var rates_arr = rates_obj;
    var obj = [];
    var rates_avail_arr = {'value': []}
    for (info_obj of current_avail_parking) {
        //var location_avail = info_obj['Location'];
        //location_avail = location_avail.split(' ');
        //console.log(location);
        var development = info_obj['Development'];
        //console.log(development);
        var type = info_obj['LotType'];
        var avail_lots = info_obj['AvailableLots'];
        //console.log(type);
        if (type =='C') {
            //console.log('check');
            
            var count = 0;
            for (i in obj) {
                count++
            }
            if (count > 0) {
                //console.log('kjbgihsrvbg')
                rates_avail_arr.value.push(obj); 
                //console.log('check');
            }
            obj = {}
            obj['Location'] = info_obj['Location'];
            obj['Development'] = development;
            //obj['Location'] = location_avail;
            //console.log(type);
            obj['AvailableLots'] = {"Cars": avail_lots};
            //assumed standard
            //obj['Rates'] = {'Saturday' : 'XXX$0.60 per half-hour', 'Sunday and Public Holiday' : 'XXX$0.60 per half-hour', 'Monday to Friday (7am to 10pm)': 'XXX$0.60 per half-hour', 'Monday to Friday (10pm to 7am)': 'XXX$0.60 per half-hour'};
            //display_carpark(rates_avail_arr);
            //console.log(location);
            
            //console.log(rates_array);
            //console.log(rates_arr.length)
            obj['Rates'] = {};
            if (development.split(' ')[0]=='BLK') {
                obj['Rates'] = {'Saturday' : '$0.60 per ½ hr', 'Sunday and Public Holiday' : '7am-10pm: No charges', 'Weekdays': ['7am-1030pm: $0.60 per ½ hr', '1030pm-7am: $0.60 per ½ hr, capped at $5']};
            }

            else {
                for (carparks of rates_arr) {
                    //console.log(carpark);
                    //console.log(carparks.carpark+","+development)
                    //console.log(carparks.carpark.includes(development));
                    //console.log(development.includes(carparks.carpark));
                    let name = carparks.carpark
                    //console.log(development.includes(name));
    
                    if (carparks.carpark==development || name.toLowerCase().includes(development.toLowerCase()) || development.toLowerCase().includes(name.toLowerCase())) {
                        //console.log('heyyy')
                        var sat_rate = carparks.saturday_rate;
                        var sun_ph_rate = carparks.sunday_publicholiday_rate;
                        var weekday1_rate = carparks.weekdays_rate_1;
                        var weekday2_rate = carparks.weekdays_rate_2;
                        obj['Rates'] = {'Saturday' : sat_rate, 'Sunday and Public Holiday' : sun_ph_rate, 'Weekdays': [weekday1_rate, weekday2_rate]}
                        //display_carpark(rates_avail_arr);
                        //console.log('-----------rates--------------')
                        //console.log(obj)
                    }
    
    
                }
                //console.log(obj);
            }
            


        }

    }
    console.log(rates_avail_arr);
    localStorage.setItem("rates_avail_arr", JSON.stringify(rates_avail_arr));

}




function getAvailability() {
    // Step 1
    static_rates();
    var request = new XMLHttpRequest(); // Prep to make an HTTP request
 
    // Step 2
    request.onreadystatechange = function() {

        if( this.readyState == 4 && this.status == 200 ) {
            
            // Step 5
            var availability_json = JSON.parse(this.responseText); 
            //console.log(availability_json);
            localStorage.setItem("availability_obj",JSON.stringify(availability_json) );


                //call api
                getRatesAndAvailability(availability_json,RatesStatic);
            
            
            
            
        }

    }

    // Step 3

    var url = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailabilityv2";
    var queryUrl = 'https://cors-anywhere.herokuapp.com/' + url;

    //console.log(queryUrl);
    
    
    request.open("GET", queryUrl, true);
    request.setRequestHeader('AccountKey', 'pTiKzS/FTfCGZVMikOKcqg==');

    request.send();
    
}

var RatesStatic = [];
var rate_array = [];
var rate_records;

function static_rates() {
    //console.log('check')
    var request = new XMLHttpRequest();
            
    request.onreadystatechange = function () {
        
        if (this.readyState == 4 && this.status==200) {
            //console.log('check');
            var rates_json = JSON.parse(this.responseText);
            //console.log(rates_json);
            rate_records = rates_json.result.records;
            //var rate_array = [];
            console.log(rate_records.length);
            //var check = true;
            for (carparks of rate_records) {
                //console.log(carparks.carpark);
                getLongLat(carparks); 

            }
            //RatesStatic = rate_records;
            //console.log(rate_array);
            //console.log(RatesStatic);
        
        }
        



            


    }

    var url = "https://data.gov.sg/api/action/datastore_search?resource_id=85207289-6ae7-4a56-9066-e6090a3684a5&limit=357";
    request.open("GET", url, true);

    request.send();
}
/** not used */
function getLongLat(carpark_obj) {
    rate_array = [];
    ratesStatic = [];
    var  carparks = carpark_obj;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(this.readyState == 4 && this.status==200) {
            var data = JSON.parse(this.responseText);
            //console.log(data);
            if (data.status !== 'OVER_QUERY_LIMIT') {
                var long = data['results'][0]['geometry']['location']['lng'];
                var lat = data['results'][0]['geometry']['location']['lat'];
                // postCode = getPostalCode(data);
                //console.log(lat, long);
                carparks['location'] = [long, lat];
                //console.log(long, lat);
                //console.log(rate_records);
                //console.log(rate_array);
                //console.log(carparks)
                rate_array.push(carparks);
            }

            else {
                carparks['location'] = 'undefined';
                //console.log(carparks)
                rate_array.push(carparks);
            }

            //console.log(rate_array);
            
            //console.log(rate_array.length);
            if (rate_array.length == rate_records.length) {
                RatesStatic = rate_array;
            }
            //console.log(carpark.carpark);
            

                    
        }
        

    } 
    url = "https://maps.googleapis.com/maps/api/geocode/json?address=Singapore" + carparks.carpark + "&key=" +API;
    request.open("GET", url, true);
    request.send();
}

var steps_instructions = [];
var total_duration ="";
var desired = localStorage.getItem("desired");
function directions_destination(carpark){
    
    // carpark within fitered limits 
    
    // console.log(carpark_near);
    var request= new XMLHttpRequest();
    
    request.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200){
          respond_json = JSON.parse(this.responseText);
          // console.log(respond_json);
          // distance to destination 
          
          // distance from chosen carpark to desired location 
          total_distance = respond_json['routes'][0]['legs'][0]['distance'].value; // for eg 15196 -> "15.2km"
          // console.log(total_distance);
          // time taken to reach there 
          total_duration = respond_json['routes'][0]['legs'][0]['duration'].text;
          var steps_arr = respond_json['routes'][0]['legs'][0]['steps'];
          // console.log(steps_arr);
          
          for( i=0; i< steps_arr.length; i++){
            steps_instructions.push(steps_arr[i].html_instructions);
            // console.log(steps_arr[i].html_instructions);
          }
        //   localStorage.setItem("steps_instructions" ,steps_instructions);
        //   console.log(steps_instructions);
        //   localStorage.setItem("steps_instructions", steps_instructions);
          
        //   localStorage.setItem("steps_instruction" , steps_instructions)
          
        
      }
    }
      // url = `https://maps.googleapis.com/maps/api/directions/json?origin=${carpark} &destination=${desired} &key=${API}`;
    url =`https://cors-anywhere.herokuapp.com/https://maps.googleapis.com/maps/api/directions/json?origin=${carpark}&destination=${desired}&mode=walking&key=` + API;
    request.open("GET", url, false);
    request.send();
    
}

function display_selected(count1) {
    // steps_instructions = localStorage.getItem("steps_instructions");
    // directions_destination(carpark_obj['Location']);
    
    console.log('done')
    var rates_avail_arr = JSON.parse(localStorage.getItem('rates_avail_arr'));
    //console.log(rates_avail_arr);
    carpark_obj =rates_avail_arr.value[count1-1];
    // console.log(carpark_obj['Development']);
    directions_destination(carpark_obj['Location']);
    

    // console.log(steps_instructions);
    var display = '<div style="padding:20px">';
    var development = carpark_obj['Development'];
    var avail_lots = carpark_obj['AvailableLots']["Cars"];
    lotType = carpark_obj['LotType'];
    

    //display += '<div class="card">';
    display += '<h2 class="display-5 my-2" >' + development+ '</h2>';
    //display += '<div class="card-body">';

    display += '<h5 class="display-5 my-2" style="display: inline-block;">Number of available lots</h5>';
    if (avail_lots<15) {
        color = '#ED3E15';                
    }
    else if (avail_lots<50) {
        color = '#DBA13A';                
    }
    else {
        color = '#309343';                
    }

    display += '<h5 class="display-5 my-2" style="float:right; color: ' + color + '">' + avail_lots + '</h5>';


    var rates_arr = carpark_obj['Rates'];
    //display += "<p class='display-5'>Carpark Rates</p>"
    display += '<div class"clearfix"><table class="table">'
    display += '<thead class="thead-dark"><tr><th scope="col" colspan=2>Carpark Rates</th></tr></thead><tbody>'
    console.log(carpark_obj['Rates'])
    if (Object.keys(carpark_obj['Rates']).length == 0) {
        display += '<tr><td colspan=2 >No Available Information on Carpark Rates</td></tr>'
    }
    for (rates in rates_arr) {
        //console.log(rates)
        display += '<tr>'
        display += '<th scope="row">' + rates + '</th>';
        display += '<td>'
        if (rates == 'Weekdays') {
            //console.log(rates_arr)
            for (r in rates_arr[rates]) {
                display += rates_arr[rates][r] + '<br><br>';
            }
        }
        else {
            display += rates_arr[rates];
        }
        display += '</td></tr>'
    }
    display += '</tbody></table></div>'
    //  Display duration 
    display += "<div><h5 style='width:80%' class='d-inline-block display-5'>Time Taken to Destination:</h5><h5 style='width:20%' class='d-inline-block display-5 text-right'>"+total_duration+" </h5>"
    display += "<div><h5 style='width:80%' class='d-inline-block display-5'>Distance to Destination:</h5><h5 style='width:20%' class='d-inline-block display-5 text-right'>"+total_distance+"m </h5>"
    // Display steps 
    display += `<button style='width: 100%; height: 40px; line-height: 20px; margin: 10px 0px' class='btn btn-dark my-2'><a style='color:white' target="blank" href='https://www.google.com/maps/dir/?api=1&origin=${carpark_obj['Location']}&destination=${desired}'>Get directions here!</a></button>`
    display += '</div>';


    // display += '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>';
    display += '</div></div>';
    document.getElementById('deets').innerHTML = display;
    document.getElementById('deets').setAttribute('style', '')

}



function display_carpark(response_json) {
    
    var current_avail_parking = response_json.value;
    var add = '';
    for (info_obj of current_avail_parking) {
        var location = info_obj['Location'];
        //console.log(location);
        var development = info_obj['Development'];
        var type = info_obj['LotType'];
        var avail_lots = info_obj['AvailableLots'];
        //console.log(rates_arr);
        //console.log(location);
        //console.log(development);
        //console.log(type);
        //console.log(avail_lots);
        add += '<div class="card">';
        add += '<div class="card-header">' + development+ '</div>';
        add += '<div class="card-body">';
        for (lotType in avail_lots) {
            //console.log(avail_lots);
            //console.log(lotType);
            add += '<p style="display: inline-block;">Number of available ' + lotType + ' lots</p>';
            add += '<p style="float:right;">' + avail_lots[lotType] + '</p>';
        }

        var rates_arr = info_obj['Rates'];
        add += '<div class"clearfix"><table border=1>'
        for (rates in rates_arr) {
            //console.log(rates)
            add += '<tr>'
            add += '<td>' + rates + '</td>';
            add += '<td>'
            if (rates == 'Weekdays') {
                //console.log(rates_arr[rates])
                for (r in rates_arr[rates]) {
                    //console.log(rates_arr[rates][r])
                    add += rates_arr[rates][r] + '<br><br>';
                }
            }
            else {
                add += rates_arr[rates];
            }
            add += '</td></tr>'
        }
        add+= '</table></div>';


        add += '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>';
        add += '<button type="button" class="btn btn-primary btn-block" style="block-size:50px;" onClick="choose(' + info_obj + ')">View</button>';
        add += '</div></div>';

    }
    document.getElementById('carpark-card').innerHTML = add;
}

/** Unused codes
 * to get long lat values based on name




compare if it is the correct place by long lat
                    if(false) {
                        if (carparks.location != 'undefined') {
                            //console.log(carparks.carpark);
                            console.log(carparks.location)
                            var long = carparks.location[0];
                            var lat = carparks.location[1];
                            console.log(location_avail[1], long, location_avail[0], lat)
                            //console.log(long = location_avail[1] && lat == location_avail[0])
                            if (location_avail[1] == long && location_avail[0] == lat) {
                                //console.log('hey')
                                var sat_rate = carparks.saturday_rate;
                                var sun_ph_rate = carparks.sunday_publicholiday_rate;
                                var weekday1_rate = carparks.weekdays_rate_1;
                                var weekday2_rate = carparks.weekdays_rate_2;
                                obj['Rates'] = {'Saturday' : sat_rate, 'Sunday and Public Holiday' : sun_ph_rate, 'Monday to Friday (7am to 10pm)': weekday1_rate, 'Monday to Friday (10pm to 7am)': weekday2_rate}
                                //countty++;
                                //console.log(obj['Rates']);
                                //display_carpark(rates_avail_arr);
                                //console.log('-----------rates--------------')
                                console.log(obj)
                                console.log('match');
                                
                            }
                        }
                    }
 */