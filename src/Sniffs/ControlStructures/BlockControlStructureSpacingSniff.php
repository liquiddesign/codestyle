<?php

namespace LqdCodeStyle\Sniffs\ControlStructures;

use PHP_CodeSniffer\Sniffs\Sniff;

class BlockControlStructureSpacingSniff extends \SlevomatCodingStandard\Sniffs\ControlStructures\BlockControlStructureSpacingSniff implements Sniff
{
	/**
	 * @return int[]
	 */
	protected function getSupportedTokens(): array
	{
		return [
			\T_IF,
			\T_DO,
			\T_WHILE,
			\T_FOR,
			\T_FOREACH,
			\T_SWITCH,
			\T_TRY,
		];
	}
}
