<?php

namespace LqdCodingStandard\Sniffs\Commenting;

use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowHashSniff implements Sniff
{
	/**
	 * @return int[]
	 */
	public function register(): array
	{
		return [
			\T_COMMENT,
		];
	}
	
	public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr): void
	{
		$tokens = $phpcsFile->getTokens();
		
		if (\substr($tokens[$stackPtr]['content'], 0, 1) === '#') {
			$error = 'Hash comments are prohibited; found %s';
			$data = [\trim($tokens[$stackPtr]['content'])];
			$phpcsFile->addError($error, $stackPtr, 'Found', $data);
		}
		
		return;
	}
}
