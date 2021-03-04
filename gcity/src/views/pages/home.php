<?php $render('header', ['dataUser'=>$dataUser]); ?>


<!DOCTYPE html>
<html>
<body>
<!--<p id="demo">Clique no botão para receber sua localização em Latitude e Longitude:</p>
<button onclick="getLocation()">Clique Aqui</button>-->
<!--fazendo requisições ajax e enviando para o banco de dados -->
<!-- 
 1º Pegar as coordenadas via javascript 
 2º Fazer uma requisição ajax para o banco de dados
 3º verificar a resposta do banco de dados
-->
<script src="localhost/gcity/public/assets/js/jquery-min.js" ></script>
<script >
var x=document.getElementById("demo");

/*window.onload = function(){

  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    }
  else{x.innerHTML="O seu navegador não suporta Geolocalização.";}
  }*/


function getLocation (){
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    //depois que pega a localização, então envia para o banco de dados via Ajax
    

    }
  else{x.innerHTML="O seu navegador não suporta Geolocalização.";}
  }
function showPosition(position){
  x.innerHTML="Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude; 
  //ajaxCoords(position.coords.latitude, position.coords.longitude);
  }

async function ajaxCoords(lat, long) {
    let data = new FormData();

    data.append('lat',  lat);
    data.append('long',  long);
    data.append('newCoordReq', 1);//nova coordenada ao clicar
    info={'lat':lat, 'long': long, 'newCoordReq':1};
    console.log(info);

    var dados = JSON.stringify(info);

    BASE = '/gcity/public';
    let req = await fetch(BASE+'/ajax/setCoords', {
      method:'POST',
      body:{data:info},
    });

    let json = await req.json();

    console.log(json);
}
</script>
</body>
</html>