<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
/** @var miniShop2 $miniShop2 */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
//            $modelPath = $modx->getOption('msinformme_core_path', null,
//                    $modx->getOption('core_path') . 'components/msinformme/') . 'model/';
//            $modx->addPackage('msinformme', $modelPath);

            // Добавить колонку im_email
            $cusFields = array();
            $table = $modx->config['table_prefix'] . 'ms2_products';
            $t = $modx->prepare("SHOW COLUMNS IN {$table}");
            $t->execute();
            while ($cus = $t->fetch(PDO::FETCH_ASSOC)) {
                $cusFields[$cus['Field']] = $cus['Field'];
            }
            if (!in_array('im_email', $cusFields)) {
                $sql = 'ALTER TABLE ' . $table . "  ADD `im_email` VARCHAR(100) NOT NULL DEFAULT '' AFTER `size`;";
                $modx->exec($sql);
            }

//            $manager = $modx->getManager();
//            $objects = array();
//            $schemaFile = MODX_CORE_PATH . 'components/msinformme/model/schema/msinformme.mysql.schema.xml';
//            if (is_file($schemaFile)) {
//                $schema = new SimpleXMLElement($schemaFile, 0, true);
//                if (isset($schema->object)) {
//                    foreach ($schema->object as $obj) {
//                        $objects[] = (string)$obj['class'];
//                    }
//                }
//                unset($schema);
//            }
//            foreach ($objects as $tmp) {
//                $table = $modx->getTableName($tmp);
//                $sql = "SHOW TABLES LIKE '" . trim($table, '`') . "'";
//                $stmt = $modx->prepare($sql);
//                $newTable = true;
//                if ($stmt->execute() && $stmt->fetchAll()) {
//                    $newTable = false;
//                }
//                // If the table is just created
//                if ($newTable) {
//                    $manager->createObjectContainer($tmp);
//                } else {
//                    // If the table exists
//                    // 1. Operate with tables
//                    $tableFields = array();
//                    $c = $modx->prepare("SHOW COLUMNS IN {$modx->getTableName($tmp)}");
//                    $c->execute();
//                    while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
//                        $tableFields[$cl['Field']] = $cl['Field'];
//                    }
//                    foreach ($modx->getFields($tmp) as $field => $v) {
//                        if (in_array($field, $tableFields)) {
//                            unset($tableFields[$field]);
//                            $manager->alterField($tmp, $field);
//                        } else {
//                            $manager->addField($tmp, $field);
//                        }
//                    }
//                    foreach ($tableFields as $field) {
//                        $manager->removeField($tmp, $field);
//                    }
//                    // 2. Operate with indexes
//                    $indexes = array();
//                    $c = $modx->prepare("SHOW INDEX FROM {$modx->getTableName($tmp)}");
//                    $c->execute();
//                    while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
//                        $indexes[$cl['Key_name']] = $cl['Key_name'];
//                    }
//                    foreach ($modx->getIndexMeta($tmp) as $name => $meta) {
//                        if (in_array($name, $indexes)) {
//                            unset($indexes[$name]);
//                        } else {
//                            $manager->addIndex($tmp, $name);
//                        }
//                    }
//                    foreach ($indexes as $index) {
//                        $manager->removeIndex($tmp, $index);
//                    }
//                }
//            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
