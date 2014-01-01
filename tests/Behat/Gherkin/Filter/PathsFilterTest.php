<?php

namespace Tests\Behat\Gherkin\Filter;

use Behat\Gherkin\Filter\PathsFilter;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioNode;

require_once 'FilterTest.php';

class PathsFilterTest extends FilterTest
{
    public function testIsFeatureMatchFilter()
    {
        $feature = new FeatureNode(null, null, array(), null, array(), null, null, __FILE__, 1);

        $filter = new PathsFilter(array(__DIR__));
        $this->assertTrue($filter->isFeatureMatch($feature));

        $filter = new PathsFilter(array('/abc', '/def', dirname(__DIR__)));
        $this->assertTrue($filter->isFeatureMatch($feature));

        $filter = new PathsFilter(array('/abc', '/def', __DIR__));
        $this->assertTrue($filter->isFeatureMatch($feature));

        $filter = new PathsFilter(array('/abc', __DIR__, '/def'));
        $this->assertTrue($filter->isFeatureMatch($feature));

        $filter = new PathsFilter(array('/abc', '/def', '/wrong/path'));
        $this->assertFalse($filter->isFeatureMatch($feature));
    }

    public function testIsScenarioMatchFilter()
    {
        $scenario = new ScenarioNode(null, array(), array(), null, 2);
        $feature = new FeatureNode(null, null, array(), null, array($scenario), null, null, __FILE__, 1);

        $filter = new PathsFilter(array(dirname(__DIR__)));
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PathsFilter(array('/abc', '/def', dirname(__DIR__)));
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PathsFilter(array('/abc', '/def', __DIR__));
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PathsFilter(array('/abc', __DIR__, '/def'));
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PathsFilter(array('/abc', '/def', '/wrong/path'));
        $this->assertFalse($filter->isScenarioMatch($scenario));
    }
}
