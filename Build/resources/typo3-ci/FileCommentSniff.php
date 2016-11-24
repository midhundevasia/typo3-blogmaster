<?php
/**
 * Parses and verifies the TYPO3 copyright notice.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@mailbox.org>
 * @copyright 2015 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */

/**
 * Parses and verifies the TYPO3 copyright notice.
 *
 * @category  PHP
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@mailbox.org>
 * @copyright 2015 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */

class TYPO3SniffPool_Sniffs_Commenting_FileCommentSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * The file comment in TYPO3 CMS must be the copyright notice.
     *
     * @var array
     */
    protected $copyright = array(
                            1  => "/*\n",
                            2  => " * This file is part of the Blogmaster project.\n",
                            3  => " * Copyright (C) 2016  Midhun Devasia <hello@midhundevasia.com>\n",
                            4  => " *\n",
                            5  => " * It is free software; you can redistribute it and/or modify it under\n",
                            6  => " * the terms of the GNU General Public License, either version 3\n",
                            7  => " * of the License, or any later version.\n",
                            8  => " *\n",
                            9  => " * For the full copyright and license information, please read the\n",
                            10  => " * LICENSE.txt file that was distributed with this source code.\n",
                            11 => " *\n",
                            12 => " * Blogmaster - A blog system for TYPO3!\n",
                            13 => " */",
                           );


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return int
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Find the next non whitespace token.
        $commentStart = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);

        // Allow namespace statements at the top of the file.
        if ($tokens[$commentStart]['code'] === T_NAMESPACE) {
            $semicolon    = $phpcsFile->findNext(T_SEMICOLON, ($commentStart + 1));
            $commentStart = $phpcsFile->findNext(T_WHITESPACE, ($semicolon + 1), null, true);
        }

        if ($tokens[$commentStart]['code'] === T_DOC_COMMENT_OPEN_TAG) {
            $fix = $phpcsFile->addFixableError(
                'Copyright notice must start with /*; but /** was found!',
                $commentStart,
                'WrongStyle'
            );

            if ($fix === true) {
                $phpcsFile->fixer->replaceToken($commentStart, "/*");
            }

            return;
        }

        $commentEnd = ($phpcsFile->findNext(T_WHITESPACE, ($commentStart + 1)) - 1);

        if ($tokens[$commentStart]['code'] !== T_COMMENT) {
            $phpcsFile->addError('Copyright notice missing', $commentStart, 'NoCopyrightFound');

            return;
        }

        if ((($commentEnd - $commentStart) + 1) < count($this->copyright)) {
            $phpcsFile->addError(
                'Copyright notice too short',
                $commentStart,
                'CommentTooShort'
            );
            return;
        } else if ((($commentEnd - $commentStart) + 1) > count($this->copyright)) {
            $phpcsFile->addError(
                'Copyright notice too long',
                $commentStart,
                'CommentTooLong'
            );
            return;
        }

        $j = 1;
        for ($i = $commentStart; $i <= $commentEnd; $i++) {
            if ($tokens[$i]['content'] !== $this->copyright[$j]) {
                $error = 'Found wrong part of copyright notice. Expected "%s", but found "%s"';
                $data  = array(
                          trim($this->copyright[$j]),
                          trim($tokens[$i]['content']),
                         );
                $fix   = $phpcsFile->addFixableError($error, $i, 'WrongText', $data);

                if ($fix === true) {
                    $phpcsFile->fixer->replaceToken($i, $this->copyright[$j]);
                }
            }

            $j++;
        }

        return;

    }//end process()


}//end class
