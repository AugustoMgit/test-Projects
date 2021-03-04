<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css" />
    <title>Gcity</title>
</head>
<body>
    
<header class="header-init">
    <div class="view-main-header">
        <div class="view-name--info">
            <?= $dataUser->name ?>
            
            <?= $dataUser->second_name ?>
            <?= $dataUser->avatar ?>
        </div>
        <!-- -->
        <div class="main-center">
            <div class="view-destaques--important">
                DESTAQUES <bR>(+++ IMPORTANTE)
            </div>
            <div class="view-options">
            </div>
        </div>
        <div class="locale-now">
            locale<br>
            <button onclick="getLocation()">Clique Aqui</button>
            Coordenadas<br>
            <span id="demo">
            </span>
        </div>    
        <!-- -->
        <div class="view-publish--main">
            <button type="input" onclick="WindowNewPublish()">Publicar</button>
            <label for="type">Selecione</label>
            <select id="type">
                <option value="opcaoo1">1</option>
                <option>1</option>
            </select>
        </div>
    </div>
    <div class="window-publis-container">
        <!--area da publicação -->
        <div class="windowsPublishMain">
            <div class="area-line--info">
                <div class="info-first--publish">
                    <div class="info-city">
                        Cidade(s) do usuárioaaaaaaaaaa
                    </div>
                    <div class="close-publish" onclick="closeWindowPublish()">X</div>
                    <div class="info-type--publish">
                        <label for="info-type--publish">Selecione</label>
                        <select id="type-publish" onchange="selectValue(this);">
                            <option value="critica">Crítica</option>
                            <option value="noticia">Notícia</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="area-digit" contenteditable="true"></div>
            <div class="footer-publish">
                <div class="footer-midia">
                    Colocar icones e ferramentas de edições
                </div>
                <div class="footer-publish">
                    <button class="button-publish" onclick="addNewPublish()">Publicar</button>
                </div>
            </div>
        </div>
    </div>   <!-- fim da area de publicação -->
</header>
    <script type="text/javascript" src="<?=$base;?>/assets/js/script.js"></script>
</body>
</html>