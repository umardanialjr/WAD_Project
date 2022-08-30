
        // Script for the favourite and search history. 
    
        // Add search button value to database array of search objects 
        // Array of dat ais data
        
        // <script src='../desired.js'></script>
    
        //Populate the locations with samplay array of location>
        function populate(){
            var textsearch=`<table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Search History</th>
                        </thead>
                        <tbody>`;

            var textfavourite=`<table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Location Favourites</th>
                            </thead>
                            <tbody>`;

            
            console.log(locationFavourites);
            for (var i = 0 ; i < locationFavourites.length ; i++ ) {
                if ((locationFavourites[i] == "") || (i >= locationFavourites.length)){
                    var stringFavourite = ""; 
                } else {
                    console.log(locationFavourites[i])
                    var stringFavourite = `${locationFavourites[i]}<button class='btn btn-primary' style="margin:5px 5px; float:right" onclick='desired_fav(${i})'><a href="information.php" style='color:white'>Search</a></button><button type="button" class="btn btn-outline-danger" style="margin:5px 5px; float:right" onclick="removeFromFavourite('${locationFavourites[i]}')";>Remove</button>`;
                    
                

                }

                textfavourite += `<tr>
                            <th scope="row">${i+1}</th>
                            <td>${stringFavourite}</td>
                        </tr>`;
            }
            
            for (var i = 0 ; i < locationHistory.length ; i++ ) {

                if ((locationHistory[i] == "") || (i >= locationHistory.length) ){
                    var stringLocation = ""; 
                } else {
                    var stringLocation = `${locationHistory[i]}<button type="button" class="btn btn-outline-info" style="margin:5px ; float:right" onclick="addToFavourite('${locationHistory[i]}')">Add Favourites</button>`;
                }

                textsearch += `<tr>
                            <th scope="row">${i+1}</th>
                            <td>${stringLocation}</td>
                        </tr>`;
            }


                
            localStorage.setItem('locationFavourites', JSON.stringify(locationFavourites))

                

                

            
            textsearch += `</tbody>
                </table>`;

            textfavourite += `</tbody>
            </table>`;

            var hi = document.getElementById("tablehistory");
            hi.setAttribute('style', 'padding-top: 30px')
            hi.innerHTML = textsearch;

            var hello = document.getElementById("tablefavourite");
            hello.setAttribute('style', 'padding-top: 30px')
            hello.innerHTML = textfavourite;

            if (locationHistory.length == 0 ){
                hi.setAttribute('style', 'display:none')
            }

            
            if ( locationFavourites.length == 0 ) {
                hello.setAttribute('style', 'display:none')
            }
            
    
        }     

        function addtoSearchHistory (){
            // dao = searchHistoryChange()
            var searchInput = document.getElementById("address").value;
            if (searchInput != ""){
                    console.log(searchInput);

                    //Put in the search history array. 
                    if ( locationHistory.length == 0 ) {
                        locationHistory = [searchInput];
                    } 
                    
                    else {
                        // if (locationHistory.indexOf(searchInput)==-1) {
                            
                            if ( locationHistory.length >= 5 ){
                                locationHistory.pop();
                            }
                            locationHistory.unshift(searchInput)
                            
                        // }
                    }
                    console.log(locationHistory);
                    
                    //locationHistory = location.History.splice(locationHistory.length-6,5)
                    //console.log(locationHistory)
                    var searchReturn = locationHistory.join(",");
                    //console.log(searchReturn);

                    

                    

                    searchReturn = encodeURIComponent(searchReturn);
                    usernameReturn = encodeURIComponent(username);

                    var request  = new XMLHttpRequest();

                    request.onreadystatechange = function () {
                    // alert("readyState " + this.readyState + " and status " + this.status);

                        if ( this.readyState == 4 && this.status == 200 ) {
                            
                            console.log( this.responseText);
                            // UPdate the things you want to change. 
                            var response_json = JSON.parse(this.responseText);
                            console.log(response_json);
                            console.log("okay")

                        }
                    }
                    
                    request.open("GET", `php/dataprocessing.php?searchReturn=${searchReturn}&username=${usernameReturn}` ,true );
                    request.send();
                    
                    populate();
            }
            


            
        }
        function removeFromFavourite(place) {
            // Remove from the array set up from the database & Also remove from the database itself. 

            //Remove from the given array

            

            var index = locationFavourites.indexOf(place);
            if (index > -1) {
                locationFavourites.splice(index, 1);
            }
            var favouriteReturn = '';

            populate();



            // $dao->getUsersbyUsername($username);
            //Remove from database array is samplearray
            // Put into a string, then call the dao

            console.log(locationFavourites);
            
            if (locationFavourites.length !== 0) {
                var favouriteReturn = locationFavourites.join(",")
            }
            
            favouriteReturn = encodeURIComponent(favouriteReturn)
            console.log(favouriteReturn);
            usernameReturn = encodeURIComponent(username)

            var request  = new XMLHttpRequest();

            request.onreadystatechange = function () {
            // alert("readyState " + this.readyState + " and status " + this.status);

                if ( this.readyState == 4 && this.status == 200 ) {
                    
                    console.log( this.responseText);
                    // UPdate the things you want to change. 
                    var response_json = JSON.parse(this.responseText);
                    console.log(response_json);
                    console.log("okay")
                }
            }
            
            request.open("GET", `php/dataprocessing.php?removeFromFavourite=${favouriteReturn}&username=${usernameReturn}` ,true );
            request.send();
 
           
        }
        
        function addToFavourite(place) {
            // Push to the array set up from the database & Also add to the database itself. 
            
            //push to the array
            if (locationFavourites.indexOf(place) == -1) {
                locationFavourites.push(place);
            }
            

            //Remove from array of database and remove from array of locationhistorydatabase
            // var index = locationHistory.indexOf(place);
            // if (index > -1) {
            //     locationHistory.splice(index, 1);
            // }

            populate();
            

            // update databsae'
            var searchReturn = locationHistory.join(",");
            searchReturn = encodeURIComponent(searchReturn);
            var favouriteReturn = locationFavourites.join(",")
            favouriteReturn = encodeURIComponent(favouriteReturn)
            console.log(favouriteReturn);
            var usernameReturn = encodeURIComponent(username)

            var request  = new XMLHttpRequest();

            request.onreadystatechange = function () {
            // alert("readyState " + this.readyState + " and status " + this.status);

                if ( this.readyState == 4 && this.status == 200 ) {
                    
                    console.log( this.responseText);
                    // UPdate the things you want to change. 
                    var response_json = JSON.parse(this.responseText);
                    console.log(response_json);
                    console.log("okay")
                }
            }
            
            request.open("GET", `php/dataprocessing.php?favourite=${favouriteReturn}&username=${usernameReturn}&searchReturn=${searchReturn}` ,true );
            request.send();




        }
