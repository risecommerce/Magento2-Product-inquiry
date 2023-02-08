##Product Inquiry with Hide Price and Add To Cart Button Extension

##Support: 
version - 2.3.x, 2.4.x

##How to install Extension

Method I)

1. Download the archive file. 
2. Unzip the files 
3. Create a folder path [Magento_Root]/app/code/Risecommerce/ProductInquiry 
4. Drop/move the unzipped files to directory '[Magento_Root]/app/code/Risecommerce/ProductInquiry'

Method II)

Using Composer

composer require risecommerce/magento-2-product-inquiry-extension

#Enable Extension:
- php bin/magento module:enable Risecommerce_ProductInquiry
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

#Disable Extension:
- php bin/magento module:disable Risecommerce_ProductInquiry
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush
