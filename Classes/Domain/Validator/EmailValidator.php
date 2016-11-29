<?php
namespace Tutorboy\Blogmaster\Domain\Validator;

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

/**
 * Email validator
 *
 * @package 	Blogmaster
 * @subpackage 	Validator
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class EmailValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * Email id validation
	 * @param  string  $value Email
	 * @return void
	 */
	public function isValid($value) {
		if (!is_string($value) || !$this->validEmail($value)) {
			$this->addError(
				$this->translateErrorMessage(
					'validator.emailaddress.notvalid',
					'blogmaster'
				), time());
		}
	}

	/**
	 * Validate email address
	 * @param  string $emailAddress Email address
	 * @return bool
	 */
	protected function validEmail($emailAddress) {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($emailAddress);
	}
}
