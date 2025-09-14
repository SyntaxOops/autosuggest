<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\ViewHelpers;

use Doctrine\DBAL\Exception;
use SyntaxOOps\Autosuggest\Repository\AutoSuggestRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class RenderAutoSuggestViewHelper
 *
 * @author  Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class RenderAutoSuggestViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('tableName', 'string', 'Table name to autosuggest', true);
        $this->registerArgument('pid', 'int', 'Pid', true);
        $this->registerArgument(
            'fields',
            'string',
            'Names of fields to output, comma separated',
            true
        );
    }

    /**
     * @return string
     * @throws Exception
     */
    public function render(): string
    {
        $arguments = $this->arguments;

        /** @var AutoSuggestRepository $queryBuilder */
        $autoSuggestRepository = GeneralUtility::makeInstance(
            AutoSuggestRepository::class,
            $arguments['tableName']
        );

        return json_encode($autoSuggestRepository->getRecords($arguments['pid'], $arguments['fields']));
    }
}
