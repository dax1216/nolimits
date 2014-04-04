jQuery.fn.toggleClick = function(){
    var functions = arguments ;
    return this.click(function(){
            var iteration = jQuery(this).data('iteration') || 0;
            functions[iteration].apply(this, arguments);
            iteration = (iteration + 1) % functions.length ;
            jQuery(this).data('iteration', iteration);
    });
};

var Matrix = {
	init:function(){
		this.masonry(jQuery);
		this.forms(jQuery);
		this.accordion(jQuery);
		this.misc(jQuery);
	},
	masonry: function($){
		$('.masonry').masonry({
			columnWidth:'.post',
			itemSelector: '.post'
		});
	},
	forms: function($){
		Matrix.checkbox(jQuery);
	},
	checkbox: function($){
		var checkbox =  $('.form.nice input[type="checkbox"]');	
		checkbox.each(function(){			
			var thischeckbox = $(this),
			parent = thischeckbox.parent(),
			styledcheckbox = $('<span/>',{
				'class':'custom-checkbox',
				'text':''
			});
			thischeckbox.css('display','none');
			parent.prepend(styledcheckbox);
		})
		Matrix.styledcheckbox(jQuery);
	},
	styledcheckbox: function($){
		var c_checkbox =  $('.form.nice .custom-checkbox');
		c_checkbox.toggleClick(function(){			
			var this_c_checkbox = $(this);
			this_c_checkbox.addClass('checked');
			this_c_checkbox.next().attr('checked','checked')
		},function(){
			var this_c_checkbox = $(this);
			this_c_checkbox.removeClass('checked');
			this_c_checkbox.next().removeAttr('checked');
		})
	},
	
	accordion: function($){
		var list = $('.accordion .box ul > li a');
		var li = $('.accordion .box ul > li');
		list.click(function(e){
			e.preventDefault();
			li.removeClass('active');
			li.animate({
				'maxHeight':'26px',
			},{queue: false , duration:300});
			
			var thisli = $(this),
				parent = thisli.parent();
				parent.addClass('active');
				parent.stop().animate({
					'maxHeight':'200px',
				},{queue: false , duration:300})
			
		}); 			
		
		
	},
	misc: function($){
		var p = $('p');
		p.each(function(){
			var thisp = $(this);
			if(thisp.children().length == 0 && thisp.text() ==''){
				thisp.addClass('hide');
			} 
		})
	}
}

