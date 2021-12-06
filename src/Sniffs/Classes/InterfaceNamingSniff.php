<?php

namespace LqdCodeStyle\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;

class InterfaceNamingSniff implements Sniff
{
	/**
	 * @return int[]
	 */
	public function register(): array
	{
		return [
			\T_INTERFACE,
		];
	}
	
	public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr): void
	{
		$traitName = ClassHelper::getName($phpcsFile, $stackPtr);
		
		$this->checkSuffix($phpcsFile, $stackPtr, $traitName);
		
		return;
	}
	
	private function checkSuffix(File $phpcsFile, int $traitPointer, string $traitName): void
	{
		$suffix = \substr($traitName, 0, 1);
		
		if ($suffix === 'I') {
			return;
		}
		
		$phpcsFile->addError('Missing prefix "I".', $traitPointer, 'Found');
	}
}
