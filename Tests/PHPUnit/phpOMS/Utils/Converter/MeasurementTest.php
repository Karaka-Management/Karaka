<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\Measurement;
use phpOMS\Utils\Converter\TemperatureType;
use phpOMS\Utils\Converter\WeightType;
use phpOMS\Utils\Converter\LengthType;
use phpOMS\Utils\Converter\AreaType;
use phpOMS\Utils\Converter\VolumeType;
use phpOMS\Utils\Converter\SpeedType;
use phpOMS\Utils\Converter\TimeType;
use phpOMS\Utils\Converter\AngleType;
use phpOMS\Utils\Converter\PressureType;
use phpOMS\Utils\Converter\EnergyPowerType;
use phpOMS\Utils\Converter\FileSizeType;

class MeasurementTest extends \PHPUnit\Framework\TestCase
{
	public function testTemperature()
	{
		$temps = TemperatureType::getConstants();

		foreach ($temps as $from) {
			foreach ($temps as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertTemperature(Measurement::convertTemperature($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testWeight()
	{
		$weights = WeightType::getConstants();

		foreach ($weights as $from) {
			foreach ($weights as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertWeight(Measurement::convertWeight($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testLength()
	{
		$lengths = LengthType::getConstants();

		foreach ($lengths as $from) {
			foreach ($lengths as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertLength(Measurement::convertLength($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testArea()
	{
		$areas = AreaType::getConstants();

		foreach ($areas as $from) {
			foreach ($areas as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertArea(Measurement::convertArea($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testVolume()
	{
		$volumes = VolumeType::getConstants();

		foreach ($volumes as $from) {
			foreach ($volumes as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertVolume(Measurement::convertVolume($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testSpeed()
	{
		$speeds = SpeedType::getConstants();

		foreach ($speeds as $from) {
			foreach ($speeds as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertSpeed(Measurement::convertSpeed($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testTime()
	{
		$times = TimeType::getConstants();

		foreach ($times as $from) {
			foreach ($times as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertTime(Measurement::convertTime($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testAngle()
	{
		$angles = AngleType::getConstants();

		foreach ($angles as $from) {
			foreach ($angles as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertAngle(Measurement::convertAngle($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testPressure()
	{
		$pressures = PressureType::getConstants();

		foreach ($pressures as $from) {
			foreach ($pressures as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertPressure(Measurement::convertPressure($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testEnergy()
	{
		$energies = EnergyPowerType::getConstants();

		foreach ($energies as $from) {
			foreach ($energies as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertEnergy(Measurement::convertEnergy($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}

	public function testFileSize()
	{
		$fileSizes = FileSizeType::getConstants();

		foreach ($fileSizes as $from) {
			foreach ($fileSizes as $to) {
				$rand = mt_rand(0, 100);
				self::assertTrue(($rand - Measurement::convertFileSize(Measurement::convertFileSize($rand, $from, $to), $to, $from)) < 1);
			}
		}
	}
}
