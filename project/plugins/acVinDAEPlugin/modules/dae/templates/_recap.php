<table  class="table table-striped table-filter">
	<thead>
		<tr>
			<th>Produit</th>
			<th>Millésime</th>
			<th>Destination</th>
			<th>Clients</th>
			<th>Condi.</th>
			<th>Qté</th>
			<th>Prix HT</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($daes as $id => $dae): ?>
		<tr>
			<td><strong><?php echo $dae->produit_libelle ?></strong><?php if ($dae->label_libelle): ?><br /><span class="text-muted"><?php echo $dae->label_libelle ?></span><?php else: ?><br />&nbsp;<?php endif; ?></td>
			<td><?php echo $dae->millesime ?></td>
			<td><?php echo $dae->destination_libelle ?></td>
			<td><?php echo $dae->type_acheteur_libelle ?></td>
			<td><?php echo $dae->contenance_libelle ?></td>
			<td class="text-right"><?php echo $dae->quantite ?>&nbsp;<span class="text-muted"><?php if ($dae->conditionnement_key == 'BOUTEILLE'): ?>btl<?php elseif ($dae->conditionnement_key == 'BIB'): ?>bib<?php else: ?>hl<?php endif; ?></span></td>
			<td class="text-right"><?php echo $dae->prix_unitaire ?>&nbsp;<span class="text-muted">€&nbsp;<?php if ($dae->conditionnement_key == 'BOUTEILLE'): ?>btl<?php elseif ($dae->conditionnement_key == 'BIB'): ?>bib<?php else: ?>hl<?php endif; ?></span></td>
			<td><a href="<?php echo url_for('dae_nouveau', array('identifiant' => $dae->identifiant, 'id' => $dae->_id, 'periode' => $dae->date)) ?>"><span class="glyphicon glyphicon-edit"></span></a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>