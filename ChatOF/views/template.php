<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<meta name="viewport" content="width=device-width,initial-scale=1" /> <!--largura do dispositivo-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css" />
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php $this->loadViewInTemplate($viewName, $viewData); ?>


<div class="modal_bg" style="display:none"> <!--area total que escurece a tela -->
	<div class="modal_area"> <!--janela do modal-->
		...
	</div>
</div>

<script type="text/javascript">
var BASE_URL = '<?php echo BASE_URL; ?>'; //transefere daddos do PHP para o JavaScript 
var group_list = <?php echo json_encode($viewData['current_groups']); ?>;
</script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/chat.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</body>
</html>