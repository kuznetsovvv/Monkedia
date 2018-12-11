//This file contains functions that perform common tasks and shouldn't need to be written from scratch on a day to day basis

//Reads GET parameters, writes them to a global array of them to access later. Minimize computational expense this way.
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    window.GETparams = [];
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        window.GETparams[sParameterName[0]] = sParameterName[1];
    }   