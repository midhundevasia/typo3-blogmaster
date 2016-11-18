<?php
namespace Tutorboy\Blogmaster\Domain\Model;

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
 * FileReference model
 *
 * @package 	Blogmaster
 * @subpackage 	Model
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder {

	/**
	 * Uid of a sys_file
	 * @var int
	 */
	protected $uidLocal;

	/**
	 * Ser original resource
	 * @param \TYPO3\CMS\Core\Resource\ResourceInterface $originalResource Original Resource
	 * @return void
	 */
	public function setOriginalResource(\TYPO3\CMS\Core\Resource\ResourceInterface $originalResource) {
		$this->originalResource = $originalResource;
		$this->uidLocal = (int)$originalResource->getOriginalFile()->getUid();
	}

	/**
	 * Set original resource
	 * @return object
	 */
	public function getOriginalResource() {
		if ($this->originalResource == NULL) {
			$this->originalResource = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject($this->getUid());
		}

		return $this->originalResource;
	}
}