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

namespace Kreemer\CommonmarkSupSubExtension;

use Kreemer\CommonmarkAdmonitionExtension\Node\Admonition;
use Kreemer\CommonmarkAdmonitionExtension\Parser\AdmonitionParser;
use Kreemer\CommonmarkAdmonitionExtension\Renderer\AdmonitionRenderer;
use Kreemer\CommonmarkSupSubExtension\Node\Sub;
use Kreemer\CommonmarkSupSubExtension\Node\Sup;
use Kreemer\CommonmarkSupSubExtension\Processor\SubProcessor;
use Kreemer\CommonmarkSupSubExtension\Processor\SupProcessor;
use Kreemer\CommonmarkSupSubExtension\Renderer\SubRenderer;
use Kreemer\CommonmarkSupSubExtension\Renderer\SupRenderer;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;

final class SupSubExtension implements ConfigurableExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addDelimiterProcessor(new SupProcessor())->addRenderer(Sup::class, new SupRenderer())
            ->addDelimiterProcessor(new SubProcessor())->addRenderer(Sub::class, new SubRenderer())
        ;
    }

    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        // Do nothing
    }
}
