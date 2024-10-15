<?php

// Classe pour calculer l'IMC
class IMCCalculator {
    private $weight;
    private $height;

    // Constructeur pour initialiser le poids et la taille depuis les paramètres GET
    public function __construct() {
        if (isset($_GET['weight']) && isset($_GET['height'])) {
            $this->weight = floatval($_GET['weight']);
            // Convertir la taille de centimètres à mètres (si saisie en cm)
            $this->height = floatval($_GET['height']) / 100;
        } else {
            throw new Exception("Les paramètres du poids et de la taille sont requis.");
        }
    }

    // Méthode pour calculer l'IMC
    public function calculateIMC() {
        if ($this->height > 0) {
            return round($this->weight / ($this->height * $this->height), 2);
        } else {
            throw new Exception("La taille doit être supérieure à zéro.");
        }
    }

    // Méthode pour afficher le résultat avec interprétation
    public function displayResult() {
        try {
            $imc = $this->calculateIMC();
            echo "Votre IMC est : <span class='imc-value'>" . $imc . "</span><br>";

            // Interprétation des résultats selon l'IMC avec des conseils
            if ($imc < 18.5) {
                echo "<span class='imc-underweight'>Vous êtes en insuffisance pondérale (maigreur).</span><br>";
                echo "<span class='advice'>Conseil : Il est important d'adopter un régime alimentaire équilibré et de consulter un professionnel de santé pour s'assurer que vous recevez suffisamment de nutriments. Un suivi médical peut être nécessaire pour retrouver un poids sain.</span>";
                echo "<span class='advice'>
                        L'insuffisance pondérale peut avoir des répercussions sur la santé, mais des changements de mode de vie peuvent aider à atteindre un poids santé de manière saine. Voici quelques conseils :

                        <h2>1. Alimentation Équilibrée</h2>
                        <ul>
                            <li><strong>Manger Plus Souvent :</strong> Essayez de prendre cinq à six petits repas au lieu de trois gros pour augmenter l'apport calorique.</li>
                            <li><strong>Choisir des Aliments Nutriments Denses :</strong> Privilégiez les aliments riches en calories et en nutriments, comme les fruits secs, les avocats, et les produits laitiers entiers.</li>
                            <li><strong>Augmenter les Portions :</strong> Augmentez la taille de vos portions lors des repas pour consommer plus de calories.</li>
                        </ul>

                        <h2>2. Activité Physique</h2>
                        <ul>
                            <li><strong>Exercice de Renforcement :</strong> Intégrez des exercices de renforcement musculaire pour augmenter la masse musculaire.</li>
                            <li><strong>Éviter les Activités Très Énergétiques :</strong> Limitez les activités qui brûlent beaucoup de calories sans contribuer à la prise de poids.</li>
                        </ul>

                        <h2>3. Hydratation</h2>
                        <ul>
                            <li><strong>Boire des Calories :</strong> Consommez des boissons nutritives comme des smoothies et des milkshakes.</li>
                        </ul>

                        <h2>4. Suivi Médical</h2>
                        <ul>
                            <li><strong>Consulter un Professionnel de Santé :</strong> Un diététicien ou un médecin peut vous aider à établir un plan alimentaire personnalisé.</li>
                            <li><strong>Surveillance Régulière :</strong> Faites des contrôles réguliers pour surveiller votre poids et votre santé générale.</li>
                        </ul>

                        <h2>5. Gestion du Stress</h2>
                        <ul>
                            <li><strong>Techniques de Relaxation :</strong> Intégrez des pratiques de relaxation comme la méditation pour réduire le stress.</li>
                        </ul>

                        <h2>6. Sommeil de Qualité</h2>
                        <ul>
                            <li><strong>Veiller à un Bon Sommeil :</strong> Un sommeil de qualité est essentiel pour la récupération.</li>
                        </ul>

                        <h2>7. Éducation Nutritionnelle</h2>
                        <ul>
                            <li><strong>Apprendre à Lire les Étiquettes :</strong> Familiarisez-vous avec les informations nutritionnelles pour faire des choix éclairés.</li>
                        </ul>

                        <h2>8. Fixer des Objectifs Réalistes</h2>
                        <ul>
                            <li><strong>Prise de Poids Progressive :</strong> Visez une prise de poids de 0,5 à 1 kg par semaine pour une approche durable.</li>
                        </ul>

                        L'accompagnement médical est souvent essentiel pour déterminer les meilleures options en fonction de votre situation personnelle. N'hésitez pas à consulter un professionnel de santé pour obtenir des conseils adaptés à votre cas.
                    </span>";
            } elseif ($imc >= 18.5 && $imc < 25) {
                echo "<span class='imc-normal'>Vous avez une corpulence normale.</span><br>";
                echo "<span class='advice'>Conseil : Continuez à maintenir un mode de vie sain en suivant une alimentation équilibrée et en faisant régulièrement de l'exercice. Préserver cette stabilité est idéal pour votre santé.</span>";
            } elseif ($imc >= 25 && $imc < 30) {
                echo "<span class='imc-overweight'>Vous êtes en surpoids.</span><br>";
                echo "<span class='advice'>Conseil : Il pourrait être bénéfique d'adopter des habitudes alimentaires plus équilibrées et d'augmenter l'activité physique pour éviter que le surpoids n'évolue vers des problèmes de santé plus graves. Consultez un professionnel de santé pour des conseils personnalisés.</span>";
                    echo "<span class='advice'>
                        Le surpoids peut avoir des répercussions sur la santé, mais des changements de mode de vie peuvent aider à le gérer efficacement. Voici quelques conseils :

                        <h2>1. Alimentation Équilibrée</h2>
                        <ul>
                            <li><strong>Manger des Aliments Nutriments Denses :</strong> Privilégiez les fruits, les légumes, les céréales complètes et les protéines maigres.</li>
                            <li><strong>Portions Contrôlées :</strong> Utilisez des assiettes plus petites pour éviter les excès.</li>
                            <li><strong>Limiter les Sucres Ajoutés et les Aliments Transformés :</strong> Réduisez les boissons sucrées et les snacks transformés.</li>
                        </ul>

                        <h2>2. Activité Physique Régulière</h2>
                        <ul>
                            <li><strong>Exercice Cardiovasculaire :</strong> Visez au moins 150 minutes d'exercice modéré par semaine.</li>
                            <li><strong>Renforcement Musculaire :</strong> Incluez des exercices de renforcement au moins deux fois par semaine.</li>
                        </ul>

                        <h2>3. Hydratation</h2>
                        <ul>
                            <li><strong>Boire Suffisamment d’Eau :</strong> Essayez de boire au moins 1,5 à 2 litres d’eau par jour.</li>
                        </ul>

                        <h2>4. Suivi et Soutien</h2>
                        <ul>
                            <li><strong>Consulter un Professionnel de Santé :</strong> Un diététicien peut vous aider à élaborer un plan personnalisé.</li>
                            <li><strong>Groupes de Soutien :</strong> Rejoindre un groupe peut fournir motivation.</li>
                        </ul>

                        <h2>5. Gestion du Stress</h2>
                        <ul>
                            <li><strong>Techniques de Relaxation :</strong> Pratiquez la méditation et d'autres techniques de gestion du stress.</li>
                        </ul>

                        <h2>6. Sommeil de Qualité</h2>
                        <ul>
                            <li><strong>Veiller à un Sommeil Suffisant :</strong> Un bon sommeil est essentiel pour le métabolisme.</li>
                        </ul>

                        <h2>7. Fixer des Objectifs Réalistes</h2>
                        <ul>
                            <li><strong>Perte de Poids Progressive :</strong> Visez une perte de 0,5 à 1 kg par semaine.</li>
                        </ul>

                        <h2>8. Éviter les Régimes Restrictifs</h2>
                        <ul>
                            <li><strong>Préférer des Changements de Mode de Vie Durables :</strong> Évitez les régimes à la mode.</li>
                        </ul>

                        <h2>9. Surveillance du Progrès</h2>
                        <ul>
                            <li><strong>Tenir un Journal Alimentaire :</strong> Notez vos habitudes alimentaires.</li>
                        </ul>

                        <h2>10. Éducation Nutritionnelle</h2>
                        <ul>
                            <li><strong>Apprendre à Lire les Étiquettes :</strong> Familiarisez-vous avec les informations nutritionnelles.</li>
                        </ul>

                        L'accompagnement médical est souvent essentiel pour déterminer les meilleures options en fonction de votre situation personnelle. N'hésitez pas à consulter un professionnel de santé pour obtenir des conseils adaptés à votre cas.
                    </span>";
            } elseif ($imc >= 30 && $imc < 35) {
                echo "<span class='imc-obesity-moderate'>Vous êtes en obésité modérée.</span><br>";
                echo "<span class='advice'>Conseil : Il est recommandé de suivre un programme alimentaire adapté et de pratiquer une activité physique régulière. Un suivi médical est conseillé pour réduire les risques associés à l'obésité.</span>";
                echo "<span class='advice'>
                        L'obésité modérée peut avoir des répercussions sur la santé, mais des changements de mode de vie peuvent aider à la gérer efficacement. Voici quelques conseils pour aborder cette situation :
                        <h2>1. Alimentation Équilibrée</h2>
                        <ul>
                            <li><strong>Manger varié :</strong> Intégrez des fruits, des légumes, des céréales complètes, des protéines maigres et des graisses saines.</li>
                            <li><strong>Portions contrôlées :</strong> Faites attention à la taille des portions pour éviter les excès.</li>
                            <li><strong>Limiter les sucres ajoutés et les aliments transformés :</strong> Évitez les boissons sucrées, les snacks transformés et les aliments riches en graisses saturées.</li>
                        </ul>
                        <h2>2. Activité Physique Régulière</h2>
                        <ul>
                            <li><strong>Exercice cardiovasculaire :</strong> Essayez de pratiquer au moins 150 minutes d'exercice modéré par semaine (marche rapide, vélo, natation).</li>
                            <li><strong>Renforcement musculaire :</strong> Intégrez des exercices de renforcement au moins deux fois par semaine (musculation, yoga).</li>
                        </ul>
                        <h2>3. Hydratation</h2>
                        <ul>
                            <li><strong>Boire suffisamment d’eau :</strong> Remplacez les boissons sucrées par de l'eau et essayez de boire au moins 1,5 à 2 litres d'eau par jour.</li>
                        </ul>
                        <h2>4. Suivi et Soutien</h2>
                        <ul>
                            <li><strong>Consulter un professionnel de la santé :</strong> Un diététicien ou un médecin peut vous aider à élaborer un plan personnalisé.</li>
                            <li><strong>Groupes de soutien :</strong> Rejoindre un groupe de soutien peut vous aider à rester motivé et à partager vos expériences.</li>
                        </ul>
                        <h2>5. Gestion du Stress</h2>
                        <ul>
                            <li><strong>Techniques de relaxation :</strong> Pratiquez la méditation, le yoga ou d'autres techniques de gestion du stress pour éviter la prise de poids due à des habitudes alimentaires émotionnelles.</li>
                        </ul>
                        <h2>6. Sommeil de Qualité</h2>
                        <ul>
                            <li><strong>Veiller à avoir un sommeil suffisant :</strong> Un sommeil de qualité est crucial pour le métabolisme et la gestion du poids.</li>
                        </ul>
                        <h2>7. Fixer des Objectifs Réalistes</h2>
                        <ul>
                            <li><strong>Perte de poids progressive :</strong> Visez une perte de poids de 0,5 à 1 kg par semaine, ce qui est généralement considéré comme sûr et durable.</li>
                        </ul>
                        <h2>8. Éviter les Régimes Restrictifs</h2>
                        <ul>
                            <li><strong>Préférer des changements de mode de vie durables :</strong> Évitez les régimes à la mode qui promettent des résultats rapides, car ils ne sont souvent pas durables.</li>
                        </ul>
                        <h2>9. Surveillance du Progrès</h2>
                        <ul>
                            <li><strong>Tenir un journal alimentaire :</strong> Notez ce que vous mangez et votre activité physique pour mieux comprendre vos habitudes.</li>
                        </ul>
                        <h2>10. Éducation Nutritionnelle</h2>
                        <ul>
                            <li><strong>Apprendre à lire les étiquettes :</strong> Familiarisez-vous avec la lecture des étiquettes nutritionnelles pour faire des choix éclairés.</li>
                        </ul>
                        L'accompagnement médical est souvent essentiel pour déterminer les meilleures options en fonction de votre situation personnelle. N'hésitez pas à consulter un professionnel de santé pour obtenir des conseils adaptés à votre cas.
                    </span>";
            } elseif ($imc >= 35 && $imc < 40) {
                echo "<span class='imc-obesity-severe'>Vous êtes en obésité sévère.</span><br>";
                echo "<span class='advice'>Conseil : Une intervention médicale et des changements significatifs dans votre style de vie sont fortement recommandés. Consultez un médecin ou un nutritionniste pour élaborer un plan adapté à vos besoins.</span>";
                echo "<span class='advice'>
                        L'obésité sévère présente des risques significatifs pour la santé. Voici quelques conseils pour vous aider à gérer cette condition :

                        <h2>1. Consultation Médicale</h2>
                        <ul>
                            <li><strong>Consulter un Médecin :</strong> Avant de commencer un programme de perte de poids, consultez un médecin pour évaluer votre état de santé.</li>
                            <li><strong>Évaluation Nutritionnelle :</strong> Travailler avec un diététicien pour élaborer un plan alimentaire adapté.</li>
                        </ul>

                        <h2>2. Programme Alimentaire Structuré</h2>
                        <ul>
                            <li><strong>Alimentation Équilibrée :</strong> Intégrez des aliments riches en nutriments.</li>
                            <li><strong>Portions Contrôlées :</strong> Utilisez des assiettes plus petites pour réduire les portions.</li>
                            <li><strong>Éviter les Sucres Ajoutés :</strong> Limitez les sucres ajoutés et les glucides raffinés.</li>
                        </ul>

                        <h2>3. Activité Physique Adaptée</h2>
                        <ul>
                            <li><strong>Commencer Lentement :</strong> Commencez par des activités physiques légères.</li>
                            <li><strong>Renforcement Musculaire :</strong> Intégrez des exercices de renforcement musculaire au moins deux fois par semaine.</li>
                        </ul>

                        <h2>4. Suivi et Soutien</h2>
                        <ul>
                            <li><strong>Groupes de Soutien :</strong> Rejoindre un groupe de soutien peut vous aider à rester motivé.</li>
                            <li><strong>Suivi Médical Régulier :</strong> Des visites régulières pour évaluer les progrès.</li>
                        </ul>

                        <h2>5. Gestion du Stress</h2>
                        <ul>
                            <li><strong>Techniques de Relaxation :</strong> Pratiquez la méditation et d'autres techniques de gestion du stress.</li>
                        </ul>

                        <h2>6. Sommeil de Qualité</h2>
                        <ul>
                            <li><strong>Veiller à un Bon Sommeil :</strong> Visez 7 à 9 heures de sommeil par nuit.</li>
                        </ul>

                        <h2>7. Objectifs Réalistes</h2>
                        <ul>
                            <li><strong>Fixer des Objectifs de Perte de Poids :</strong> Visez une perte de poids progressive de 0,5 à 1 kg par semaine.</li>
                        </ul>

                        <h2>8. Approches Médicales</h2>
                        <ul>
                            <li><strong>Envisager des Options Médicales :</strong> Discutez des médicaments ou de la chirurgie bariatrique.</li>
                        </ul>

                        <h2>9. Éducation Nutritionnelle</h2>
                        <ul>
                            <li><strong>Apprendre à Lire les Étiquettes :</strong> Familiarisez-vous avec les informations nutritionnelles.</li>
                        </ul>

                        <h2>10. Surveiller les Progrès</h2>
                        <ul>
                            <li><strong>Tenir un Journal Alimentaire :</strong> Notez vos repas et votre activité physique.</li>
                        </ul>

                        L'accompagnement médical est essentiel pour déterminer les meilleures options en fonction de votre situation personnelle. N'hésitez pas à consulter des professionnels de santé pour obtenir des conseils adaptés à votre cas.
                    </span>";
            } else {
                echo "<span class='imc-obesity-morbid'>Vous êtes en obésité morbide ou massive.</span><br>";
                echo "<span class='advice'>Conseil : L'obésité morbide présente un risque élevé pour la santé. Il est impératif de consulter un professionnel de santé pour un accompagnement médical. Un suivi régulier, ainsi qu'un programme alimentaire et physique personnalisé, sont essentiels.</span>";
                    echo "<span class='advice'>
                        L'obésité morbide présente des risques élevés pour la santé. Voici quelques conseils pour vous aider à gérer cette condition :

                        <h2>1. Consultation Médicale Immédiate</h2>
                        <ul>
                            <li><strong>Évaluation Médicale :</strong> Consultez un médecin spécialisé pour une évaluation complète.</li>
                            <li><strong>Plan de Traitement Personnalisé :</strong> Un médecin peut recommander un plan de traitement adapté.</li>
                        </ul>

                        <h2>2. Suivi Nutritionnel</h2>
                        <ul>
                            <li><strong>Travailler avec un Diététicien :</strong> Collaborer avec un diététicien pour créer un plan alimentaire équilibré.</li>
                            <li><strong>Éviter les Régimes Extrêmes :</strong> Évitez les régimes à la mode ou extrêmes.</li>
                        </ul>

                        <h2>3. Programme d'Activité Physique</h2>
                        <ul>
                            <li><strong>Commencer Doucement :</strong> Engagez-vous dans des activités physiques adaptées.</li>
                            <li><strong>Augmenter Graduellement l'Intensité :</strong> Avec le temps, augmentez progressivement l'intensité.</li>
                        </ul>

                        <h2>4. Soutien Psychologique</h2>
                        <ul>
                            <li><strong>Thérapie Comportementale :</strong> Envisagez de suivre une thérapie comportementale.</li>
                            <li><strong>Groupes de Soutien :</strong> Rejoindre un groupe de soutien pour partager des expériences.</li>
                        </ul>

                        <h2>5. Gestion du Stress</h2>
                        <ul>
                            <li><strong>Techniques de Relaxation :</strong> Pratiquez la méditation et d'autres techniques de gestion du stress.</li>
                        </ul>

                        <h2>6. Sommeil de Qualité</h2>
                        <ul>
                            <li><strong>Prioriser le Sommeil :</strong> Assurez-vous de dormir suffisamment.</li>
                            <li><strong>Établir une Routine de Sommeil :</strong> Créez une routine régulière pour vous aider à vous endormir.</li>
                        </ul>

                        <h2>7. Éducation et Sensibilisation</h2>
                        <ul>
                            <li><strong>Comprendre les Risques Associés :</strong> Éduquez-vous sur les risques de santé liés à l'obésité morbide.</li>
                            <li><strong>Apprendre à Lire les Étiquettes :</strong> Familiarisez-vous avec les informations nutritionnelles.</li>
                        </ul>

                        <h2>8. Options Médicales</h2>
                        <ul>
                            <li><strong>Évaluation Chirurgicale :</strong> Discutez des options chirurgicales si cela est approprié.</li>
                            <li><strong>Médicaments pour la Perte de Poids :</strong> Explorez la possibilité de médicaments sous la supervision d’un professionnel de santé.</li>
                        </ul>

                        <h2>9. Fixation d'Objectifs Réalistes</h2>
                        <ul>
                            <li><strong>Objectifs de Perte de Poids Progressifs :</strong> Visez une perte de poids de 0,5 à 1 kg par semaine.</li>
                        </ul>

                        <h2>10. Surveillance Continue</h2>
                        <ul>
                            <li><strong>Suivi Régulier :</strong> Assurez-vous d'avoir des visites régulières chez votre médecin.</li>
                            <li><strong>Tenir un Journal Alimentaire :</strong> Notez vos habitudes alimentaires.</li>
                        </ul>

                        L'accompagnement médical est essentiel pour déterminer les meilleures options en fonction de votre situation personnelle. N'hésitez pas à consulter des professionnels de santé pour obtenir des conseils adaptés à votre cas.
                    </span>";
            }

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


}

?>
