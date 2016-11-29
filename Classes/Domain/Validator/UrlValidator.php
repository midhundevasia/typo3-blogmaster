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
 * URL validator
 *
 * @package 	Blogmaster
 * @subpackage 	Validator
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class UrlValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * Validate URL
	 * @param  string  $value Url
	 * @return void
	 */
	public function isValid($value) {
		if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
			$this->addError(
				$this->translateErrorMessage(
					'validator.url.notvalid',
					'blogmaster'
				), time());
		}
	}
}