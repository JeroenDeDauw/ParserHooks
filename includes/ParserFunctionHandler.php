<?php

namespace ParserHooks;

use ParamProcessor\ProcessingResult;

interface ParserFunctionHandler {

	public function handle( \Parser $parser, ProcessingResult $result );

}