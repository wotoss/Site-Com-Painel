    
$(function () {
	var atual = -1;
	var maximo = $('.box-especialidades').length -1;
	var timer;
	var animacaoDelay = 3;
   
   
	executarAnimacao();
  

	function executarAnimacao(){
     
		$('.box-especialidades').hide();//Estou escondendo o box-especialidade com o hide
            timer = setInterval(logicaAnimacao,animacaoDelay *600);

      function logicaAnimacao(){
      	atual++
      	if (atual > maximo) {
      		clearInterval(timer);
      		return false;
      	}
      	$('.box-especialidades').eq(atual).fadeIn();
           }  
        
        } 
	})
  

