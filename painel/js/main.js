$(function(){
	var open = true;
	/*Se tirar o indice [0] terei acesso apenas ao jquery*/
	var windowSize = $(window)[0].innerWidth; /*indice [0] para trabalhar com as funções nativas do java Script*/
    
    /*Mudança de valor da tela*/
	var targetSizeMenu = (windowSize <= 400) ? 200 : 250;

	if(windowSize <= 768){
		$('.menu').css('width','0').css('padding','0');
		open = false;
	}

	$('.menu-btn').click(function(){
		if(open){
			//O menu está aberto, precisamos fechar e adptar nosso conteúdo geral do painel.
			$('.menu').animate({'width':0,'padding':0},function(){
				open = false;
			});
			$('.content,header').css('width','100%');
			$('.content,header').animate({'left':0},function(){
				open = false;
			});
		}else{
			//O menu está fechado.
			$('.menu').css('display','block');
			$('.menu').animate({'width':targetSizeMenu+'px','padding':'10px 0'},function(){
				open = true;
			});
			if (windowSize > 768) 
			$('.content,header').css('width','calc(100% - 250px)');
			$('.content,header').animate({'left':targetSizeMenu+'px'},function(){
				open = true;
			});
		}
	})


$(window).resize(function(){
	windowSize = $(window)[0].innerWidth;
	targetSizeMenu = (windowSize <= 400) ? 200 : 250;
	if(windowSize <= 768){
		$('.menu').css('width','0').css('padding','0');
		$('.content,header').css('width','100%').css('left','0');
		open = false;

	}else{
		$('.menu').animate({'width':targetSizeMenu+'px','padding':'10px 0'},function(){
        open = true;
		});
		$('.content,header').css('width','calc(100% - 250px)');
		$('.content,header').animate({'left':targetSizeMenu+'px'},function(){
			open = true;
		});
	}
	
  })

/*Este atributo [formato=data] eu colocarei em todos os input que eu deseje cadastrar
 lembrando que este [formato=data] eu crei agora. */
 $('[formato=data]').mask('99/99/9999');

 /*Caixa de dialogo para confirmar antes de excluir*/
 $('[actionBtn=delete]').click(function(){
 	var txt;
 	var r = confirm("Deseja excluir o registro?");
 	if (r == true){
 		return true;
 	}else{
 		return false;
 	}
 })

})

