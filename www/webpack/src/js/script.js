$(document).ready(function(){
    $('#openForm').click(function(){
        showModal();
    })
})

/*$(document).ready(function(){
    $('.close').click(function(){
        closeModal();
    })
})*/


function showModal(){
    //appel Ajax route php qui retourne un modal
    $.ajax({
        url: "/event/createForm"
    }).done(function(html){
        $('body').append('<div id="modal"><div class="modal-content>' + html + '</div></div>');
    })

}

function closeModal(){
    $('#modal').fadeOut(500);
    /*$(".modal-content").animate({
        transform: translateY(-100%)
    });*/
    setTimeout(function() {
        $('#modal').remove()
    }, 1000);
}