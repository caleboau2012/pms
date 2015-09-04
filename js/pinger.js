var Pinger = {};
Pinger.RESOURCE = {
    pingerURL       :   host + "phase/phase_lookout.php?intent=markPresence",
    pingInterval    :   60000
}

Pinger.markPresence = function() {
    $.get(Pinger.RESOURCE.pingerURL);
    console.log("pinged");
}

Pinger.start = function() {
    Pinger.markPresence();
    setInterval(function(){Pinger.markPresence();}, Pinger.RESOURCE.pingInterval);
}

Pinger.start();