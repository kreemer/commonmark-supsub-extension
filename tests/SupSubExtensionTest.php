<?php

/*
 * MIT License
 *
 * Copyright (c) 2025 Kevin Studer
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare(strict_types=1);

namespace Tests\Kreemer\CommonmarkSupSubExtension;

use Kreemer\CommonmarkSupSubExtension\SupSubExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;

/**
 * @covers Kreemer\CommonmarkAdmonitionExtension\AdmonitionExtension
 */
class SupSubExtensionTest extends TestCase
{
    private MarkdownConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $environment = new Environment([]);
        $environment->addExtension(new SupSubExtension())->addExtension(new CommonMarkCoreExtension());
        $this->converter = new MarkdownConverter($environment);
    }

    public function testHandleEmptyMarkdown(): void
    {
        $result = $this->converter->convert('Hello');
        self::assertEquals('<p>Hello</p>', trim($result->getContent()));
    }

    public function supMarkupProvider(): array
    {
        return [
            ['10^2^', '<p>10<sup>2</sup></p>'],
            ['a^b\^c^', '<p>a<sup>b^c</sup></p>'],
            ['*a^b^c*', '<p><em>a<sup>b</sup>c</em></p>'],
            ['^a*b*^', '<p><sup>a<em>b</em></sup></p>'],
            ['^[a](https://example.com)^', '<p><sup><a href="https://example.com">a</a></sup></p>'],
            ['[a^b^](https://example.com)', '<p><a href="https://example.com">a<sup>b</sup></a></p>'],
            ['# a^b^', '<h1>a<sup>b</sup></h1>'],
        ];
    }

    public function subMarkupProvider(): array
    {
        return [
            ['10~2~', '<p>10<sub>2</sub></p>'],
            ['10~2\~1~', '<p>10<sub>2~1</sub></p>'],
            ['*10~2~1*', '<p><em>10<sub>2</sub>1</em></p>'],
            ['^10~2~^', '<p><sup>10<sub>2</sub></sup></p>'],
            ['~[a](https://example.com)~', '<p><sub><a href="https://example.com">a</a></sub></p>'],
            ['[a~b~](https://example.com)', '<p><a href="https://example.com">a<sub>b</sub></a></p>'],
            ['# a~b~', '<h1>a<sub>b</sub></h1>'],

        ];
    }

    /**
     * @dataProvider supMarkupProvider
     */
    public function testSupMarkup(string $markdown, string $expectedHtml): void
    {
        $result = $this->converter->convert($markdown);
        self::assertEquals($expectedHtml, trim($result->getContent()));
    }

    /**
     * @dataProvider subMarkupProvider
     */
    public function testSubMarkup(string $markdown, string $expectedHtml): void
    {
        $result = $this->converter->convert($markdown);
        self::assertEquals($expectedHtml, trim($result->getContent()));
    }

}
