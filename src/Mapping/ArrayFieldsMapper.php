<?php

declare(strict_types=1);

namespace Ethyl\Mapping;

use InvalidArgumentException;

/**
 * Array field mapper.
 *
 * @package Ethyl\Mapping
 */
class ArrayFieldsMapper extends AbstractMapper
{
    /**
     * @var array
     */
    protected $srcDstConfig;

    /**
     * @var int
     */
    protected $mappingPolicy;

    /**
     * @var bool
     */
    protected $reverseMapping;

    /**
     * @var array
     */
    protected $mappingConfig;

    /**
     * ArrayFieldsMapper constructor.
     *
     * @param array $config
     * @param int $policy
     * @param bool $reverseMapping
     */
    public function __construct(array $config, int $policy = self::MAP_FILL_WITH_EMPTY, bool $reverseMapping = false)
    {
        $this->srcDstConfig    = $config;
        $this->mappingPolicy  = $policy;
        $this->reverseMapping = $reverseMapping;
        $this->mappingConfig   = $this->reverseMapping ? array_flip($this->srcDstConfig) : $this->srcDstConfig;
    }

    /**
     * @inheritDoc
     */
    public function map($value): array
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('The input must be an array.');
        }

        if (empty($value) || empty($this->srcDstConfig)) {
            return $value;
        }

        return $this->mapArray($value);
    }

    /**
     * Internal mapping function
     *
     * @param array $input
     * @return array
     */
    protected function mapArray(array $input): array
    {
        $result = [];

        foreach ($this->mappingConfig as $inputKey => $outputKey) {
            if (isset($input[$inputKey])) {
                $result[$outputKey] = $input[$inputKey];
            } else {
                switch ($this->mappingPolicy) {
                    case self::MAP_FILL_WITH_NULL:
                        $result[$outputKey] = null;
                        break;
                    case self::MAP_FILL_WITH_EMPTY:
                        $result[$outputKey] = '';
                        break;
                    case self::MAP_IGNORE_MISSING:
                    default:
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        $info  = parent::debug();
        $config = [
            'mappings'       => $this->srcDstConfig,
            'policy'         => self::POLICY_NAMES[$this->mappingPolicy],
            'reverseMapping' => $this->reverseMapping,
        ];

        return array_merge($info, ['config' => $config]);
    }
}
