<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Voir la classe de test PremiumMemberServiceTest pour les specifications de chaque méthode de cette classe.
 */
class PremiumMemberService 
{
    /**
     * Génère un rapport complet sur le profil d'un membre.
     * Specifications : 
     * - L'idenitifiant du membre doit être unique et préfixé par "usr_"
     * - Le nom d'utilisateur doit être nettoyé (trim et lowercase) et placé dans le champs meta.clean_name
     * - L'âge doit être supérieur ou égal à 18 ans
     * - Les centre d'interet doivent être convertis en lowercase et comptés dans le champs preferences.count
     * - La valeur de retour doit être un tableau associatif contenant les champs suivants : id, meta, preferences, status et created_at
     *    - id : un string unique préfixé par "usr_"
     *    - meta : un tableau associatif contenant les champs username, clean_name et age
     *    - preferences : un tableau associatif contenant les champs interests (tableau des centres d'intérêt en lowercase) et count (le nombre de centre d'intérêt)
     *    - status : doit être égal à "active"
     *    - created_at : doit être la date du jour au format Y-m-d
     * 
     * @param string $username Le nom d'utilisateur du membre par exemple : "Billy"
     * @param int $age L'âge du membre par exemple : 26
     * @param array $interests Les centres d'intérêt du membre exemple : ['Coding', 'Gaming', 'Fiesta'];
     */
    public function generateMemberProfile(string $username, int $age, array $interests): array
    {
        if (empty($username)) {
            throw new InvalidArgumentException("Le nom d'utilisateur ne peut pas être vide.");
        }

        if ($age < 18) {
            throw new InvalidArgumentException("Le membre doit être majeur.");
        }

        return [
            'id' => uniqid('usr_'),
            'meta' => [
                'username' => $username,
                'clean_name' => strtolower(trim($username)),
                'age' => $age,
            ],
            'preferences' => [
                'interests' => array_map('strtolower', $interests),
                'count' => count($interests)
            ],
            'status' => 'active',
            'created_at' => date('Y-m-d')
        ];
    }

    /**
     * Calcule une réduction basée sur un code promo et un montant.
     * Specifications :
     * - Le code promo "VIP20" applique une réduction de 20%
     * - Le code promo "SUMMER50" applique une réduction de 50%
     * - Si le code promo est null ou invalide, aucun rabais n'est appliqué et le montant original est retourné
     * - Tout autre code promo sauf null doit throw une InvalidArgumentException (héhé attention cette specification n'est pas implémentée dans la méthode)
     */
    public function applyPromoCode(float $amount, string|null $code): float
    {
        $code = strtoupper($code);
        
        if ($code === 'VIP20') {
            return $amount * 0.80;
        }
        
        if ($code === 'SUMMER50') {
            return $amount * 0.50;
        }

        return $amount;
    }
}