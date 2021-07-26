

$(function(){

	$('[name=cpf]').mask('999.999.999-99');
	$('[name=cnpj]').mask('99.999.999/9999-99');
	$('[name=preco]').maskMoney({prefix:'R$ ',allowNegative: true, thousands:'.', decimal:',', affixesStay: false}); /*este é o valor a ser pago com plugin maskMoney tirado do google e com formado brasileiro
	 acrescentado pois o formato que vem no plugin maskMoney é americano.*/
	

    /*quando alterar a função selecionada ou select function  */
	$('[name=tipo_cliente]').change(function(){
		var val = $(this).val();
		if(val == 'fisico'){
			$('[name=cpf]').parent().show();/*parent() ler a div show ()mostrar*/
			$('[name=cnpj]').parent().hide();/*parent() ler a div hide()ocultar, esconder*/
		}else{
			$('[name=cpf]').parent().hide();
			$('[name=cnpj]').parent().show();
		
		}
	})
    
})