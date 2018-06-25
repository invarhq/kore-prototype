<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\Processor;

use Kore\Utils\LocalFilesystem;
use League\Flysystem\FilesystemInterface;
use function getcwd;

/**
 * Class Processor
 * @package Kore\Layout\Element\Template\Processor
 */
class ProcessorPhtml implements ProcessorInterface
{
    protected $remote;
    protected $local;

    /**
     * Processor constructor.
     * @param FilesystemInterface $remote
     * @param LocalFilesystem $local
     */
    public function __construct(FilesystemInterface $remote, LocalFilesystem $local)
    {
        $this->remote = $remote;
        $this->local = $local;
    }

    /**
     * @return array
     */
    public function getExtensionCodes(): array
    {
        return ['phtml'];
    }

    /**
     * @param string $template
     * @return $this
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function prepareLocal(string $template)
    {
        if (!$this->local->has($template)) {
            $this->local->write($template, $this->remote->read($template));
        }

        return $this;
    }

    /**
     * @param string $template
     * @param iterable|null $vars
     * @return string
     * @throws \Exception
     */
    public function processTemplate(string $template, iterable $vars = null): string
    {
        ob_start();
        $cwd = getcwd();
        try {
            $this->prepareLocal($template);
            if ($vars) {
                extract($vars, EXTR_SKIP);
            }
            $path = $this->local->applyPathPrefix($template);
            chdir($this->local->getPathPrefix());
            include $path;
        } catch (\Exception $exception) {
            ob_end_clean();
            throw $exception;
        } finally {
            chdir($cwd);
        }
        $output = ob_get_clean();

        return $output;
    }

    /**
     * @return bool
     */
    public function isJsCompatible(): bool
    {
        return false;
    }
}
