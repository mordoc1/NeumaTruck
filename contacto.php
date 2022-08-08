<?php
session_start();
require('funciones/conexion.php');
require('funciones/funciones.php');
if(!isset($_SESSION)) {
  if(!isset($_SESSION["idunica"])){
	 $_SESSION["idunica"]  = GeneraId(15);}
}
//-INFO BASICA
$url				= "Contacto";
$pmenu				= "Contacto";
$pagina 			= title_web($url);
?>
<!DOCTYPE html>
<html lang="es">
		<head>
			<?php include_once("includes/head.inc.php"); ?>

			<link rel="stylesheet" type="text/css" href="<?echo _GetDomain; ?>css/main.css">
		</head>
<body>
<?php include 'includes/body.inc.php'; ?>
		<!-- HEADER -->
		<?php include('includes/header.php'); ?>
		<!-- /HEADER -->
		<?php include('includes/social.php'); ?>
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="<?echo _GetDomain; ?>">Portada</a></li>
							<li><a href="javascript:void(0);"><?php echo $url; ?></a></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-7">
					<form action="#" class="contact-form" enctype="application/x-www-form-urlencoded" method="post">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Datos</h3>
							</div>
							<div class="form-group">
								<input id="name" class="input" type="text" name="name" placeholder="Nombre"required>
							</div>
							<div class="form-group">
								<input id="email" class="input" type="email" name="email" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input id="phone" class="input" type="phone" name="subject" placeholder="Telefono" maxlength="100" required>
							</div>
							<div class="form-group">
								<input id="asunto" class="input" type="text" name="subject" placeholder="Asunto" maxlength="100" required>
							</div>
							<div class="form-group">
								<textarea id="text-contac" class="input" name="message" placeholder="Mensaje"></textarea>
								<input type="hidden" name="enviado" value="enviado">
							</div>
						</div>
					
						

						
					</form>
					<br>

                    <div>
				
						<form id="form-img" action="./funciones/upload-photo.php" method="post" enctype="multipart/form-data">
							<label for="">Ingresar Imagen</label>
							 <input onchange="update_file()" id="img-photo" type="file" name="image" accept="image/*;capture=camera" data-buttonText="Your label here."><br>
							<!-- <button id="btn-envio" type="submit" class="btn btn-primary">Subir Imagen</button> -->
							<button id="btn-delete" onclick="delete_photo()" type="button" class="btn btn-danger" style="display:none">Eliminar</button>
						</form>
                    </div>
							 
                    
					<form action=""><br>
						<button onclick="send_contact_email(event)" class="primary-btn order-submit" type="submit">Enviar Consulta </button>
					</form>

				</div>
               
				<!-- Order Details -->
				<div class="col-md-5">
					<div class="section-title text-center">
						<img src="img/img_contacto.jpg" class="img-responsive">
					</div>
				</div>
				<!-- /Order Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<video id="video" autoplay="autoplay" class="video_container none"></video>

	</div>
	<!-- /SECTION -->
	<?php include('includes/footer.php'); ?>
	<script src="./js/camara.js"></script>
</body>
<script>

	function send_contact_email(e){
		e.preventDefault();
		let name_foto = document.getElementById("img-photo").value;
		let name = document.getElementById("name").value;
		let email = document.getElementById("email").value;
		let asunto = document.getElementById("asunto").value;
		let text = document.getElementById("text-contac").value;
		let phone = document.getElementById("phone").value;
		let correccion = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
		if(name == "" || email == "" || asunto == ""){
			Swal.fire('Error','Debe llenar todos lo campos','error');
		}else if(!correccion.exec(email)){
			Swal.fire('error','El email es invalido','error');
		}else{
			const send_contact = new Promise((resolve, rejected) =>{
				let parametros = {"name": name, "email" : email, "asunto" : asunto, "text" : text, "phone" : phone, "name_foto" : name_foto};
				$.ajax({
                data: parametros,
                type: "POST",
                url:  "./funciones/send_contact.php",   
                beforeSend:function(){
                    Swal.fire({
                        html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                        title: 'Enviando..',
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: false,
                        showConfirmButton:false,
                    })
                    $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
                    $(".swal2-title").css("color","white"); 
                },
                success:function(response){
                    resolve(response);
                }
            });
			});
			
			send_contact.then(res=>{
				swal.close();
				if(res == "enviado"){
					Swal.fire('Email','Email enviado correctamente','success');
					document.getElementById("name").value = "";
					document.getElementById("email").value = "";
					document.getElementById("asunto").value = "";
					document.getElementById("text-contac").value = "";
					document.getElementById("img-photo").value = '';
					document.getElementById("phone").value = "";
					document.getElementById("btn-delete").style.display="none";
				}else{
					Swal.fire('Error','Ocurrio un error intente mas tarde','error');
				}
			})
		
		}
	}
    // SCRPT PARA TOMAR FOTOS




</script>
</html>
