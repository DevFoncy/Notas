<?php require 'inc/cabecera.inc'; 
	   require 'conexion.php';
	    require 'Database.php';

		$curso_m = $_POST['curso'];
		$turno_m = $_POST['turno'];
		$nombre_m = $_POST['nombre'];
		$seleccion_m = $_POST['sel'];
		$codigo_profe=$_POST['cod_profe'];


		if($seleccion_m == "ef"){
				    		$name_tipo = "ex_final";
				    	}
				    	else{
				    		if($seleccion_m == "ep"){
				    		$name_tipo= "ex_parcial";
				    		}
				    		else{
				    			if($seleccion_m == "p1"){
				    				$name_tipo = "pc1";
				    			}
				    			else{
				    				if($seleccion_m == "p2"){
								    		$name_tipo= "pc2";
								    	}
								    	else{
								    		if($seleccion_m == "p3"){
									    		$name_tipo = "pc3";
									    	}
									    	else{
												if($seleccion_m == "p4"){
										    		$name_tipo= "pc4";
										    	}
										    	else{
										    		if($seleccion_m == "lab"){
											    		$name_tipo = "laboratorio";
											    	}
											    	else{
											    		if($seleccion_m == "s"){
												    		$name_tipo = "susti";
												    	}
											    	}

										    	}

									    	}

								    	}

				    			}
				    		}

				    	}

	  $conex2= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	  $conex2->preparar("SELECT $name_tipo FROM profesor_curso  WHERE codigo_turno='$turno_m' and codigo_curso='$curso_m' and codigo_profesor='$codigo_profe'");
	  $conex2->ejecutar();
	  $conex2->prep()->bind_result($aviso);

	  while($conex2->resultado()){
	  			$var=$aviso;                  
			}

	echo $codigo_profe;
	echo $var;
	echo $curso_m;

?>

<script type="text/javascript">
	
	function prueba(nota){
		nota=document.getElementById(nota);
		if(nota.value==""){
		alert("XD");	
		}
		else{
		alert("dX");
			
		}
	
	}
	


</script>
<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-7 col-sm-offset-2">
					<div class="panel-body">
				     <table class="table table-bordered">
		                  <tr class="info">
		                    <td>
								<h2><img src="img/calificar.png" width="80" height="80">Listado de Alumnos del Grupo <?php echo " ".$turno_m."(".$name_tipo.")" ?> </h2>
								<h4>Curso : <?php echo $nombre_m ?></h4>								
		                    </td>
		                  </tr>
                	</table> 

<?php require 'confirmacion.js' ?>
<?php 
		
	
      //  $iterador=0;
    
		$conex2->preparar("SELECT m.codigo_alumno, CONCAT(a.apellido_paterno,' ',a.apellido_materno,' ',a.nombre_alumno), n.codigo_nota  FROM matricula m , alumno a, nota n WHERE n.codigo_curso='$curso_m' and m.codigo_turno='$turno_m' and m.codigo_alumno=a.codigo_alumno and n.codigo_alumno=m.codigo_alumno and m.codigo_docente='$codigo_profe' ORDER BY a.apellido_paterno");
		$conex2->ejecutar();
		$conex2->prep()->bind_result($cod_alum1,$nombre_alum1, $codigo_nota1);

		 echo "<table class='table table-bordered'>
								 		 		<thead>
								 		 			<tr class='info'>

								 		 			<td> <strong> CODIGO </strong></td>

								 		 			<td> <strong>APELLIDO Y NOMBRES DEL ALUMNO </strong> </td>

								 		 			<td> <strong> NOTA  </strong></td>

								 		 			</tr>
								 		 		 <tbody>
								 		 	  ";
	    echo "<form name='formAjax' action='probando.php' method='POST' id= 'formAjax' onsubmit='prueba('nota')'>";	
		
	    
	    echo "<div id='dialogoFormulario' title='Atención' style='display:none;'>
				<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'>
				</span>¿Realmente desea enviar el contenido de este formulario?</p>
			</div>
		";
		$i=0;
		while($conex2->resultado()){
			if($var==1){
				echo "
				  <tr>
				  		 <td>$cod_alum1</td>
						 <td>$nombre_alum1</td>
						 <td> <input type='number' name='tipo_examen[]' disabled> </td>
				  </tr>

				
		  ";
			}
			else{
				echo "
				  <tr>
				  		 <td>$cod_alum1</td>
						 <td>$nombre_alum1</td>
						 
						 <td> <input type='number' name='tipo_examen[]' id=nota min=0 max= 20 required> 
						 	<span></span>
						 </td>

						 <input type='text' name='codigo_nota[]' value='$codigo_nota1' hidden >
						 <input type='text' name='seleccion' value='$name_tipo' hidden >			 
						 <input type='text' name='codigo_profe' value='$codigo_profe' hidden>	
						 <input type='text' name='codigo_turno' value='$turno_m' hidden>	
						 <input type='text' name='codigo_curso' value='$curso_m' hidden>			 
						 		
				  </tr>


				
		  ";
		         $i++;
		    
			}
			
		  //array_push($array,"ex_parcial");
		
		}
			echo "Se cargaron ".$i." registros";
		//$_SESSION['array'] = $array;
	          
		echo " </tbody>
	           </table>";
        
        if($var==1){
        					echo "<div class='alert alert-warning'>
								  <h4 href='#'' class='alert-danger' align='center'> Usted ya registro nota aca </h4>
						</div>";

        		echo  " <div align='right'  role='toolbar'>
								   <div class='btn-group'>
								    <a type='button' class='btn btn-default'>
								      <span class='glyphicon glyphicon-phone-alt'></span> Solicitar Cambio de notas 
								    </a>
								     </form>
	           			</div>
	           			
	           ";
	    
        }
        else{
        		echo  " <div align='right'  role='toolbar'>
								  
								  <div class='btn-group'> 
								    <input id='' class='boton' type='submit' value='Continuar' hidden></input>
								    
								    <button id=formu class='btn btn-default' value='Continuar' >
								      <span class='glyphicon glyphicon-floppy-disk'></span> Guardar Notas 
								    </button>
								    
								     </form>
	           </div>
	          
	           ";
	    
        }
         $conex2->cerrar_conex();
	   ?>

			 		</div>
				</div>    	 		</div>


			</div>

<?php
 require 'inc/footer.inc'; ?>
	