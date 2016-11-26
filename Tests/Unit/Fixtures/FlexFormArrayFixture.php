<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Fixtures;
/*
 * This file is part of the Blogmaster project.
 * Copyright (C) 2016  Midhun Devasia <hello@midhundevasia.com>
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * Blogmaster - A blog system for TYPO3!
 */

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Flex form Array Fixture
 */
class FlexFormArrayFixture {

	/**
	 * @return array
	 */
	public function getData() {
		$flexFormData = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
		<T3FlexForms>
			<data>
				<sheet index="sDEF">
					<language index="lDEF">
						<field index="whaToDisplay">
							<value index="vDEF">Home</value>
						</field>
					</language>
				</sheet>
			</data>
		</T3FlexForms>';
		return $flexFormData;
	}
}