var noLimits = {
	init: function(){
		this.misc(jQuery);
	},
	misc: function($){
		$('html').addClass('js');
		$('.grid li:nth-child(4n+4)').addClass('last');
		
		$('.prd').click(function(e){
			e.preventDefault();
		})
		
		$('.viewdetails').on('click',function(e){
			e.preventDefault();
			var thisbtn = $(this);
			var 	hidetxt = 'HIDE DETAILS',
					showtxt = 'VIEW DETAILS';
			
			if ( thisbtn.text() == showtxt ){
				$('#description').slideDown();
				thisbtn.text(hidetxt);
				
			}else{
				$('#description').slideUp();
				thisbtn.text(showtxt);
			}
		
		})
	},
	slider:function($){
		 $('#carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 80,
			itemMargin: 5,
			asNavFor: '#slider'
		  });

		  $('#slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			sync: "#carousel",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		  });
		  
		 $('.gallery').flexslider({
		    animation: "slide",
		    animationLoop: false,
		    itemWidth: 140,
		    itemMargin: 24,
			easing: "swing",
			move:3,
			nextText:'',
			prevText:'',
			controlNav:false
		  });
	},
	
	masonry: function($){
		$('.masonry').masonry({
			columnWidth:'.cell',
			itemSelector: '.cell'
		});
	}
	
}