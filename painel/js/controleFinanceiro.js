$(function(){
	/*desta forma eu implemento o [name=parcelas] com duas casas 99 e o [name=interval] com duas casas. como tabem poderia colocar em baixo de forma independente*/
	$('[name=parcelas],[name=interval]').mask('99'); /*este é o numero de parcelas com dois digitos*/
	$('[name=valor]').maskMoney({prefix:'R$ ',allowNegative: true, thousands:'.', decimal:',', affixesStay: false}); /*este é o valor a ser pago com plugin maskMoney tirado do google e com formado brasileiro
	 acrescentado pois o formato que vem no plugin maskMoney é americano.*/
	
	$('[name=vencimento]').Zebra_DatePicker();
	 

	

	/*TODO*/
	/*Acredito eu que para realizar a conversão do input vencimento no front-end para brasileiro
	seja por aqui..Vamos aguardar.*/
})





