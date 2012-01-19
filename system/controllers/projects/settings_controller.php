<?php
/*
 * Traq
 * Copyright (C) 2009-2012 Jack Polgar
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

/**
 * Project settings controller
 *
 * @author Jack P.
 * @since 3.0
 * @package Traq
 * @subpackage Controllers
 */
class ProjectsSettingsController extends AppController
{
	public function action_index()
	{
		if (Request::$method == 'post')
		{
			$this->project->set(array(
				'name' => Request::$post['name'],
				'slug' => Request::$post['slug'],
				'info' => Request::$post['info']
			));
			
			if ($this->project->is_valid())
			{
				$this->project->save();
				Request::redirect(Request::base($this->project->href('settings')));
			}
		}
	}
}