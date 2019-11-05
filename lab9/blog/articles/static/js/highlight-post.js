    $('.one-post').hover(function(event){
        $(event.currentTarget).find('.one-post-shadow').animate({opacity:
'0.3'}, 300);
    }, function(event){
$(event.currentTarget).find('.one-post-shadow').animate({opacity: '0'},
500);
});
$('.logo').hover(function(){$('.logo').animate({width:'237px'}, 200)},
function(){$('.logo').animate({width:'217px'},200)});
