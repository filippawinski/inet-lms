<?php

$DB->Execute("DROP VIEW IF EXISTS vnodes ;");
$DB->Execute("DROP VIEW IF EXISTS vmacs;");

if (!$DB->GetOne('SELECT 1 FROM information_schema.columns WHERE table_name = ?  AND column_name=? ;',array('nodes','netdevicemodelid'))) 
{
    $DB->Execute("ALTER TABLE nodes ADD COLUMN netdevicemodelid integer DEFAULT NULL");
//    $DB->Execute("ALTER TABLE nodes ADD CONSTRAINT nodes_netdevicemodel_fkey FOREIGN KEY (netdevicemodelid) REFERENCES netdevicemodels (id) ON UPDATE CASCADE ON DELETE SET NULL");
}


$DB->Execute("
    CREATE VIEW vnodes AS
    SELECT n.*, m.mac
    FROM nodes n
    LEFT JOIN (SELECT nodeid, array_to_string(array_agg(mac), ',') AS mac
        FROM macs GROUP BY nodeid) m ON (n.id = m.nodeid);
");

$DB->Execute("
CREATE VIEW vmacs AS 
	SELECT n.*, m.mac, m.id AS macid 
	FROM nodes n 
	JOIN macs m ON (n.id = m.nodeid);
");


$DB->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2015021802', 'dbvex'));

?>