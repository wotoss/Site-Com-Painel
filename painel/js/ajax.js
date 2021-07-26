$(function(){
	/*pegando o formulário ('.ajax'). Atraves do ajaxForm eu consigo ler o formulario completo */
	$('.ajax').ajaxForm({
		dataType:'json',
		beforeSend:function(){

			/*este{'opacity':'0,6'} é para dar uma animação enquando envia os dados */
          $('.ajax').animate({'opacity':'0,6'});
          /* este é para desabilitar o botão enquanto envia os dados*/
          $('ajax').find('input[type=submit]').attr('disabled','true');
		},
		success: function(data){
			 $('.ajax').animate({'opacity':'1'});
			 $('ajax').find('input[type=submit]').removeAttr('disabled');
             /*coloco este $('.box-alert').remove(); para que não apareça duas vezes a barra de erro*/
			 $('.box-alert').remove();
			 if(data.sucesso){
			 	$('.ajax').prepend('<div class=" box-alert sucesso"><i class="fa fa-check"></i> '+data.mensagem+'</div>');
			 	if($('.ajax').attr('atualizar') == undefined);
			    $('.ajax')[0].reset();/*limpar ou resetar todos os campos do formulario quando for sucesso*/
			 }else{
			 	$('.ajax').prepend('<div class=" box-alert erro"><i class="fa fa-times"></i> '+data.mensagem+'</b></div>');
			 }	
		}
	})

	/*inicio - delete*/
		$('.btn.delete').click(function(e){
		e.preventDefault();
		var item_id = $(this).attr('item_id');
		var el = $(this).parent().parent().parent().parent();
		$.ajax({
			url:include_path+'/ajax/forms.php',
			data:{id:item_id,tipo_acao:'deletar_cliente'},
			method:'post'
		}).done(function(){
			el.fadeOut();
		})
	})

	/*fim - delete*/
})