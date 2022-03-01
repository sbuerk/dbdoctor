<?php

declare(strict_types=1);

namespace Lolli\Dbhealth\Helper;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

class TcaHelper
{
    /**
     * @return iterable<string>
     */
    public function getNextWorkspaceEnabledTcaTable(): iterable
    {
        foreach ($GLOBALS['TCA'] as $tableName => $config) {
            if ($config['ctrl']['versioningWS'] ?? false) {
                yield $tableName;
            }
        }
    }

    /**
     * @return iterable<string>
     */
    public function getNextLanguageAwareTcaTable(): iterable
    {
        foreach ($GLOBALS['TCA'] as $tableName => $config) {
            if (($config['ctrl']['languageField'] ?? false)
                && ($config['ctrl']['transOrigPointerField'] ?? false)
            ) {
                yield $tableName;
            }
        }
    }

    public function getFieldNameByCtrlName(string $tableName, string $ctrlName): string
    {
        if (empty($GLOBALS['TCA'][$tableName]['ctrl'][$ctrlName])) {
            throw new \RuntimeException(
                'Name "' . $ctrlName . '" in TCA ctrl of table "' . $tableName . '" not found',
                1646162580
            );
        }
        return $GLOBALS['TCA'][$tableName]['ctrl'][$ctrlName];
    }

    public function getDeletedField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['delete'] ?? null) ?: null;
    }

    public function getCreateUserIdField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['cruser_id'] ?? null) ?: null;
    }

    public function getTimestampField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['tstamp'] ?? null) ?: null;
    }

    public function getLanguageField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['languageField'] ?? null) ?: null;
    }

    public function getTranslationParentField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] ?? null) ?: null;
    }

    public function getWorkspaceIdField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['versioningWS'] ?? null) ? 't3ver_wsid' : null;
    }

    public function getTypeField(string $tableName): ?string
    {
        return ($GLOBALS['TCA'][$tableName]['ctrl']['type'] ?? null) ?: null;
    }

    /**
     * @return string[]|null
     */
    public function getLabelFields(string $tableName): ?array
    {
        if (!isset($GLOBALS['TCA'][$tableName]['ctrl']['label']) && !isset($GLOBALS['TCA'][$tableName]['ctrl']['label_alt'])) {
            return null;
        }

        $result = [];
        if ($GLOBALS['TCA'][$tableName]['ctrl']['label'] ?? false) {
            $result[] = $GLOBALS['TCA'][$tableName]['ctrl']['label'];
        }
        if ($GLOBALS['TCA'][$tableName]['ctrl']['label_alt'] ?? false) {
            $result = array_merge($result, GeneralUtility::trimExplode(',', $GLOBALS['TCA'][$tableName]['ctrl']['label_alt'], true));
        }
        return $result;
    }
}
