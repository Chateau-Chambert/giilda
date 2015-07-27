<?php

$urlForm = null;

if (($form->getObject()->isNew() && !isset($isTeledeclarationMode)) || ($form->getObject()->isNew() && !$isTeledeclarationMode)) :
    $urlForm = url_for('vrac_nouveau');
elseif ($form->getObject()->isNew() && isset($isTeledeclarationMode) && $isTeledeclarationMode) :
    if (isset($choixEtablissement) && $choixEtablissement):
        $urlForm = url_for('vrac_nouveau', array('choix-etablissement' => $choixEtablissement));
    else:
        $urlForm = url_for('vrac_nouveau', array('etablissement' => $etablissementPrincipal->identifiant));
    endif;
else :
    $urlForm = url_for('vrac_soussigne', $vrac);
endif;
?>

<?php include_component('vrac', 'etapes', array('vrac' => $form->getObject(), 'compte' => $compte, 'actif' => 1, 'urlsoussigne' => $urlForm,'isTeledeclarationMode' => $isTeledeclarationMode)); ?>

<form 
	id="contrat_soussignes" 
	data-numcontrat="<?php echo ($nouveau)? null : $form->getObject()->numero_contrat ;?>" 
	data-isteledeclare="<?php echo ($isTeledeclarationMode)? 1 : 0 ;?>" 
	data-etablissementprincipal="<?php if (isset($etablissementPrincipal) && $etablissementPrincipal) echo $etablissementPrincipal->_id ?>" 
	data-iscourtierresponsable="<?php echo (isset($isCourtierResponsable) && $isCourtierResponsable)? 1 : 0 ?>"
	action="<?php echo $urlForm; ?>" 
	method="post" 
	class="form-horizontal"
>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form['responsable']->renderError(); ?>
    <div class="row">
        <div class="col-sm-12">
        	<?php if(isset($form['attente_original'])): ?>
            <div class="form-group <?php if($form['attente_original']->hasError()): ?>has-error<?php endif; ?>">
                <?php echo $form['attente_original']->renderError(); ?>
                <?php echo $form['attente_original']->renderLabel("En attente de l'original :", array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-9">
                    <?php echo $form['attente_original']->render(); ?>
                </div>
            </div>
            <?php endif; ?>
        	<?php if(isset($form['type_contrat'])): ?>
            <div class="form-group <?php if($form['type_contrat']->hasError()): ?>has-error<?php endif; ?>">
                <?php echo $form['type_contrat']->renderError(); ?>
                <?php echo $form['type_contrat']->renderLabel("Contrat pluriannuel :", array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-9">
                    <?php echo $form['type_contrat']->render(); ?>
                </div>
            </div>
            <?php endif; ?>
        	<?php if(isset($form['type_transaction'])): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Type de transaction</h3>
                </div>
                <div class="panel-body">
                    <?php echo $form['type_transaction']->renderError(); ?>
                    <div class="form-group <?php if($form['type_transaction']->hasError()): ?>has-error<?php endif; ?>">
                        <div class="col-sm-12 text-center">
                            <?php echo $form['type_transaction']->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>            
            <div class="row">
        		<?php if(isset($form['vendeur_identifiant'])): ?>
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Vendeur
                            <?php if(isset($form['responsable'])): ?>
                            <label class="btn btn-xs btn-success pull-right<?php if($vrac->getOrAdd('responsable') == 'vendeur'): ?> active<?php endif; ?>">
							    <input autocomplete="off" type="radio" name="vrac[responsable]" id="vrac_responsable_vendeur" value="vendeur" autocomplete="off"<?php if($vrac->getOrAdd('responsable') == 'vendeur'): ?> checked<?php endif; ?> /><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</label>
							<?php endif; ?>
							</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-7">
                                    <?php echo $form['vendeur_identifiant']->renderError(); ?>
                                    <div class="form-group <?php if($form['vendeur_identifiant']->hasError()): ?>has-error<?php endif; ?>">
                                        <div class="col-sm-12" id="vendeur_choice">
                                            <?php echo $form['vendeur_identifiant']->render(array('class' => 'form-control select2', 'placeholder' => 'Séléctionner un vendeur')); ?>
                                        </div>
                                    </div>
        							<?php if(isset($form['vendeur_intermediaire'])): ?>
                		            <div class="form-group col-sm-12">
                		            	<?php echo $form['vendeur_intermediaire']->renderError(); ?>
                		                <div class="checkbox">
                		                	<label for="<?php echo $form['vendeur_intermediaire']->renderId(); ?>">
                		                    	<?php echo $form['vendeur_intermediaire']->render(); ?>
                		                        Representé par xxx pour la CVO
                		                    </label>
                		                </div>
                		            </div>
                		            <?php endif; ?>
        							<?php if(isset($form['logement'])): ?>
                                    <div class="form-group <?php if($form['logement_exist']->hasError()): ?>has-error<?php endif; ?>">
                		                <div class="col-sm-12">
                		                    <?php echo $form['logement_exist']->renderError(); ?>
                		                    <div class="checkbox bloc_condition" data-condition-cible="#bloc_logement">
                		                        <label for="<?php echo $form['logement_exist']->renderId(); ?>">
                		                            <?php echo $form['logement_exist']->render(); ?>
                		                            Décocher si logement du vin différent
                		                        </label>
                		                    </div>
                		                </div>
                		            </div>
                		            <div id="bloc_logement" data-condition-value="0" class="form-group bloc_conditionner <?php if($form['logement']->hasError()): ?>has-error<?php endif; ?>">
                		                <?php echo $form['logement']->renderError(); ?>
                		                <div class="col-sm-12">
                		                    <?php echo $form['logement']->render(array("placeholder" => "Ville du logement")); ?>
                		                </div>
                		            </div> 
                		            <?php endif; ?>
                                </div>
                                <div class="col-sm-5" id="vendeur_informations">
                                    <?php include_partial('vrac/vendeurInformations', array('vendeur' => $form->getObject()->getVendeurObject(), 'isTeledeclarationMode' => $isTeledeclarationMode)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
        		<?php if(isset($form['acheteur_identifiant'])): ?>
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Acheteur
                            <?php if(isset($form['responsable'])): ?>
                            <label class="btn btn-xs btn-success pull-right<?php if($vrac->getOrAdd('responsable') == 'acheteur'): ?> active<?php endif; ?>">
							    <input autocomplete="off" type="radio" name="vrac[responsable]" id="vrac_responsable_acheteur" value="acheteur" autocomplete="off"<?php if($vrac->getOrAdd('responsable') == 'acheteur'): ?> checked<?php endif; ?> /><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</label>
							<?php endif; ?>
							</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-7">
                                    <?php echo $form['acheteur_identifiant']->renderError(); ?>
                                    <div class="form-group <?php if($form['acheteur_identifiant']->hasError()): ?>has-error<?php endif; ?>">
                                        <div class="col-sm-12" id="acheteur_choice">
                                            <?php echo $form['acheteur_identifiant']->render(array('class' => 'form-control select2', 'placeholder' => 'Séléctionner un acheteur')); ?>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-5" id="acheteur_informations">
                                    <?php include_partial('vrac/acheteurInformations', array('acheteur' => $form->getObject()->getAcheteurObject(), 'isTeledeclarationMode' => $isTeledeclarationMode)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        	<?php if(isset($form['mandataire_identifiant'])): ?>
            <?php echo $form['mandataire_exist']->renderError(); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title checkbox"><label class="bloc_condition col-xs-12" data-condition-cible="#bloc_mandataire"  for="<?php echo $form['mandataire_exist']->renderId(); ?>"><?php echo $form['mandataire_exist']->render(); ?>&nbsp;Mandataire / Courtier</label>
                    <?php if(isset($form['responsable'])): ?>
                    <label class="btn btn-xs btn-success pull-right<?php if($vrac->getOrAdd('responsable') == 'mandataire'): ?> active<?php endif; ?>">
						<input autocomplete="off" type="radio" name="vrac[responsable]" id="vrac_responsable_mandataire" value="mandataire" autocomplete="off"<?php if($vrac->getOrAdd('responsable') == 'mandataire'): ?> checked<?php endif; ?> /><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					</label>
					<?php endif; ?>
					</h3>
                </div>
                <div id="bloc_mandataire" data-condition-value="1" class="panel-body bloc_conditionner">
                    <div class="row">
                        <div class="col-sm-8">
                            <?php echo $form['mandataire_identifiant']->renderError(); ?>
                            <div class="form-group <?php if($form['mandataire_identifiant']->hasError()): ?>has-error<?php endif; ?>">
                                <div class="col-sm-12" id="mandataire_choice">
                                    <?php echo $form['mandataire_identifiant']->render(array('class' => 'form-control select2', 'placeholder' => 'Séléctionner un mandataire')); ?>
                                </div>
                            </div>
                            <?php if (isset($form['commercial'])): ?>
                            <?php echo $form['commercial']->renderError(); ?>
                            <div class="form-group <?php if($form['commercial']->hasError()): ?>has-error<?php endif; ?>">
                                <?php echo $form['commercial']->renderLabel("Mandaté par :", array('class' => 'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
                                    <?php echo $form['commercial']->render(array('class' => 'form-control')); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-4" id="mandataire_informations">
                            <?php include_partial('vrac/mandataireInformations', array('mandataire' => $form->getObject()->getMandataireObject(), 'isTeledeclarationMode' => $isTeledeclarationMode)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 text-left">
            <?php if ($isTeledeclarationMode): ?>
                <a tabindex="-1" href="<?php echo url_for('vrac_societe', array('identifiant' => $etablissementPrincipal->identifiant)); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Annuler la saisie</a> 
            <?php else: ?>                        
                <a tabindex="-1" href="<?php echo url_for('vrac'); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Annuler la saisie</a> 
            <?php endif; ?>
        </div>
        <div class="col-xs-4 text-center">
            <?php if ($isTeledeclarationMode && $vrac->isBrouillon()) : ?>
                <a tabindex="-1" class="btn btn-default" href="<?php echo url_for('vrac_supprimer_brouillon', $vrac); ?>">Supprimer le brouillon</a>
            <?php endif; ?>  
        </div>
        <div class="col-xs-4 text-right">
            <button type="submit" class="btn btn-success">Étape suivante <span class="glyphicon glyphicon-chevron-right"></span></button>
        </div>
    </div>
</form>

<?php
if ($isTeledeclarationMode):
    include_partial('colonne_droite', array('societe' => $societe, 'etablissementPrincipal' => $etablissementPrincipal));
else:
    slot('colApplications');
    /*
     * Inclusion du panel de progression d'édition du contrat
     */
    if (!$contratNonSolde)
        include_partial('contrat_progression', array('vrac' => $vrac));

    /*
     * Inclusion des Contacts
     */
    end_slot();
endif;
?>
 