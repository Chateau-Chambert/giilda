<div class="list-group">
    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-10">
                <h3><span class="<?php echo comptePictoCssClass($compte->getRawValue()) ?>"></span> <?php echo ($compte->nom_a_afficher) ? $compte->nom_a_afficher : $compte->nom; ?></h3>
            </div>
            <div class="col-xs-2 text-right">
	    <div class="btn-group">
	      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	        Modfier
	        <span class="caret"></span>
	      </a>
	      <ul class="dropdown-menu">
		<li<?php echo ($compte->getSociete()->isSuspendu() || $compte->isSuspendu()) ? ' class="disabled"' : '' ; ?>><a href="<?php echo ($compte->getSociete()->isSuspendu() || $compte->isSuspendu()) ? 'javascript:void(0)' : url_for('compte_modification', $compte); ?>">Editer</a></li>
		<li<?php echo ($compte->getSociete()->isSuspendu() || $compte->isSuspendu()) ? ' class="disabled"' : '' ; ?>><a href="<?php echo ($compte->getSociete()->isSuspendu() || $compte->isSuspendu()) ? 'javascript:void(0)' : url_for('compte_switch_statut', array('identifiant' => $compte->identifiant)); ?>">Suspendre</a></li>
                <li<?php echo ($compte->getSociete()->isSuspendu() || $compte->isActif()) ? ' class="disabled"' : '' ; ?>><a href="<?php echo ($compte->getSociete()->isSuspendu() || $compte->isActif()) ? 'javascript:void(0)' : url_for('compte_switch_statut', array('identifiant' => $compte->identifiant)); ?>">Activer</a></li>
	      </ul>
	    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <span class="label label-primary"><?php echo $compte->fonction; ?></span>&nbsp;
                <?php if ($compte->isSuspendu()): ?>
                    <span class="label label-danger"><?php echo $compte->statut; ?></span>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php if ($compte->isSameAdresseThanSociete()): ?>
        <div class="list-group-item list-group-item-xs text-center text-muted disabled">
            <em>Même Adresse que la société</em>
        </div>
    <?php else : ?>
        <div class="list-group-item list-group-item-xs text-center ">
            <div class="row">
                <?php include_partial('compte/adresseVisualisation', array('compte' => $compte, 'modification' => $modification, 'reduct_rights' => $reduct_rights, 'smallBlock' => true)); ?>
            </div>
        </div>        
    <?php endif; ?>
    <?php if ($compte->isSameContactThanSociete()): ?>
        <div class="list-group-item list-group-item-xs text-center text-muted disabled">
            <em>Même contact que la société</em>
        </div>
    <?php else : ?>
        <div class="list-group-item list-group-item-xs text-center ">
            <div class="row">
                <?php include_partial('compte/contactVisualisation', array('compte' => $compte, 'modification' => $modification, 'reduct_rights' => $reduct_rights, 'smallBlock' => true)); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="list-group-item list-group-item-xs ">
        <?php include_partial('compte/tagsVisualisation', array('compte' => $compte, 'modification' => $modification, 'reduct_rights' => $reduct_rights, 'smallBlock' => true)); ?>
    </div>

</div>
