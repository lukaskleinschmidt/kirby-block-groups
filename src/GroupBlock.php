<?php

namespace LukasKleinschmidt\BlockGroups;

use Kirby\Cms\Block;
use Kirby\Exception\InvalidArgumentException;

class GroupBlock extends Block
{
    protected array $data;

    protected Group $group;

    public function __construct(array $params)
	{
		parent::__construct($params);

        if (isset($params['data']) === false) {
			throw new InvalidArgumentException('The block data is missing');
		}

	    if (isset($params['group']) === false) {
			throw new InvalidArgumentException('The block group is missing');
		}

        $this->data  = $params['data'];
        $this->group = $params['group'];
	}

    public function controller(): array
	{
		return $this->data() + parent::controller();
	}

    public function data(): array
    {
        return $this->data;
    }

    public function group(): Group
    {
        return $this->group;
    }

	public function toHtml(): string
	{
        return $this->group()->render($this);
	}
}
