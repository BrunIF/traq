<?php
/*!
 * Traq
 * Copyright (C) 2009-2012 Traq.io
 * 
 * This file is part of Traq.
 * 
 * Traq is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 only.
 * 
 * Traq is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Traq. If not, see <http://www.gnu.org/licenses/>.
 */

require __DIR__ . '/base.php';

/**
 * Admin Project Roles controller
 *
 * @author Jack P.
 * @since 3.0
 * @package Traq
 * @subpackage Controllers
 */
class AdminProjectRolesController extends AdminBase
{
	/**
	 * Role listing page.
	 */
	public function action_index()
	{
		View::set('roles', ProjectRole::fetch_all());
	}
	
	/**
	 * New role page.
	 */
	public function action_new()
	{
		// Create a new role object
		$role = new ProjectRole;
		
		// Check if the form has been submitted
		if (Request::$method == 'post')
		{
			// Set the role name
			$role->name = Request::$post['name'];
			
			// Validate the data
			if ($role->is_valid())
			{
				// Create and redirect
				$role->save();
				Request::redirect(Request::base('/admin/roles'));
			}
		}
		
		View::set('role', $role);
	}
	
	/**
	 * Edit role page.
	 */
	public function action_edit($id)
	{
		// Fetch the role
		$role = ProjectRole::find($id);
		
		// Check if the form has been submitted
		if (Request::$method == 'post')
		{
			// Update the role name
			$role->name = Request::$post['name'];
			
			// Validate the data
			if ($role->is_valid())
			{
				// Save and redirect
				$role->save();
				Request::redirect(Request::base('/admin/roles'));
			}
		}
		
		View::set('role', $role);
	}
	
	/**
	 * Delete role page.
	 */
	public function action_delete($id)
	{
		// Fetch and delete the role, then redirect
		$role = ProjectRole::find($id);
		$role->delete();
		Request::redirect(Request::base('/admin/roles'));
	}
}