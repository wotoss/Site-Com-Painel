
    
$(function(){
	/*Quando eu declaro no inicio as var (variaveis) eu quero que todas as funções tenham acesso
	 inclusive quando chamo nas funções eu não preciso colocar o var... */
	 /* Variaveis que todas as funções tem acesso são variaveis globais*/
	var curSlide = 0;

	var maxSlide = $('.banner-single').length -1;
	
	var delay = 3;

    
    initSlider();
	changeSlide();

/*Fazendo em Jquery*/
   
	function initSlider(){
		/*Neste momento eu estou escondendo (hide) os outros banner e trazendo o primeiro banner eq(0) */
		$('.banner-single').hide();
		$('.banner-single').eq(0).show();
		/*fazendo as condificação das bolinhas ou bullets..vindo do html*/
		for(var i = 0; i < maxSlide+1; i++){ /*Enquanto i ou 0 for menor < maxSlide ou maximo de Slide acrescenta mais um ou i++ */
			var content = $('.bullets').html();
			/*vou colocar um if neste trecho de codigo...content+='<span></span>';*/
             if (i == 0) 
			content+='<span class="active-slider"></span>'; /*content (container vai ser adicionado add (+=) o '<span></span>')*/
			else
				content+='<span></span>';
			$('.bullets').html(content);

		}
	}
     /*Fazendo em Jquery*/
	function changeSlide(){
		setInterval(function(){
			$('.banner-single').eq(curSlide).stop().fadeOut(2000);
			//$('.banner-single').eq(curSlide).animate({'opacity':'0'},2000);
			curSlide++;
			if(curSlide > maxSlide) /*Se o curSlide (0) for maior > maxSlide (3)...ele reseta e volta a 0 curSlide = 0;*/
				curSlide = 0;
			$('.banner-single').eq(curSlide).stop().fadeIn(2000);
			//$('.banner-single').eq(curSlide).animate({'opacity':'1'},2000);
             //Trocar bullets (bolinha) da navegação do slider! 
             $('.bullets span').removeClass('active-slider');
             $('.bullets span').eq(curSlide).addClass('active-slider');
		},delay *1000);
	}

	/*Fazer ele trocar dinamica mente com um click..usando Jquery*/

	/*Vamos lá..Estou chamando o corpo ('body') usando o envento do Jquery (.on) ..
	agora vou colocar os parametros(1ºevento('click'), 2ºa classe que eu quero ('bullets span')3º é o que eu quero que aconteça function())*/
	$('body').on('click','.bullets span',function(){
		/*Crio a variavel var currentBullet = quando eu coloco $(this) estou fazendo referencia ao objeto que foi clicado */
		var currentBullet = $(this);
		$('.banner-single').eq(curSlide).stop().fadeOut(1000);
		//$('.banner-single').eq(curSlide).animate({'opacity':'0'},2000);/*Esconder antes de declarar a variavel ou linha abaixo curSlide*/
		curSlide = currentBullet.index();
		$('.banner-single').eq(curSlide).stop().fadeIn(1000);
		//$('.banner-single').eq(curSlide).animate({'opacity':'1'},1000); /*E faz aparecer o proximo*/
		$('.bullets span').removeClass('active-slider');
		currentBullet.addClass('active-slider'); /*Quando eu clicar ele vai ficar branco ('active-slider')..lá no sytle.css ('active-slider') é branco chamo esta classe. */

      
	});

})
 