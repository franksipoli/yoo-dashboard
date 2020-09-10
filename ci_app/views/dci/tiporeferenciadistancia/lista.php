 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tiporeferenciadistancia","inserir")?>" class="btn btn-sm btn-success">Inserir novo tipo de referência de distância</a>
		</div>
	</div>
</div>
<div class="row">
   <div class="col-xs-12">
      <div class="panel panel-default">
         <div class="panel-body">
         	<?php
           		$this->load->view('general/messages');
           ?>
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Tipo de Referência de Distância</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($tipos as $tipo){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $tipo->cnometrd?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dci","tiporeferenciadistancia","editar","?id=".$tipo->nidtbxtrd)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dci","tiporeferenciadistancia","excluir","?id=".$tipo->nidtbxtrd)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o tipo de referência de distância <?php echo $tipo->cnometrd?>?">Remover</a>
		                        </td>
		                     </tr>
                  		<?php
                  		$i++;
                  	}
                  	?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END row-->
</div>