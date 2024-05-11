<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
        
        ?>
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD</title>

        <link rel="stylesheet" href="principal.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>
        
        <script src="principal.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <?php
    	
    	
    	   
    	   if (isset($_SESSION["nombre"])) {
    	       
    	       $j=false;
    	       
    	   }
    	   elseif (isset($_SESSION["usuario"])){
    	       
    	       $j=false;
    	   }
    	   else {
    	       
    	       header("location:index.php");
    	   }
    	
    	?>

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>

        <script src="principal.js"></script>
	
	</head>
	
	<body>
	
		<header class="background">
		
			<nav class="secondnav">
			
				<div class="nav-left">
				
					<div class="logo">
					
						<div class="loader">
						
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
						
						</div>
						
						<a href="index.php" id="logodos">MIXWORLD</a>
					
					</div>
				
				</div>
				
				<div class="nav-center">
				
					<form action="<?php $_SERVER["PHP_SELF"] ?>">
					
						<div class="search-box">
						
							<input type="search" placeholder="Buscar..." class="buscador" name="buscador">
        				
        					<span class="fas fa-search searchicon" id="searchicon"></span>
        					
        					<input type="submit" id="botonbusca" hidden="hidden">
        			
        				</div>
					
					</form>
				
				</div>
				
				<div class="nav-right">
				
					<label for="check">
				
						<span class="imagediv">
					
							<img src="/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["picture"] ?>" class="imguser"></img>
					
						</span>
					
					</label>
					
					<input type="checkbox" id="check" class="checkb">
					
					<div class="profileoptions">
					
						<ul class="list-profile">
					
							<li><a href="cuenta.php"><i class="fas fa-user"></i><span>Mi cuenta</span></a></li>
        				
        					<li><a href="favoritos.php"><i class="fas fa-star"></i><span>Favoritos</span></a></li>
					
						</ul>
					
					</div>	
				
				</div>
				
			</nav>
		
		</header>
		<section>
		
			<?php 
			
			 try {
			     
			     $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
			     
			     $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			     
			     $conexion->exec("SET CHARACTER SET utf8");
			     
			     $consulta="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.REPRODUCCIONES,c.LIKES,c.DISLIKES,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO";
			     
			     $resultado=$conexion->prepare($consulta);
			     
			     $resultado->execute();
			     
			     $consultalikescanciones="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
			     
			     $result=$conexion->prepare($consultalikescanciones);
			     
			     $consultadislikescanciones="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
			     
			     $resulttwo=$conexion->prepare($consultadislikescanciones);
			     
			     while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
			         
			         $result->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
			         
			         $resulttwo->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
			         
			         $cantidadlikescancion=$result->rowCount();
			         
			         $cantidaddislikescancion=$resulttwo->rowCount();
			         
			         ?>
			         
			         <div class="songcontainer">
			         
			         	<div class="imagecontainer">
			         	
			         		<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
			         	
			         	</div>
			         	<div class="titleplayercontainer">
			         	
			         		<div class="titlecontainer">
			         		
			         			<span><?php echo $fila["TITULO"]; ?></span>
			         		
			         		</div>
			         		<div class="usercontainer">
			         		
			         			<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
			         			
			         			<span><?php echo $fila["USUARIO"]; ?></span>
			         		
			         		</div>
			         		<div class="playercontainer">
			         		
			         			<div class="playicon">
			         			
			         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
			         				
			         				<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
			         			
			         			</div>
			         			
			         			<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
			         			
			         				<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
			         			
			         			</div>
			         		
			         		</div>
			         		<div class="likescontainer">
			         		
			         			<span><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 if ($cantidadlikescancion<1) {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			 if($cantidaddislikescancion<1){
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			
			         			?>
			         		
			         		</div>
			         	
			         	</div>
			         
			         </div>
			         
			         <?php
			     }
			     
			 } catch (Exception $e) {
			     
			     die("Error: " . $e->getMessage());
			 }
			
			?>
		
		</section>
	
	</body>

</html>

