<?php

namespace LqdCodingStandard\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class UnusedParameterSniff extends \SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff implements Sniff
{
	public function process(File $phpcsFile, $functionPointer): void
	{
		$tokens = $phpcsFile->getTokens();
		
		if ($tokens[$functionPointer]['type'] === 'T_CLOSURE') {
			return;
		}
		
		parent::process($phpcsFile, $functionPointer);
	}
}
