# Magento Multiple Category Images

This Magento 2 module allows multiple images to be associated with a single category. The first image is used as the main category image.

## Features

- Extends category image attribute to support multiple images
- Uses comma-separated format for storing image paths
- Maintains compatibility with existing implementations

## Requirements

- Magento 2.4.x
- PHP 8.1 or higher

## Installation

### Using Composer

```bash
composer require osio/magento-multiple-category-images
bin/magento setup:upgrade
bin/magento cache:clean
```


## Usage

1. Go to **Catalog > Categories** in the Magento Admin
2. Select a category to edit
3. In the **Content** section, use the **Image** field

## License

OSL 3.0 and AFL 3.0
