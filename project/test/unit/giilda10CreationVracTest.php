<?php

require_once(dirname(__FILE__).'/../bootstrap/common.php');

$t = new lime_test(16);
$t->comment("création d'un contrat viti/négo/courtier");

$vrac = new Vrac();
$etablissementcourtier = $societecourtier = CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_courtier')->getEtablissement();
$vrac->initCreateur($etablissementcourtier->getIdentifiant());
$vrac->teledeclare = true;
$vrac->acheteur_identifiant = CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_nego_region')->getEtablissement()->getIdentifiant();
$vrac->vendeur_identifiant =  CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_viti')->getEtablissement()->getIdentifiant();
$produits = array_keys(ConfigurationClient::getInstance()->getCurrent()->getProduits());
$vrac->setProduit(array_shift($produits));
$vrac->type_transaction = VracClient::TYPE_TRANSACTION_VIN_VRAC;
$vrac->jus_quantite = 100;
$vrac->setPrixUnitaire(70);
$vrac->save();
$t->is($vrac->valide->statut, VracClient::STATUS_CONTRAT_BROUILLON, $vrac->_id." : Création d'un brouillon");
$t->ok($vrac->produit_libelle, $vrac->_id." : Enregistrement du produit");
$t->is($vrac->volume_propose, 100, $vrac->_id." : Enregistrement du volue proposé");
$t->is($vrac->prix_total, 7000, $vrac->_id." : Enregistrement du prix");
$t->is($vrac->representant_identifiant, $vrac->vendeur_identifiant, $vrac->_id." : Le représentant est le vendeur si pas de représentant");
$t->is($vrac->cvo_repartition, "50", $vrac->_id." : Répartition 50/50 car négo");

$vrac->validate();
$vrac->save();
$t->isnt($vrac->valide->date_signature_courtier, null, $vrac->_id." : signature du courtier enregistrée");
$t->is($vrac->valide->statut, VracClient::STATUS_CONTRAT_ATTENTE_SIGNATURE, $vrac->_id." : après première signature (courtier), le contrat change de status");

$vrac->signatureByEtb(CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_nego_region')->getEtablissement());
$vrac->save();
$t->isnt($vrac->valide->date_signature_acheteur, null, $vrac->_id." : signature de de l'acheteur enregistrée");
$t->is($vrac->valide->statut, VracClient::STATUS_CONTRAT_ATTENTE_SIGNATURE, $vrac->_id." : après 2de signature (négo), le contrat reste en attente");

$vrac->signatureByEtb(CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_viti')->getEtablissement());
$vrac->save();
$t->isnt($vrac->valide->date_signature_vendeur, null, $vrac->_id." : signature du vendeur enregistrée");
$t->is($vrac->valide->statut, VracClient::STATUS_CONTRAT_VALIDE, $vrac->_id." : après 3ème signature (viti), le contrat passe à validé");

$t->comment("cas d'un contrat sans courtier avec négo hors région");
$vrac = new Vrac();
$vrac->initCreateur(CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_nego_horsregion')->getEtablissement()->getIdentifiant());
$vrac->teledeclare = true;
$vrac->vendeur_identifiant =  CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_viti')->getEtablissement()->getIdentifiant();
$produits = array_keys(ConfigurationClient::getInstance()->getCurrent()->getProduits());
$vrac->setProduit(array_shift($produits));
$vrac->type_transaction = VracClient::TYPE_TRANSACTION_VIN_VRAC;
$vrac->jus_quantite = 100;
$vrac->setPrixUnitaire(70);
$vrac->validate();
$vrac->signatureByEtb(CompteTagsView::getInstance()->findOneCompteByTag('test', 'test_viti')->getEtablissement());
$vrac->save();
$t->is($vrac->cvo_repartition, "100_VENDEUR", $vrac->_id." : Répartition 100 car négo hors région");
$t->isnt($vrac->valide->date_signature_acheteur, null, $vrac->_id." : signature de de l'acheteur enregistrée");
$t->isnt($vrac->valide->date_signature_vendeur, null, $vrac->_id." : signature du vendeur enregistrée");
$t->is($vrac->valide->statut, VracClient::STATUS_CONTRAT_VALIDE, $vrac->_id." : après la signature du viti, le contrat passe à validé");
