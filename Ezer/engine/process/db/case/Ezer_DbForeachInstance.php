<?php
/**
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please send
 * e-mail to johnathan.kanarek@gmail.com
 */


/**
 * Purpose:     Stores a single instance for the execution of a sequence for a specified case
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Case
 */
class Ezer_DbForeachInstance extends Ezer_ForeachInstance
{
	/**
	 * @var Ezer_IntForeachInstance
	 */
	protected $db_instance;
	
	/**
	 * @param Ezer_IntForeachInstance $db_instance
	 * @param Ezer_ScopeInstance $case
	 * @param Ezer_Foreach $sequence
	 */
	public function __construct(Ezer_IntForeachInstance $db_instance, Ezer_ScopeInstance &$scope_instance, Ezer_Foreach $foreach)
	{
		$this->db_instance = $db_instance;
		parent::__construct($this->db_instance->getId(), $scope_instance, $foreach);
	}
	
	public function persist()
	{
		$this->db_instance->setStatus($this->getStatus());
		$this->db_instance->setContainer($this->scope_instance);
		$this->db_instance->persist();
	
		if($this->step_instances && is_array($this->step_instances))
		{
			foreach($this->step_instances as $index => $step_instance)
				$this->step_instances[$index]->persist();
		}
	}
}

