<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Twig\Extensions\Tests;

use PHPUnit\Framework\TestCase;
use Sulu\Twig\Extensions\UrlTwigExtension;

class UrlTwigExtensionTest extends TestCase
{
    const URL = 'https://john.doe:hidden@example.org:8080/admin?resource=pages&limit=20#1234';

    /**
     * @var UrlTwigExtension
     */
    private $urlTwigExtension;

    public function setup()
    {
        $this->urlTwigExtension = new UrlTwigExtension();
    }

    public function testUrlFormat(): void
    {
        $this->assertSame(self::URL, $this->urlTwigExtension->formatUrl(self::URL));

        $this->assertSame('example.org:8080/admin', $this->urlTwigExtension->formatUrl(self::URL, [
            'scheme' => false,
            'user' => false,
            'query' => false,
            'fragment' => false,
            'dsa' => false,
        ]));

        $this->assertSame('/admin?resource=pages&limit=20#1234', $this->urlTwigExtension->formatUrl(self::URL, [
            'host' => false,
        ]));

        $this->assertSame('https://john.doe:hidden@example.org', $this->urlTwigExtension->formatUrl(self::URL, [
            'port' => false,
            'path' => false,
        ]));

        $this->assertSame('john.doe@example.org:8080/admin#1234', $this->urlTwigExtension->formatUrl(self::URL, [
            'scheme' => false,
            'pass' => false,
            'query' => false,
        ]));
    }

    public function testScheme(): void
    {
        $this->assertSame('https', $this->urlTwigExtension->getScheme(self::URL));
    }

    public function testUser(): void
    {
        $this->assertSame('john.doe', $this->urlTwigExtension->getUser(self::URL));
    }

    public function testPass(): void
    {
        $this->assertSame('hidden', $this->urlTwigExtension->getPass(self::URL));
    }

    public function testHost(): void
    {
        $this->assertSame('example.org', $this->urlTwigExtension->getHost(self::URL));
    }

    public function testPort(): void
    {
        $this->assertSame(8080, $this->urlTwigExtension->getPort(self::URL));
    }

    public function testPath(): void
    {
        $this->assertSame('/admin', $this->urlTwigExtension->getPath(self::URL));
    }

    public function testQuery(): void
    {
        $this->assertSame('resource=pages&limit=20', $this->urlTwigExtension->getQuery(self::URL));
    }

    public function testFragment(): void
    {
        $this->assertSame('1234', $this->urlTwigExtension->getFragment(self::URL));
    }
}
