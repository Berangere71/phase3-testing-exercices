<?php

namespace App\Tests;

use App\Services\PremiumMemberService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Activité 2 : Testez la classe PremiumMemberService
 * Doc des asserts de PHPUnit : https://docs.phpunit.de/en/13.1/assertions.html
 * Cette exercice est un peu plus dur et plus realiste.
 * Il s'agit de tester la classe PremiumMemberService qui contient des méthodes plus complexes que celles de GeometryService.
 * - La méthode generateMemberProfile génère un profil de membre à partir de son nom d'utilisateur, son âge et ses centres d'intérêt. Elle doit respecter plusieurs specifications que vous trouverez dans les commentaires de la méthode.
 * - La méthode applyPromoCode applique une réduction à un montant en fonction d'un code promo. Elle doit respecter plusieurs specifications que vous trouverez dans les commentaires de la méthode.
 * CERTAIN specification non pas été respectées dans l'implémentation de la classe PremiumMemberService, votre travail est de les identifier et de les tester correctement.
 * CERTAIN Test devrons donc échoué et c'est le but c'est la preuve que votre test et bien ecrit car il respecte la spec et pas juste l'implémentation.
 * C'est ce cette façon qu'on l'on évite d'écrire des test biasé.
 */
class PremiumMemberServiceTest extends KernelTestCase
{
    private PremiumMemberService $premiumMemberService;
    protected function setUp(): void
    {
        // Plutot que de faire new PremiumMemberService() on va le récuperer depuis le container de symfony pour être sur d'avoir la même instance 
        // que celle utilisée dans l'application c'est obligatoire pour des services plus réaliste qui inject des Repo ou d'autre Service par exemple.

        self::bootKernel();
        $this->premiumMemberService = static::getContainer()->get(PremiumMemberService::class);
    }
    // Remplissez les test restants :)
    // Bon courage héhé :)

    /**
     * Test la fonction generateMemberProfile pour un cas de SUCCES.
     * - assertIsArray
     * - assertArrayHasKey
     * - assertStringStartsWith
     * - assertSame : pour comparer deux tableaux associatifs
     * - assertMatchesRegularExpression
     * - Voir la doc pour les autres asserts : https://docs.phpunit.de/en/13.1/assertions.html
     */
    public function testGenerateMemberProfileSuccess(): void
    {
        $profile = $this->premiumMemberService->generateMemberProfile("bob", 18, ['Coding', 'Gaming']);

        //vérifie que c'est un tableau
        $this->assertIsArray($profile);

        //Vérifie les colonnes du tableau
        $this->assertArrayHasKey('id', $profile);
        $this->assertArrayHasKey('meta', $profile);
        $this->assertArrayHasKey('preferences', $profile);

        //vérifier l'id qui doit commencer par usr_
        $this->assertStringStartsWith('usr_', $profile['id']);

        // je vérifie que le nom est bien bob
        $this->assertEquals('bob', $profile['meta']['clean_name']);

        // je vérifie que l'âge est bien 18
        $this->assertEquals(18, $profile['meta']['age']);

        //je vérifie les valeurs, le type exact et l'ordre exact
        $this->assertSame(
            ['coding', 'gaming'],
            $profile['preferences']['interests']
        );

        // je vérifie qu'il y est bien 2 centres d'intêret
        $this->assertEquals(2, $profile['preferences']['count']);

        //je vérifie que le status est valide
        $this->assertEquals('active', $profile['status']);

        //Je vérifie la date du jour est enregistrée
        $this->assertEquals(date('Y-m-d'), $profile['created_at']);

    }

    /**
     * Test la fonction generateMemberProfile pour un cas d'ECHEC lorsque le nom d'utilisateur est vide.
     */
    public function testGenerateMemberProfileEmptyUsername(): void
    {
        // ExpectExeception prepare la levé d'exeption, pour les exeptions on utilise 
        // expect plutot que assert
        // Utilisez cette exemple pour tester les autres expections dans d'autre test.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le nom d'utilisateur ne peut pas être vide.");
        $this->premiumMemberService->generateMemberProfile("", 25, ['Coding', 'Gaming']);
    }

    //Vérifie que la personne est majeure
    public function testGenerateMemberProfileThrowsExceptionForUnderage(): void
    {
        $this->expectException((InvalidArgumentException::class));
        $this->expectExceptionMessage("le membre doit être majeur.");

        $this->premiumMemberService->generateMemberProfile('Bob', 16, ['coding']);

    }

    //vérifier que l'username ne soit pas vide
    public function testGenerateMemberProfileThrowsExceptionForEmptyUsername(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le nom d'utilisateur ne peut pas être vide.");
        $this->premiumMemberService->generateMemberProfile("", 25, ['Coding', 'Gaming']);
    }

    //vérifier la réduction de 20%
    public function testApplyPromoCodeVip(): void
    {
        $result = $this->premiumMemberService->applyPromoCode(100, 'VIP20');
        $this->assertEquals(80, $result);
    }

    public function testIsEligibleForUpgrade(): void
    {
        $result = $this->premiumMemberService->isEligibleForUpgrade(
            25,
            ['coding', 'gaming', 'music'],
            150 );

        $this->assertTrue($result);
    }

    //vérifier la réduction de 50%
    public function testApplyPromoCodeSummer50(): void
    {
        $result = $this->premiumMemberService->applyPromoCode(100, 'SUMMER50');
        $this->assertEquals(50, $result);
    }

    //je vérifie que mon code promo est invalide
    public function testApplyPromoCodeThrowExceptionInvalid(): void
    {
        $this->expectException((InvalidArgumentException::class));

        $this->premiumMemberService->applyPromoCode(100, 'INVALID');
    }
    // je vérifie si le code est nul alors le montant reste identique
    public function testApplyPromoCodeNullAmountUnchanged(): void
    {
        $result = $this->premiumMemberService->applyPromoCode(100, null);
        $this->assertEquals(100,$result);        
    }

    // je vérifie si les 3 conditions sont exacts
    public function testIsEligibleForUpgradeSuccess(): void
    {
        $result = $this->premiumMemberService->isEligibleForUpgrade(
            25,
            ['coding', 'gaming', 'music'],
            150
        );
        $this->assertTrue($result);

    }

    //Je vérifie si l'âge est exact
    public function testIsEligibleForUpgradeUnderAge(): void
    {
        $result = $this->premiumMemberService->isEligibleForUpgrade(
            16,
            ['coding', 'gaming', 'music'],
            150
        );
        $this->assertFalse($result);
    }

    
    // Je vérifie le nombre de centre d'intêrets
    public function testIsEligibleForUpgradeInsufficientInterests(): void
    {
        $result = $this->premiumMemberService->isEligibleForUpgrade(
            25,
            ['music'],
            150,
        );
        $this->assertFalse($result);
    }

    //je vérifie le montant dépensé
    public function testIsEligibleForUpgradeInsufficientSpent(): void
    {
        $result = $this->premiumMemberService->isEligibleForUpgrade(
            25,
            ['coding', 'gaming', 'music'],
            50,
        );
        $this->assertFalse($result);
    }

    // je vérifie le calcul des points cumulés avec le montant de mes achats
    public function testCalculateLoyaltyPointsStandard(): void
    {
        $points = $this->premiumMemberService->calculateLoyaltyPoints(10);
        $this->assertEquals(100,$points);
    }

    //Je vérifie le calcul des points cumulés avec le montant de mes achats, j'ai un bonus de 50% si je suis membre premium
    public function testCalculateLoyaltyPointsPremium(): void
    {
        $points = $this->premiumMemberService->calculateLoyaltyPoints(10, true);
        $this->assertEquals(150, $points);
    }

    // je vérifie si le montant est négatif
    public function testCalculateLoyaltyPointsNegativeThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le montant ne peut pas être négatif");
        $this->premiumMemberService->calculateLoyaltyPoints(-10);
    }

    // je vérifie s'il effectue les calcul de min, max, total et moyenne
    public function testSummarizeSpending(): void
    {
        $summary = $this->premiumMemberService->summarizeSpending([10, 20, 30]);
        $this->assertEquals(60, $summary['total']);
        $this->assertEquals(20, $summary['average']);
        $this->assertEquals(10, $summary['min']);
        $this->assertEquals(30, $summary['max']);
    }

    //Je vérifie que le tableau n'est pas vide
    public function testSummarizeSpendingEmptyThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le tableau de transaction ne peut pas être vide");
        $this->premiumMemberService->summarizeSpending([]);
    }

    //je vérifie que la date respecte bien le format année/mois/jour
    public function testRenewSubscription1Month(): void
    {

        $date = $this->premiumMemberService->renewSubscription(1);

        $this->assertMatchesRegularExpression(
        '/^\d{4}-\d{2}-\d{2}$/',
        $date
    );

    }

    //je vérifie si l'abonnement est de 5 mois, pour qu'un message d'erreur apparaisse
    public function testRenewSubscriptionInvalidDurationThrowException(): void
    {
            $this->expectException(InvalidArgumentException::class);
       $this->expectExceptionMessage("La durée doit être de 1, 6 ou 12 mois");
       $this->premiumMemberService->renewSubscription(5);
    }

    //vérifie que les données sensibles ont bien été supprimées/modifiées
    public function testAnonymizeProfile(): void
    {
       $profile = [ 'id' => 'usr_123',
                    'meta' => [
                        'username' => 'Bob',
                        'clean_name' => 'bob',
                        'age' => 25
                    ],

                    'preferences' => [
                        'interests' => ['coding'],
                        'count'=> 1
                    ]
                    ];

        $result = $this->premiumMemberService
                ->anonymizeProfile($profile);

        $this->assertEquals('anonymous',
                $result['meta']['username']);
                
        $this->assertEquals(0, $result['meta']['age']);

        $this->assertSame([], $result['preferences']['interests']);
    }

    //vérifie que le système refuse les profils invalides
    public function testAnonymizeProfileInvalidThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->premiumMemberService
        ->anonymizeProfile([]);

    }
}
