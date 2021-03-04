function WindowNewPublish(){
    document.querySelector('.window-publis-container').style.display = 'flex';
}
function closeWindowPublish(){
    document.querySelector('.window-publis-container').style.display = 'none';
}
let type;

function addNewPublish(){
    var digit = document.querySelector('.area-digit').innerText.trim();
    let city = document.querySelector('.info-city').innerText;
    if(digit==''){
        console.log('Digite algo');
    }
    console.log(digit, city, type);

    let info = new FormData();
    info.append('body', digit);

    if(digit !='' && city){
        data = {'body':digit,'city':city, 'type_publish': type};
        var dados = JSON.stringify(data);
        //adicionar ao banco de dados a publicação
        BASE = 'localhost/gcity/publish';
        fetch(BASE+'/ajax/publish',{
            headers : { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            method: 'POST',
            body:{data:dados},
        });
    }


}
function selectValue(element) {
    type = element.options[element.selectedIndex].text;
    console.log(type);
    
}

document.querySelector('.feed-new-input').addEventListener('blur', function(obj) {
    let value = obj.target.innerText.trim();
    if(value == '') {
        obj.target.style.display = 'none';
        document.querySelector('.feed-new-input-placeholder').style.display = 'block';
    }
});


//para fechar a janelinha de excluir post
/*function closeFeedWindow() {
    document.querySelectorAll('.feed-item-more-window').forEach(item=>{
        item.style.display = 'none'; //tira a div de excluir post
    });

    document.removeEventListener('click', closeFeedWindow);
}*/

//abrir e fechar a janela de excluir post, adiciona um evento de click
/*document.querySelectorAll('.feed-item-head-btn').forEach(item=>{
    item.addEventListener('click', ()=>{
        closeFeedWindow(); //para fechar todas as janelinha já abertas
        item.querySelector('.feed-item-more-window').style.display = 'block'; //aparecer o botão de excluir

        //0.5 segundos é preciso esperar para clicar para fechar
        setTimeout(()=>{
            document.addEventListener('click', closeFeedWindow);
        }, 500);
    });
});*/
/*
document.querySelectorAll('.feed-item-head-btn').forEach(item=>{
    item.addEventListener('click',()=>{
        if(item.querySelector('.feed-item-more-window').style.display == 'block'){
            document.querySelectorAll('.feed-item-more-window').forEach(open=>{
                if(open.style.display == 'block'){
                    open.style.display = 'none';
                }
            });
            item.querySelector('.feed-item-more-window').style.display = 'none';
        }else{
            item.querySelector('.feed-item-more-window').style.display = 'block';
        }
    });
});*/
function closeFeedAll(open){
    document.querySelectorAll('.feed-item-more-window').forEach(item=>{
        item.style.display = 'none';
    });
    open.querySelector('.feed-item-more-window').style.display = 'block';
}

document.querySelectorAll('.feed-item-head-btn').forEach(item=>{
    item.addEventListener('click', ()=>{
    
    if(item.querySelector('.feed-item-more-window').style.display == 'block'){
        item.querySelector('.feed-item-more-window').style.display = 'none';
        console.log("Fecha");
        
    }else{
        item.querySelector('.feed-item-more-window').style.display = 'block';
        closeFeedAll(item);
        console.log("Abre");
    }
    });
  });


//acha uma tag html em que a classe é like-btn 
if(document.querySelector('.like-btn')) { 
    document.querySelectorAll('.like-btn').forEach(item=>{//pega todos os botões e adiciona um evento de click
        item.addEventListener('click', ()=>{//evento de click
            //em feed-item, tem um atributo chamado data-id
            //<div class="box feed-item" data-id="<?=$data->id;?>">
            let id = item.closest('.feed-item').getAttribute('data-id'); //pega o id da postagem
            let count = parseInt(item.innerText); //quantidade de likes, pelo texto interno 
            //<div class="like-btn <?=($data->liked ? 'on':'');?>"><?=$data->likeCount;?></div>
            if(item.classList.contains('on') === false) { //se não tiver a classe on, que significa ter tido like
                item.classList.add('on'); //adiciona +1 se eu não tiver dado like na postagem
                item.innerText = ++count; //adiciona, via javascript, +1 like, apenas visualmente
            } else {
                item.classList.remove('on');
                item.innerText = --count; //se clicou e já tinha dado like, então retira o like
            }
            //fetch = faz uma requisição HTTP na rota ajax/like/{id} para contabilizar o like ou retirar
	        fetch(BASE+'/ajax/like/'+id);
        });
    });
}


//pega o comentário digitado
if(document.querySelector('.fic-item-field')) {
    document.querySelectorAll('.fic-item-field').forEach(item=>{ //pega todos os itens que tem essa classe
        item.addEventListener('keyup', async (e)=>{ //keyup = quando solta a tecla, executa essa função de pegar o que já foi digitado
            if(e.keyCode == 13) { //enter = e.keyKode == 13
                let id = item.closest('.feed-item').getAttribute('data-id'); //id do post
                let txt = item.value; //o que foi digitado
                console.log(item.innerText);
                if( !txt == '' && !txt == '0'){
                    //let countComment = parseInt(item.innerText); //valor de comentários que está na div
                    let valueComments = document.getElementById("msg-btn").innerHTML;
                    valueComments = ++valueComments;
                    document.getElementById("msg-btn").innerHTML = valueComments;
                    console.log(valueComments);
                    item.value = ''; //limpa o que foi digitado
                }else{
                    console.log("Vazio");
                    alert("Digite algo");   
                    return -1;
                }

                //envia o id e o texto na requisição, em formato de forData (chave e valor)
                //FormData(name, value);
                //forma de enviar uma requisição
                let data = new FormData();
                data.append('id', id); //envia o id, com a chave id
                data.append('txt', txt); //envia o txt, o que foi digitado, com nome de txt

                //faz a requisição para inserir no banco de dados
                //daqui, vai para o AjaxController.php, função comment
                let req = await fetch(BASE+'/ajax/comment', {
                    method: 'POST',
                    body: data
                    /*
                    method: 'POST',
                    body: {
                        'id': id,
                        'txt', txt
                    }
                    */
                });
                //recebe a resposta em json, verificando se deu erro
                //essa resposta passa pelo AjaxController.php, o qual retornará o link, avatar, name e o body
                let json = await req.json();

                //se a requisição de inserir um comentário não der erro, então insere na tela
                //insere uma nova div de comentário
                if(json.error == '') {
                    let html = '<div class="fic-item row m-height-10 m-width-20">';
                    html += '<div class="fic-item-photo">';
                    html += '<a href="'+BASE+json.link+'"><img src="'+BASE+json.avatar+'" /></a>';
                    html += '</div>';
                    html += '<div class="fic-item-info">';
                    html += '<a href="'+BASE+json.link+'">'+json.name+'</a>';
                    html += json.body;
                    html += '</div>';
                    html += '</div>';

                    item.closest('.feed-item')
                        .querySelector('.feed-item-comments-area')
                        .innerHTML += html;
                }
            }
        });
    });
}
