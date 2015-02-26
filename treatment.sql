-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 24 Février 2015 à 18:48
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cvi`
--

-- --------------------------------------------------------

--
-- Structure de la table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
`treatment_id` int(11) NOT NULL,
  `treatment_name` text NOT NULL,
  `treatment_title` text NOT NULL,
  `treatment_description` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `treatment_name`, `treatment_title`, `treatment_description`) VALUES
(18, 'adulte_tiorfanor', 'TRAITEMENT en cas de DIARRHEE de l''ADULTE', '         <div id="traitement">             <p>                 <ol >                     <li>Réhydratation orale et régime anti-diarrhéique adapté (riz, bananes…)<br/>  <span> </span>                         <ol><br/>                                 <li>TIORFANOR &reg;<br/>1 comprimé  à la 1ère diarrhée, puis 1 comprimé matin et soir  si la diarrhée persiste.                              </li><br/>                          </ol><br/>                     </li>                     <li><b>Si la diarrhée est grave</b> : d''emblée sévère (fièvre, sang ou glaire dans les selles, très liquide…) ou persistante au-delà de 24 heures avec plus de 4 selles par jour : <b>Consultation médicale sur place</b>                     </li>                 </ol>             </p>         </div>'),
(19, 'adulte_doxy_ge_100mg', 'PROPHYLAXIE CONTRE LE PALUDISME ', ''),
(20, 'adulte_lariam', 'PROPHYLAXIE CONTRE LE PALUDISME  Adulte - enfants > 15 kgs', ' <div id="traitement">                           <p><b><u>LARIAM 250 mg</u></b></p><br/>                           <p><span>[  ] comprimé  par semaine en une seule prise </span><br/></p>                         <span>1ère prise : commencer 10 jours avant l’arrivée dans la zone à risque</span><br/>                         <span>2ème prise : 3 jours avant le départ</span><br/>                         <span>Continuer à jour fixe pendant tout le séjour et les 3 semaines suivant le retour.</span><br/>                         <span><b>Ne pas dépasser la dose prescrite, ne pas laisser à la portée des enfants : </b></span>                          <ul style="list-style-type: circle;">                                                          <li><b>15-19 kg</b> : 1/4 cp / semaine</li>                                                          <li><b>20-30 kg</b> : 1/2 cp / semaine</li>                                                          <li><b>31/45 kg</b> : 3/4 cp / semaine</li>                                                          <li><b>45 kg et + </b> : 1 cp / semaine</li>                                                  </ul>              </div>'),
(21, 'adulte_ciflox', 'TRAITEMENT en cas de DIARRHEE de l''ADULTE', '                <div id="traitement">                   <p>                     <p><b>CIFLOX &reg; 500 :</b> 2 cpés en 1 prise unique      [ou 1 cpé matin et soir pendant 3 jours (Tt de sécurité)] </p><br/>                      <span><b>Pas d''exposition solaire pendant la durée de ce traitement. </b></span><br/>                     <span><b>Arrêt du traitement si tendinite </b></span><br/>                     <span><b>Ne pas dépasser la dose prescrite, ne pas laisser à la portée des enfants </b></span>                 </p>'),
(22, 'adulte_zithromax', 'TRAITEMENT en cas de DIARRHEE de l''ADULTE', '                        <div id="traitement">                               <p><p><b>ZITHROMAX &reg; 250 :</b> 2 comprimés 3 jours de suite</p><br/>                                                  <span><b>Pas d''exposition solaire pendant la durée de ce traitement. </b></span><br/>                             <span><b>Ne pas dépasser la dose prescrite, ne pas laisser à la portée des enfants</b></span><br/>                                                  <span><b>Eviter au 1er trimestre de la grossesse</b></span>                                          </p>                      </div>'),
(23, 'adulte_atovaquone_proguanil_250_100mg', 'PROPHYLAXIE CONTRE LE PALUDISME ', '<div id="traitement">                           <p><b><u>ATOVAQUONE / PROGUANIL 250 mg / 100 mg</u></b></p><br/>                          <ul>                             <li><span>Prendre 1 comprimé le jour d’arrivée dans la zone à risque</span><br/></li>                             <li><span>Puis 1 comprimé chaque jour pendant tout le séjour en zone exposée au paludisme</span></li>                             <li><span>Continuer à la même dose pendant 7 jours après le retour</span><br/><br/></li>                             <li><span><b>A prendre avec un repas ou une boisson lactée, à heure fixe.</b></span></li>                         </ul>                                               <p><b>Ne pas dépasser la dose prescrite, ne pas laisser à la portée des enfants</b></p><br/>                                   </div>'),
(24, 'enfant_tiorfanor_sachet', 'TRAITEMENT en cas de DIARRHÉE de l''ENFANT - NOURRISSON', '<div id="traitement">             <p style=''width:90%;''>Consulter un médecin sur place, le plus tôt possible et ne pas hésiter à reconsulter si la diarrhée persiste, si l’enfant refuse de boire ou s’il vomit. </p>              <p>                 <ol >                     <li><b>Dans tous les cas,</b><br/>  <span> </span>                         <ol><br/>                                 <li>Un sel de <b>RÉHYDRATATION ORALE</b> (type ADIARIL, GES45, FANOLYTE, VIATOL  sachets…) : 1&nbsp;sachet dans 200 ml d’eau minérale (1 biberon gradué à 200 ml), à donner à volonté en petites quantités (30 ml) toutes les 10 minutes sans limitation. Ne pas arrêter l’allaitement au sein. Si l’enfant est au biberon, utiliser le soluté de réhydratation seul pendant 4 heures puis réalimenter avec le lait habituel.<br/> <span> </span>                             </li>                             <li><b>RÉGIME ANTIDIARRHEIQUE (riz, bananes, pommes-coing)</b></li>                          </ol><br/>                     </li>                     <li><b>En cas de diarrhée aqueuse : TIORFAN sachets</b> : 1ère prise double dose puis 1 dose toutes les 8  heures : <br/>  <span> </span>                         <ul style="list-style-type: circle;">                             <li><b>de 3 mois jusqu’à 9 kg </b>: 1 sachet Nourrisson 3 fois/jour</li>                             <li><b>de 9 à 13 kg </b>: 2 sachets Nourrisson 3 fois/jour</li>                             <li><b>de 13 à 27 kg </b>: 1 sachet Enfant 3 fois/jour</li>                             <li><b>au-delà </b>: 2 sachets Enfant 3 fois/jour</li>                         </ul>  <br/>  <span> </span>                         <span>Jusqu’à normalisation des selles, <b> sans dépasser 7 jours.</b> Les sachets seront donnés dans un peu d’eau ou mélangés à de la compote.</span>                     </li>                 </ol>             </p>             <p>Nbre spécialités prescrites  : </p> 		</div>'),
(25, 'enfant_atovaquone_proguanil_62.5_25mg', 'PROPHYLAXIE CONTRE LE PALUDISME ', ''),
(26, 'enfant_doxy_ge_50mg', 'PROPHYLAXIE CONTRE LE PALUDISME ', ''),
(27, 'adulte_moustiques', 'PROTECTION CONTRE LES PIQÛRES DE MOUSTIQUES :', ''),
(28, 'enfant_moustiques', 'PROTECTION CONTRE LES PIQÛRES DE MOUSTIQUES :', ''),
(29, 'adulte_malarone_curatif', 'TRAITEMENT CURATIF CONTRE LE PALUDISME  ADULTE ET ENFANT DE PLUS DE 12 ANS', '           <div id="traitement">                    <p><i>Ce traitement est conseillé en cas d''accès fébrile, et sans possibilité de recours rapide (12-24 heures) à un médecin ou à des soins appropriés</i><br/></p>                  <span><b>ATOVAQUONE PROGUANIL 250/100 mg 1 boite (12 comprimés)</b></span><br/><br/>                  <span>Commencer par faire baisser la fièvre pour éviter les vomissements, puis prendre le médicament.</span> <br/>                  <span>Prendre 4 comprimés en une seule prise, chaque jour, pendant 3 jours consécutifs.</span> <br/>                  <p><span><b>A prendre avec un repas ou une boisson lactée, à heure fixe.</b></span> <br/></p>                              <span>En cas de vomissements dans la 1/2 heure qui suit la prise, reprendre une  dose complète.</span> <br/>                 <span>En cas de vomissements entre  1/2 heure et 1 heure qui suit la prise, reprendre une 1/2 dose.</span> <br/>                  <p><span><b>Ne pas dépasser la dose prescrite, ne pas laisser à la portée des enfants</b></span></p>              </div> ');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `treatment`
--
ALTER TABLE `treatment`
 ADD PRIMARY KEY (`treatment_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `treatment`
--
ALTER TABLE `treatment`
MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
