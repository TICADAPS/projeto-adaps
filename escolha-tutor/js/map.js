var buttonSat = document.querySelector('#satellite');
buttonSat.addEventListener('click', function (){
    map.setMapTypeId('satellite');
});
var buttonTerr = document.querySelector('#terrain');
buttonTerr.addEventListener('click', function (){
    map.setMapTypeId('terrain');
});
var buttonRod = document.querySelector('#road');
buttonRod.addEventListener('click', function (){
    map.setMapTypeId('road');
});
var buttonHib = document.querySelector('#hybrid');
buttonHib.addEventListener('click', function (){
    map.setMapTypeId('hybrid');
});

var map;
function initMap(){
    var mapOptions = {
        center: {lat:-15.800642572030194, lng: -47.882845461287715},
        zoom: 13,
        mapTypeId: 'terrain', // road, satellite, hybrid, terrain
        //disableDefaultUI: true
        //zoomControl:false,
        //streetViewControl:false
        mapTypeControl: true,
        mapTypeControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            mapTypeIds: ["roadmap", "terrain"],
        }
    };
    map = new google.maps.Map(document.getElementById('map'),mapOptions);
    // adicionar
    var marker = new google.maps.Marker({
        position: {lat:-15.800642572030194, lng: -47.882845461287715},
        map: map,
        title: 'Edificío Carlton Tower',
        //label: 'A',
        icon: '../img/iconMap.png',
        animation: google.maps.Animation.DROP,
        draggable: true
    });
    
    map.addListener('click',function (e) {
        var clickPosition = e.latLng;
        new google.maps.Marker({
            position: clickPosition,
            map: map,
            title: 'Edificío Carlton Tower',
            //label: 'A',
            icon: '../img/iconMap.png',
            animation: google.maps.Animation.DROP,
            draggable: true
        });
    });
    
    // remover
    //marker.setMap(null);
}


