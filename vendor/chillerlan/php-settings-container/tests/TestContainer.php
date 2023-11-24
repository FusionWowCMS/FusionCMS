<?php
/**
 * Class TestContainer
 *
 * @created      28.08.2018
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\SettingsTest;

use chillerlan\Settings\SettingsContainerAbstract;

class TestContainer extends SettingsContainerAbstract{
	use TestOptionsTrait;

	private string $test3 = 'what';
}
