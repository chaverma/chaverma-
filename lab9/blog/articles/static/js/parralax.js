    var yPosition;
    var scrolled = 0;
    var $parallaxElements = $('.icons-for-parallax img');
    $(window).scroll(function() {
      console.log(yPosition);
      if (yPosition != 270){
        console.log('s');
        scrolled = $(window).scrollTop();
        for (var i = 0; i < $parallaxElements.length; i++){
            yPosition = (scrolled * 0.25*(i + 1));
            $parallaxElements.eq(i).css({ top: yPosition });
        }
      }
});
