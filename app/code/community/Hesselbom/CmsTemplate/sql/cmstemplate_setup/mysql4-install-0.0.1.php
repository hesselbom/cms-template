<?php
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

// Drop old tables
$connection->dropTable($installer->getTable('cmstemplate_page'));
$connection->dropTable($installer->getTable('cmstemplate_page_data'));

// Create columns for CmsTemplate data
$cmstemplate_page = $connection->newTable( $installer->getTable('cmstemplate/page') )
    ->addColumn('cmstemplate_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ))
    ->addColumn('cms_page_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ))
    ->addColumn('data', Varien_Db_Ddl_Table::TYPE_TEXT);

$cmstemplate_page_data = $connection->newTable( $installer->getTable('cmstemplate/page_data') )
    ->addColumn('cmstemplate_data_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ))
    ->addColumn('cmstemplate_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ))
    ->addColumn('variable', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255)
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT);

$cmstemplate_block = $connection->newTable( $installer->getTable('cmstemplate/block') )
    ->addColumn('cmstemplate_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ))
    ->addColumn('cms_block_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ))
    ->addColumn('data', Varien_Db_Ddl_Table::TYPE_TEXT);

$cmstemplate_block_data = $connection->newTable( $installer->getTable('cmstemplate/block_data') )
    ->addColumn('cmstemplate_data_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ))
    ->addColumn('cmstemplate_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ))
    ->addColumn('variable', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255)
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT);

$connection->createTable($cmstemplate_page);
$connection->createTable($cmstemplate_page_data);
$connection->createTable($cmstemplate_block);
$connection->createTable($cmstemplate_block_data);

$connection
    ->addConstraint(
        'FK_TEMPLATE_CMS_PAGE',
        $installer->getTable('cmstemplate/page'), 
        'cms_page_id',
        $installer->getTable('cms/page'), 
        'page_id',
        'cascade', 
        'cascade'
);

$connection
    ->addConstraint(
        'FK_TEMPLATE_CMS_PAGE_DATA',
        $installer->getTable('cmstemplate/page_data'), 
        'cmstemplate_id',
        $installer->getTable('cmstemplate/page'), 
        'cmstemplate_id',
        'cascade', 
        'cascade'
);

$connection
    ->addConstraint(
        'FK_TEMPLATE_CMS_BLOCK',
        $installer->getTable('cmstemplate/block'), 
        'cms_block_id',
        $installer->getTable('cms/block'), 
        'block_id',
        'cascade', 
        'cascade'
);

$connection
    ->addConstraint(
        'FK_TEMPLATE_CMS_BLOCK_DATA',
        $installer->getTable('cmstemplate/block_data'), 
        'cmstemplate_id',
        $installer->getTable('cmstemplate/block'), 
        'cmstemplate_id',
        'cascade', 
        'cascade'
);

$installer->endSetup();