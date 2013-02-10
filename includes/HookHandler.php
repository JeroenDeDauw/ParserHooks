<?php

namespace ParserHooks;

use ParamProcessor\ProcessingResult;

interface HookHandler {

	public function handle( \Parser $parser, ProcessingResult $result );

}