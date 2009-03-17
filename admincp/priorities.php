<?php
/**
 * Traq
 * Copyright (c) 2009 Rainbird Studios
 * $Id$
 */

require("global.php");

if(!$user->group->isadmin) {
	exit;
}

if($_REQUEST['action'] == "manage" || $_REQUEST['action'] == '') {
	adminheader('Priorities');
	?>
	<form action="priorities.php" method="post">
	<input type="hidden" name="action" value="save" />
	<div id="content">
		<div class="content-group">
			<div class="content-title">Priorities</div>
			<table width="100%" class="statustypeslist" cellspacing="0" cellpadding="4">
				<thead>
					<tr>
						<th class="id" width="50">ID</th>
						<th class="name">Name</th>
						<th class="actions" width="150"><div align="right">Actions</div></th>
					</tr>
				</thead>
				<tbody>
				<? foreach(getpriorities() as $priority) { ?>
				<tr>
					<td class="id"><input type="text" name="types[<?=$priority['id']?>][id]" value="<?=$priority['id']?>" style="width:50px;" /></td>
					<td class="name"><input type="text" name="types[<?=$priority['id']?>][name]" value="<?=$priority['name']?>" /></td>
					<td class="actions" align="right"><a href="javascript:void(0);" onclick="if(confirm('Are you sure you want to delete priority: <?=$priority['name']?>')) { window.location='priorities.php?action=delete&id=<?=$priority['id']?>' }">Delete</a></td>
				</tr>
				<? } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center"><input type="submit" value="Save" /> <input type="reset" value="Reset" /></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	</form>
	<br />
	<form action="priorities.php" method="post">
	<input type="hidden" name="action" value="create" />
	<div id="content">
		<div class="content-group">
			<div class="content-title">New Priority</div>
			<table width="100%" cellspacing="0" cellpadding="4">
				<thead>
					<tr>
						<th width="50">ID</th>
						<th>Name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td><input type="text" name="id" style="width:50px;" /></td>
					<td><input type="text" name="name" /></td>
					<td colspan="3" align="right"><input type="submit" value="Create" /></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	</form>
	<?
	adminfooter();
} elseif($_POST['action'] == "save") {
	foreach($_POST['types'] as $id => $type) {
		if(!$db->numrows($db->query("SELECT * FROM ".DBPREFIX."priorities WHERE id='".$db->escapestring($type['id'])."' AND id != '".$db->escapestring($id)."' LIMIT 1"))) {
			$db->query("UPDATE ".DBPREFIX."priorities SET id='".$db->escapestring($type['id'])."', name='".$db->escapestring($type['name'])."' WHERE id='".$db->escapestring($id)."' LIMIT 1");
		}
	}
	header("Location: priorities.php");
} elseif($_POST['action'] == "create") {
	if($db->numrows($db->query("SELECT * FROM ".DBPREFIX."priorities WHERE id != '".$db->escapestring($_POST['id'])."' LIMIT 1"))) {
		$db->query("INSERT INTO ".DBPREFIX."priorities VALUES(".$db->escapestring($_POST['id']).",'".$db->escapestring($_POST['name'])."')");
	}
	header("Location: priorities.php");
} elseif($_REQUEST['action'] == "delete") {
	$db->query("DELETE FROM ".DBPREFIX."priorities WHERE id='".$db->escapestring($_REQUEST['id'])."' LIMIT 1");
	header("Location: priorities.php");
}
?>