<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Response;

use App\Core\Dto\Response\CommentsDto;
use App\Core\Dto\Response\CommentsDtoFactory;
use PHPUnit\Framework\TestCase;

class CommentsDtoFactoryTest extends TestCase
{
    private CommentsDtoFactory $dtoFactory;

    public function setUp(): void
    {
        $this->dtoFactory = new CommentsDtoFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $data = [
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'cache' => true,
            'comments' => [
                'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                '(програвалася запис / робот)',
                'програвався запис (програвалася запис / робот)',
                'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
                'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                'ушасили',
                'Робот-шахрай спокушає призом',
            ],
            // @codingStandardsIgnoreEnd
        ];

        $dto = $this->dtoFactory->create($data);

        $this->assertInstanceOf(CommentsDto::class, $dto);

        $this->assertEquals($data['pn'], $dto->getPn());
        $this->assertEquals($data['cache'], $dto->isCache());
        $this->assertEquals($data['comments'], $dto->getComments());
    }
}
