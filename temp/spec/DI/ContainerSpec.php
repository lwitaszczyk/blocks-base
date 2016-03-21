<?php

namespace spec\Blocks\DI;

use Blocks\DI\Arguments;
use Blocks\DI\Exception\ExceptionClassNotAccepted;
use Blocks\DI\Exception\ExceptionNotOverrideInducedParameter;
use Blocks\DI\Exception\ExceptionNotOverrideInducedService;
use Blocks\DI\Exception\ExceptionParameterNotDefined;
use Blocks\DI\Exception\ExceptionServiceNotDefined;
use Blocks\DI\Parameter;
use Blocks\DI\Service;
use Blocks\DI\ArgumentByParameter;
use Blocks\DI\ArgumentByService;
use PhpSpec\ObjectBehavior;
use Tests\Blocks\DI\FakeDBConfiguration;
use Tests\Blocks\DI\FakeDBConnection;

class ContainerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\DI\Container');
    }

    public function it_should_get_previously_set_parameter()
    {
        $host = 'FAKE-HOST';

        $this->add([
            (new Parameter('db.host', $host)),
        ])->shouldBe($this);
        $this->getParameter('db.host')->shouldEqual($host);
    }

    public function it_should_thow_exception_for_not_existing_item()
    {
        $this->shouldThrow(ExceptionParameterNotDefined::class)->during('getParameter', ['not.existing.parameter']);
        $this->shouldThrow(ExceptionServiceNotDefined::class)->during('getService', ['not.existing.service']);
    }

    public function it_not_should_override_induced_parameter()
    {
        $name = 'test-name';
        $originalValue = 'original-value';
        $overridenValue = 'new-value';

        $this->add([
            (new Parameter($name, $originalValue)),
        ]);
        $this->getParameter($name)->shouldEqual($originalValue);

        $this->shouldThrow(ExceptionNotOverrideInducedParameter::class)->during('add', [
            [
                (new Parameter($name, $overridenValue)),
            ],
        ]);
    }

    public function it_should_manifestly_override_parameter()
    {
        $name = 'test-name';
        $originalValue = 'original-value';
        $overridenValue = 'new-value';

        $this->add([
            (new Parameter($name, $originalValue)),
        ]);
        $this->getParameter($name)->shouldEqual($originalValue);

        $this->add([
            (new Parameter($name, $overridenValue, true)),
        ]);
        $this->getParameter($name)->shouldEqual($overridenValue);
    }

    public function it_not_should_override_induced_service()
    {
        $this->add([
            (new Parameter('db.host', 'HOST')),
            (new Parameter('db.user', 'USER')),
            (new Service(FakeDBConfiguration::class))->add([
                (new Arguments())->add([
                    new ArgumentByParameter('db.host'),
                    new ArgumentByParameter('db.host'),
                ]),
            ]),
        ])->shouldBe($this);

        $this->getService(FakeDBConfiguration::class)->shouldHaveType(FakeDBConfiguration::class);

        $this->shouldThrow(ExceptionNotOverrideInducedService::class)->during('add', [
            [
                (new Service(FakeDBConfiguration::class)),
            ],
        ]);
    }

    public function it_should_get_service_defined_injected_by_instance()
    {
        $serviceName = 'configuration';
        $configuration = new FakeDBConfiguration('HOST', 'USER');

        $this->add([
            (new Service($serviceName, FakeDBConfiguration::class, $configuration)),
        ]);
        $this->getService($serviceName)->shouldBe($configuration);
    }

    public function it_should_get_service_defined_by_class_name()
    {
        $this->add([
            (new Parameter('db.host', 'HOST')),
            (new Parameter('db.user', 'USER')),
            (new Service(FakeDBConfiguration::class))->add([
                (new Arguments())->add([
                    new ArgumentByParameter('db.host'),
                    new ArgumentByParameter('db.user'),
                ]),
            ]),
        ])->shouldBe($this);
        $this->getService(FakeDBConfiguration::class)->shouldHaveType(FakeDBConfiguration::class);

        $this->add([
            (new Service(FakeDBConnection::class))->add([
                (new Arguments())->add([
                    new ArgumentByService(FakeDBConfiguration::class),
                ]),
            ]),
        ])->shouldBe($this);
        $this->getService(FakeDBConnection::class)->shouldHaveType(FakeDBConnection::class);
    }

    public function it_should_get_parameters_by_tag()
    {
        $tag = 'TAG';
        $this->add([
            (new Parameter('param1', 'value1'))->addTags([$tag]),
            (new Parameter('param2', 'value2'))->addTags([$tag]),
            (new Parameter('param3', 'value3'))->addTags([$tag]),
        ])->shouldBe($this);

        $this->findParametersByTag($tag)->shouldBeLike([
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3',
        ]);
    }

    public function it_should_get_services_by_tag()
    {
        $host = 'HOST';
        $user = 'USER';

        $tag = 'TAG';
        $this->add([
            (new Parameter('db.host', $host)),
            (new Parameter('db.user', $user)),
            (new Service('db1', FakeDBConfiguration::class))->add([
                (new Arguments())->add([
                    new ArgumentByParameter('db.host'),
                    new ArgumentByParameter('db.user'),
                ]),
            ])->addTags([$tag]),
            (new Service('db2', FakeDBConfiguration::class))->add([
                (new Arguments())->add([
                    new ArgumentByParameter('db.host'),
                    new ArgumentByParameter('db.user'),
                ]),
            ])->addTags([$tag]),
        ])->shouldBe($this);

        $this->findServicesByTag($tag)->shouldBeLike([
            'db1' => new FakeDBConfiguration($host, $user),
            'db2' => new FakeDBConfiguration($host, $user),
        ]);
    }

    public function it_should_add_not_accepted_class()
    {
        $this->shouldThrow(ExceptionClassNotAccepted::class)->during('add', [
            [
                new \stdClass(),
            ],
        ]);
    }
}
