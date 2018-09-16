<?php
namespace ArtinCMS\LUM;
use Illuminate\Support\Facades\Facade;

class LUMFacade extends Facade
{
	protected static function getFacadeAccessor() {
		return 'FAQ';
	}
}