<?php

namespace LqdCodeStyle\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;

class TraitNamingSniff implements Sniff
{
	/**
	 * @return int[]
	 */
	public function register(): array
	{
		return [
			\T_TRAIT,
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
		$suffix = \substr($traitName, -5);
		
		if (\strtolower($suffix) === 'trait') {
			return;
		}
		
		$phpcsFile->addError('Missing suffix "Trait".', $traitPointer, 'test');
	}
}
