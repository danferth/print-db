

(function($){

		$.extend({labelSwitch : function(){

			if($('p.input input').val() != ""){
				$('p.input label').hide();
			}else{

			$('p.input').css({'position':'relative'});
			$('p.input label').css({
				'position':'absolute',
				'left':'15px',
				'top':'4px'
			});

			$('p.input input').on('focusin',function(){
				$(this).siblings('label').fadeOut(300);
			});	
			$('p.input input').on('focusout',function(){
				if($(this).val() === ""){
				$(this).siblings('label').fadeIn(300);
				}else{
				$(this).siblings('label').hide();	
				}
			});
			$('p.input label').on('click',function(){
				$(this).fadeOut(300);
				$(this).siblings('input').focus();
			});	

		}

			$('textarea').each(function(){
			var message = "message";
			var empty = "";  
  			
  			if($(this).val() == ""){
			$(this).val(message);
			}	
			
			  $(this).on('focusin',function(){
			      if($(this).val() == message){
			        $(this).val(empty);
			      }
			  });
			  
			  $(this).on('focusout',function(){
			    if($(this).val() == empty){
			      $(this).val(message);
			    }
			  });
			});


		}
	});
})(jQuery);	


	$.fn.icon = function(letter){
		

		return this.each(function(){
  			if($(this).text() == 0){
    			$(this).text(" ");
  			}else{
    			$(this).text(letter);
  			}
			});

	}