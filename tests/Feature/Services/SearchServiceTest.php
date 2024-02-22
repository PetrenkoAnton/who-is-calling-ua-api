<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Collections\CommentsCollection;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollectionFactory;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoFactory;
use App\Core\Dto\Response\CommentsDetailedDtoFactory;
use App\Core\Dto\Response\CommentsDtoFactory;
use App\Core\Formatters\OutputPNFormatter;
use App\Core\ProviderEnum;
use App\Core\Providers\CFProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use App\Core\Services\CommentService;
use Exception;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dpSearchSuccess
     */
    public function testSearchSuccess(bool $useCache): void
    {
        $pn = '443551591';

        $commentsCF = [
            // @codingStandardsIgnoreStart
            'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
            '(програвалася запис / робот)',
            '(програвалася запис / робот)',
            'програвався запис (програвалася запис / робот)',
            'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
            'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
            'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
            // @codingStandardsIgnoreEnd
        ];

        $commentsTD = [
            // @codingStandardsIgnoreStart
            'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
            'ушасили',
            'Робот-шахрай спокушає призом',
            // @codingStandardsIgnoreEnd
        ];

        $providerCF = $this->createConfiguredMock(CFProvider::class, [
            'getComments' => $commentsCF,
            'enable' => true,
            'getEnum' => ProviderEnum::CF,
        ]);

        $providerCI = $this->createConfiguredMock(CIProvider::class, [
            'getComments' => [],
            'enable' => true,
            'getEnum' => ProviderEnum::CI,
        ]);

        $providerKC = $this->createConfiguredMock(KCProvider::class, [
            'getComments' => [],
            'enable' => true,
            'getEnum' => ProviderEnum::KC,
        ]);

        $providerKZ = $this->createConfiguredMock(KZProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::KZ,
        ]);

        $providerSL = $this->createConfiguredMock(SLProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::SL,
        ]);

        $providerTD = $this->createConfiguredMock(TDProvider::class, [
            'getComments' => $commentsTD,
            'enable' => true,
            'getEnum' => ProviderEnum::TD,
        ]);

        $providerCollection = new ProviderCollection(
            $providerCF,
            $providerCI,
            $providerKC,
            $providerKZ,
            $providerSL,
            $providerTD,
        );

        $service = new CommentService(
            $providerCollection,
            $this->app->make(OutputPNFormatter::class),
            $this->app->make(CommentsCollection::class),
            $this->app->make(CommentsDtoFactory::class),
            $this->app->make(CommentsDetailedDtoFactory::class),
            $this->app->make(ProviderDtoCollectionFactory::class),
            $this->app->make(ProviderDtoFactory::class),
        );

        $actual = $service->search($pn, $useCache);

        $expected = [
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'cache' => $useCache,
            'comments' =>
                array(
                    0 => 'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                    1 => '(програвалася запис / робот)',
                    2 => 'програвався запис (програвалася запис / робот)',
                    3 => 'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                    4 => 'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                    5 => 'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
                    6 => 'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                    7 => 'ушасили',
                    8 => 'Робот-шахрай спокушає призом',
                ),
            // @codingStandardsIgnoreEnd
        ];

        $this->assertEquals($expected, $actual->toArray());
    }

    public static function dpSearchSuccess(): array
    {
        return [
            [false],
            [true],
        ];
    }

    /**
     * @group ok
     */
    public function testSearchWithClientException(): void
    {
        $pn = '672341456';

        $commentsKZ = [
            // @codingStandardsIgnoreStart
            'Інтернет провайдер',
            // @codingStandardsIgnoreEnd
        ];

        $providerCF = $this->createConfiguredMock(CFProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::CF,
        ]);

        $providerCI = $this->createConfiguredMock(CIProvider::class, [
            'getComments' => [],
            'enable' => true,
            'getEnum' => ProviderEnum::CI,
        ]);

        $providerKC = $this->createConfiguredMock(KCProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::KC,
        ]);

        $providerKZ = $this->createConfiguredMock(KZProvider::class, [
            'getComments' => $commentsKZ,
            'enable' => true,
            'getEnum' => ProviderEnum::KZ,
        ]);

        $exception = new Exception(
            // @codingStandardsIgnoreStart
            message: "Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response:\nerror code: 1006\n",
            // @codingStandardsIgnoreEnd
            code: 403,
        );

        $providerSL = $this->createConfiguredMock(SLProvider::class, [
            'enable' => true,
            'getEnum' => ProviderEnum::SL,
        ]);

        $providerSL
            ->method('getComments')
            ->willThrowException($exception);

        $providerTD = $this->createConfiguredMock(TDProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::TD,
        ]);

        $providerCollection = new ProviderCollection(
            $providerCF,
            $providerCI,
            $providerKC,
            $providerKZ,
            $providerSL,
            $providerTD,
        );

        $service = new CommentService(
            $providerCollection,
            $this->app->make(OutputPNFormatter::class),
            $this->app->make(CommentsCollection::class),
            $this->app->make(CommentsDtoFactory::class),
            $this->app->make(CommentsDetailedDtoFactory::class),
            $this->app->make(ProviderDtoCollectionFactory::class),
            $this->app->make(ProviderDtoFactory::class),
        );

        $actual = $service->search($pn, false);

        $expected = [
            // @codingStandardsIgnoreStart
            'pn' => '067 234-14-56',
            'cache' => false,
            'comments' =>
                array(
                    0 => 'Інтернет провайдер',
                ),
            // @codingStandardsIgnoreEnd
        ];

        $this->assertEquals($expected, $actual->toArray());
    }
}
