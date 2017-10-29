<?php namespace DCarbone\PHPConsulAPITests\Usage\Operator;

/*
   Copyright 2016-2017 Daniel Carbone (daniel.p.carbone@gmail.com)

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

use DCarbone\PHPConsulAPI\Config;
use DCarbone\PHPConsulAPI\Operator\AutopilotConfiguration;
use DCarbone\PHPConsulAPI\Operator\OperatorClient;
use DCarbone\PHPConsulAPITests\ConsulManager;
use PHPUnit\Framework\TestCase;

/**
 * Class AutopilotTests
 * @package DCarbone\PHPConsulAPITests\Usage\Operator
 */
class AutopilotTests extends TestCase {
    public static function setUpBeforeClass() {
        ConsulManager::startSingle();
    }

    public static function tearDownAfterClass() {
        ConsulManager::stopSingle();
    }

    public function testCanGetAutopilotConfiguration() {
        $client = new OperatorClient(new Config());

        list($conf, $err) = $client->autopilotGetConfiguration();
        $this->assertNull($err, sprintf('Unable to list autopilot configuration: %s', $err));
        $this->assertInstanceOf(AutopilotConfiguration::class,
            $conf,
            sprintf('Expected instance of %s, saw: %s', AutopilotConfiguration::class, json_encode($conf)));
    }


}