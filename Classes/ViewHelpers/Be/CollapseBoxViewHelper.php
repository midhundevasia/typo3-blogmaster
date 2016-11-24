<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Be;

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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * A viewhelper for create collapsable box widget
 *
 * @package 	Blogmaster
 * @subpackage 	ViewHelper
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CollapseBoxViewHelper extends AbstractViewHelper {

	/**
	 * EscapeOutput
	 * @var bool
	 */
	protected $escapeOutput = FALSE;

	/**
	 * EscapeChildren
	 * @var bool
	 */
	protected $escapeChildren = FALSE;

	/**
	 * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
	 * can decode the text's entities.
	 *
	 * @var bool
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * Render collapsebox widget
	 * @param  string $value Panel content
	 * @param  string $title   Panel title
	 * @return string Html
	 */
	public function render($value = NULL, $title = NULL) {
		return static::renderStatic(
			[
				'value' => $value,
				'title' => $title,
			],
			$this->buildRenderChildrenClosure(),
			$this->renderingContext
		);
	}

	/**
	 * Render children without escaping
	 * @param array $arguments Arguments
	 * @param \Closure $renderChildrenClosure RenderChildrenClosure
	 * @param RenderingContextInterface $renderingContext RenderingContext
	 * @return string
	 * @todo Collapse and Expand function completion, value will save in "/ajax/usersettings/process"
	 */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$value = $arguments['value'];
		$title = $arguments['title'];
		if ($value === NULL) {
			$html = '<div class="panel panel-space panel-default clear ">
						<div class="panel-heading">
							' . $title . '
							<span>
								<a href="javascript:void(0);" title="Collapse" class="pull-right t3js-toggle-recordlist" data-toggle="collapse" aria-expanded="true">
								<span class="collapseIcon">
									<span class="t3js-icon icon icon-size-small icon-state-default icon-actions-view-list-collapse" data-identifier="actions-view-list-collapse">
									<span class="icon-markup">
										<img src="/typo3/sysext/core/Resources/Public/Icons/T3Icons/actions/actions-view-list-collapse.svg" height="16" width="16" />
									</span>
									</span>
								</span>
								</a>
							</span>
						</div>
						<div class="panel-body">
							' . $renderChildrenClosure() . '
						</div>
					</div>';
			return $html;
		} else {
			return $value;
		}
	}
}