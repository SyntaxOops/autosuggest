<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Core;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;

/**
 * Class Request
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class Request
{
    /**
     * Returns the current TYPO3 PSR-7 request object
     *
     * @return ServerRequestInterface
     */
    public static function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * Checks whether the current request
     * is handled in the TYPO3 frontend context
     *
     * @return bool
     */
    public static function isFrontend(): bool
    {
        return !($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface
            || !ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isBackend();
    }
}
