 $(function(){
    $(".boxes").sortable({
    start: function(){ //quando o usuario começar a mexer a box
       var el = $(this); //O que é this..seria elemento que estou aplicando sortable. sendo a box 
       el.find('.box-single-wraper > div:nth-of-type(1)').css('border','2px dashed #ccc');
   },
    update:function(event,ui){
       var data = $(this).sortable('serialize');
       var el = $(this); //O que é this..seria elemento que estou aplicando sortable. sendo a box 
       data+='&tipo_acao=ordenar_empreendimentos';
       el.find('.box-single-wraper > div:nth-of-type(1)').css('border','1px solid #ccc');
       /*vamos fazer uma chamada ajax*/
       $.ajax({
       	url: include_path+'ajax/forms.php',
       	method:'post',
       	data: data
       }).done(function(data){
       	console.log(data);
       })
      }
    });
  })