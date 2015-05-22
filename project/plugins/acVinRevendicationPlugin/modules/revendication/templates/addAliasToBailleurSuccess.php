<!-- #principal -->
    <section id="principal">
        <p id="fil_ariane"><strong>Page d'accueil</strong></p>
        
        <!-- #contenu_etape -->
        <section id="contenu_etape">
            <form method="POST" action="<?php echo url_for('revendication_add_alias_to_bailleur',array('odg' => $revendication->odg, 'campagne' => $revendication->campagne, 
                'identifiant' => $etablissement->identifiant, 'alias'=>$alias)); ?>" >
                
                <h2>Choisir un bailleur correspondant à <?php echo $alias; ?> pour <?php echo $etablissement->nom; ?></h2>
                <?php echo $form->renderGlobalErrors(); ?>
                <?php echo $form->renderHiddenFields(); ?>
				
				<div class="section_label_maj" id="recherche_operateur">
					<label><?php echo $alias; ?></label>
					<?php echo $form['bailleur']->render(); ?>
					
					<button class="btn_majeur btn_valider" type="submit">Valider</button>
				</div>
            <div class="btn_etape">
                <a class="btn_majeur btn_annuler" href="<?php echo url_for('revendication_view_erreurs', $revendication); ?>"><span>Annuler</span></a>
                <a class="btn_majeur btn_ajouter" target="_blank" href="<?php echo url_for('etablissement_modification', array('identifiant' => $etablissement->identifiant));?>"><span>Créer un bailleur</span></a>
            </div>
            </form>
        </section>
        <!-- fin #contenu_etape -->
    </section>
    <!-- fin #principal -->
    <?php
slot('colButtons');
?>
<div id="action" class="bloc_col">
    <h2>Action</h2>
    <div class="contenu">
        <div class="btnRetourAccueil">
            <a href="<?php echo url_for('revendication'); ?>" class="btn_majeur btn_acces"><span>Retour à l'accueil</span></a>
        </div>
    </div>
    <div class="contenu">
        <div class="btnRetourAccueil">
            <a href="<?php echo url_for('revendication_view_erreurs',array('odg' => $revendication->odg, 'campagne' => $revendication->campagne)); ?>" class="btn_majeur btn_acces"><span>Retour aux erreurs</span></a>
        </div>
    </div>
</div>
<?php
end_slot();
?>
