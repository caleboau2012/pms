/**
 * Created by user on 2/8/2015.
 */
var patient;

$(document).ready(function(){
    init();

    $('.patient').draggable({
        containment: 'body',
        cursor: 'move',
        snap: '.patients',
        helper: 'clone',
        stop: getDraggedPatient
    });

    $('.patients').droppable({
        drop: patientDrop
    });
});

function init(){
    $('#masonry').masonry();
}

function getDraggedPatient(e, ui){
    patient = verifyEvent(e);

    //console.log($(data).html());
}

function verifyEvent(e){
    if (!e)
        var e = window.event;
    if (e.target)
        data = e.target;
    else if(e.srcElement)
        data = e.srcElement;

    return data;
}

function patientDrop(e, ui){
    var source = ui.draggable[0];
    var target = this;

    $(target).find('ul').prepend(source);
    init();
}