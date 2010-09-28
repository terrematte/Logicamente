<?php
# Função Recursiva, geradora da visualização da árvore.
# The function who generate the view of the tree, that is Recursive.
function viewTree($nodeView){
?>

	<table cellpadding="0" cellspacing="0">
	<tr height="35">
    <?php 
	# Verifica se o node é uma folha, para a mudança de cor.
	# Verify if the node has children, if not, change the color of node.
	if(count($nodeView->children) > 0){ 
	?>
    	<td width="20"><img src="images/Tree_Left.jpg" width="20" height="35"></td>
	  	<td align="center" background="images/Tree_bg.jpg" class="style1" width="100%">
				<?php 
					echo $nodeView->content->content; 
				?>
        </td>
        <td width="20"><img src="images/Tree_Right.jpg" width="20" height="35"></td>
        
        <?php 
		} else {
			$content = $nodeView->content->content;
		?>
        <td width="20"><img src="images/Tree_Left2.jpg" width="20" height="35"></td>
	  	<td align="center" background="images/Tree_bg2.jpg" class="style1" width="100%">
				<?php 
					echo "$content"; 
				?>
        </td>
        <td width="20"><img src="images/Tree_Right2.jpg" width="20" height="35"></td>
        <?php } ?>
    </tr>
				<?php
				# Verifica novamente se existem filhos, para gerar a visualização dos mesmos.
				# Check again if the node have children, to show they.
					if(count($nodeView->children) > 0) {
						?>
                <tr>
              	<td colspan="3" align="center" valign="top" width="100%">
                        	<table width="100%" cellpadding="0" cellspacing="0">
                           	  <tr align="center">
                        <?php
						# Para cada filho, sera colocado uma imagem de traço, e apos quebrar a linha, a estrutura do filho.
						# For Each children, will be show an trace, and the struct of next node.
						foreach($nodeView->children  as $c) {
							?>
							<td height="11" align="center" valign="top"><img src="images/Trace.jpg" width="4" height="11"><br><?php viewTree($c); ?></td>
                         <?php
						 }
						 ?>
                        	</tr>
                        </table>
                  </td>
                  </tr>
                  <?php 
					}
				?>
    </table>
          <?php
}
?>
