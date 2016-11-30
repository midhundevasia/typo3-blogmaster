<?php
namespace Tutorboy\Blogmaster\Controller;

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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * File controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class FileController extends AbstractController {

	/**
	 * Get file info
	 * @param  ServerRequestInterface $request  Request
	 * @param  ResponseInterface      $response Response
	 * @return void
	 */
	public function getFileInfoAction(ServerRequestInterface $request, ResponseInterface $response) {
		if (NULL !== GeneralUtility::_GP('uid')) {
			$fileUid = GeneralUtility::_GP('uid');
			$resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
			$file = $resourceFactory->getFileObject($fileUid);
			$data['uid'] = $file->getUid();
			$data['path'] = $file->getIdentifier();
			$data['storage']['uid'] = $file->getStorage()->getUid();
			$data['storage']['configuration'] = $file->getStorage()->getConfiguration();
			$data['absolutePath'] = PathUtility::getAbsoluteWebPath(str_replace('//', '/', PATH_site . $data['storage']['configuration']['basePath'] . $file->getIdentifier()));
			header('Content-Type: application/json');
			echo json_encode($data);
			exit(0);
		}
	}
}