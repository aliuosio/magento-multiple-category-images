<?php
/**
 * Data Patch for updating the category image attribute to support multiple images
 *
 * @package Osio\MultipleCategoryImages\Setup\Patch\Data
 */
declare(strict_types=1);

namespace Osio\MultipleCategoryImages\Setup\Patch\Data;

use Exception;
use Magento\Catalog\Model\Category;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

/**
 * Updates the existing category image attribute to support multiple images
 */
class UpdateCategoryImageAttribute implements DataPatchInterface, PatchVersionInterface
{
    /**
     * Attribute code constant
     */
    private const ATTRIBUTE_CODE = 'image';

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory          $eavSetupFactory,
    ) {
    }

    /**
     * Apply the patch
     *
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Check if the attribute exists before updating
        $attributeId = $eavSetup->getAttributeId(Category::ENTITY, self::ATTRIBUTE_CODE);
        if (!$attributeId) {
            throw new LocalizedException(
                __(['Category image attribute not found. Please make sure it exists before running this patch.'], [])
            );
        }

        $attributeData = [
            'note' => 'Multiple image paths separated by commas. First image will be used as the main category image.',
            'backend_type' => 'varchar',
        ];

        try {
            $eavSetup->updateAttribute(
                Category::ENTITY,
                self::ATTRIBUTE_CODE,
                $attributeData
            );
        } catch (Exception $exception) {
            throw new LocalizedException(
                __(['Failed to update category image attribute: %1'], [$exception->getMessage()])
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get module dependencies
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get aliases
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Get patch version
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return '1.0.0';
    }
}
