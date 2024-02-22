<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Collections\CommentsCollection;
use PHPUnit\Framework\TestCase;

class CommentsServiceTest extends TestCase
{
    private CommentsCollection $service;

    public function setUp(): void
    {
        $this->service = new CommentsCollection();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testGetUniqueComments(array $expectedUniqueComments, array $allComments): void
    {
        $this->service->addComments($allComments);
        $this->assertEquals($expectedUniqueComments, $this->service->getUniqueComments());
    }

    public static function dp(): array
    {
        return [
            [
                [
                    // @codingStandardsIgnoreStart
                    'Робот-шахрай спокушає призом',
                    'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                    '(програвалася запис / робот)',
                    'програвався запис (програвалася запис / робот)',
                    'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                    "Говорив молодий чоловік, стандартні фрази - комп'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. \r Однозначно шахраї. (програвалася запис / робот)",
                    'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)'
                    // @codingStandardsIgnoreEnd
                ],
                [
                    // @codingStandardsIgnoreStart
                    'Робот-шахрай спокушає призом',
                    'Робот-шахрай спокушає призом',
                    'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                    '(програвалася запис / робот)',
                    '(програвалася запис / робот)',
                    'програвався запис (програвалася запис / робот)',
                    'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                    "Говорив молодий чоловік, стандартні фрази - комп'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. \r Однозначно шахраї. (програвалася запис / робот)",
                    'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)'
                    // @codingStandardsIgnoreEnd
                ],
            ],
        ];
    }
}
