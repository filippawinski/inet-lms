<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2012 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

function NodeStats($id, $dt) {
	global $DB;
	if ($stats = $DB->GetRow('SELECT SUM(download) AS download, SUM(upload) AS upload 
			    FROM stats WHERE nodeid=? AND dt>?', array($id, time() - $dt))) {
		list($result['download']['data'], $result['download']['units']) = setunits($stats['download']);
		list($result['upload']['data'], $result['upload']['units']) = setunits($stats['upload']);
		$result['downavg'] = $stats['download'] * 8 / 1000 / $dt;
		$result['upavg'] = $stats['upload'] * 8 / 1000 / $dt;
	}
	return $result;
}

if (isset($_GET['nodegroups'])) {
	$nodegroups = $LMS->GetNodeGroupNamesByNode(intval($_GET['id']));

	$SMARTY->assign('nodegroups', $nodegroups);
	$SMARTY->assign('total', sizeof($nodegroups));
	$SMARTY->display('nodegrouplistshort.html');
	die;
}

if (!preg_match('/^[0-9]+$/', $_GET['id'])) {
	$SESSION->redirect('?m=nodelist');
}
else
	$nodeid = $_GET['id'];

if (!$LMS->NodeExists($nodeid)) {
	if (isset($_GET['ownerid']))
		$SESSION->redirect('?m=customerinfo&id=' . $_GET['ownerid']);
	else if ($DB->GetOne('SELECT 1 FROM nodes WHERE id = ? AND ownerid = 0', array($nodeid)))
		$SESSION->redirect('?m=netdevinfo&ip=' . $nodeid . '&id=' . $LMS->GetNetDevIDByNode($nodeid));
	else
		$SESSION->redirect('?m=nodelist');
}

if ($_pluglinks['nodeinfo']) {
    for ($i=0; $i<sizeof($_pluglinks['nodeinfo']); $i++)
	$_pluglinks['nodeinfo'][$i] = str_replace('[nodeid]',$nodeid,$_pluglinks['nodeinfo'][$i]);
}


if (isset($_GET['devid'])) {
	$error['netdev'] = trans('It scans for free ports in selected device!');
	$SMARTY->assign('error', $error);
	$SMARTY->assign('netdevice', $_GET['devid']);
}

if (check_modules(110))
    include(MODULES_DIR.'/nodemonit.inc.php');

$nodeinfo = $LMS->GetNode($nodeid);
$nodegroups = $LMS->GetNodeGroupNamesByNode($nodeid);
$othernodegroups = $LMS->GetNodeGroupNamesWithoutNode($nodeid);
$customerid = $nodeinfo['ownerid'];

include(MODULES_DIR . '/customer.inc.php');

if (get_conf('voip.enabled','0'))
    include(MODULES_DIR.'/customer.voip.inc.php');

$nodestats['hour'] = NodeStats($nodeid, 60 * 60);
$nodestats['day'] = NodeStats($nodeid, 60 * 60 * 24);
$nodestats['month'] = NodeStats($nodeid, 60 * 60 * 24 * 30);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

if (!isset($_GET['ownerid']))
	$SESSION->save('backto', $SESSION->get('backto') . '&ownerid=' . $customerid);

if ($nodeinfo['netdev'] == 0)
	$netdevices = $LMS->GetNetDevNames();
else
	$netdevices = $LMS->GetNetDev($nodeinfo['netdev']);

$layout['pagetitle'] = trans('Node Info: $a', $nodeinfo['name']);

include(MODULES_DIR . '/nodexajax.inc.php');

$nodeinfo = $LMS->ExecHook('node_info_init', $nodeinfo);

$annex_info = array('section'=>'customer','ownerid'=>$customerid);
$SMARTY->assign('annex_info',$annex_info);
include(MODULES_DIR.'/customer_xajax.inc.php');
$LMS->RegisterXajaxFunction(array('get_list_annex','delete_file_annex'));

$SMARTY->assign('xajax', $LMS->RunXajax());

$nodeauthtype = array();
$authtype = $nodeinfo['authtype'];
if ($authtype != 0) {
	$nodeauthtype['pppoe'] = ($authtype & 1);
	$nodeauthtype['dhcp'] = ($authtype & 2);
	$nodeauthtype['eap'] = ($authtype & 4);
}

$SMARTY->assign('nodeauthtype',$nodeauthtype);
$SMARTY->assign('netdevices', $netdevices);
$SMARTY->assign('nodestats', $nodestats);
$SMARTY->assign('nodegroups', $nodegroups);
$SMARTY->assign('othernodegroups', $othernodegroups);
$SMARTY->assign('nodeinfo', $nodeinfo);
$SMARTY->display('nodeinfo.html');
?>
