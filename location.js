let geolocation = {
    fetchLocation: function() {
        fetch(
            "http://ip-api.com/json"
        )
        .then((response) => response.json())
        .then((data) => this.displayLocation(data));
    },
    displayLocation: function(data){
        const { city } = data;
        const { regionName } = data;
        const { zip } = data;
        document.querySelector(".city").innerText = city;
        document.querySelector(".regionName").innerText = regionName;
        document.querySelector(".zip").innerText = zip;
    }
}

geolocation.fetchLocation();