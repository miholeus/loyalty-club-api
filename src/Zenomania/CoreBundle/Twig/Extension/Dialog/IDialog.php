<?php

namespace Zenomania\CoreBundle\Twig\Extension\Dialog;

interface IDialog
{

	public function makeDialog($parentId, $parameterArray = []);

	public function getWidgetName();
}
