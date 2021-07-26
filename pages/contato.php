<!--<div id="map"></div>-->
<div class="contato-container">
	<div class="center">
		<form class="ajax-form" method="post" action="">
			<input required type="text" name="nome" placeholder="Nome...">
			<div></div>
			<input required type="text" name="email" placeholder="E-mail...">
			<div></div>
			<input required type="text" name="telefone" placeholder="Telefone">
			<div></div>
			<textarea required placeholder="Sua mensagem..." name="mensagem"></textarea>
			<div></div>
			<!--Usando o (input type="hidden") não fica visivel para o nosso usuario, mas serve para nos identificarmos o nosso formulário-->
			<input type="hidden" name="identificador" value="form_contato">
			<input type="submit" name="acao" value="Enviar">
		</form>
		
	</div>
</div>