<?php
/**
 * jqScheduler 
 *
 * Basis for all calendar backends
 *
 * @version 1.0
 * @author Tony Tomov
 * @copyright (c) 2011 Tony Tomov
 */
abstract class Backend
{
	/**
	 * Return event(s) as JSON
	 * @param  integer Event's start
	 * @param  integer Event's end
	 */
  
	abstract public function getEvents($start, $end);
	
  /**
   * Add a single event to the database
   *
   * @param  integer Event's start
   * @param  integer Event's end
   * @param  string  Event's summary
   * @param  string  Event's description
   * @param  string  Event's location
   * @param  string  Event's category
   * @param  string  Event's access
   * @param  integer Event allDay state
   * @access public
   */
	abstract public function newEvent( $data = array() );
	//$start, $end, $title, $description, $location, $categories, $access, $allDay);

  /**
   * Edit a single event
   *
   * @param  integer Event's id
   * @param  integer Event's start
   * @param  integer Event's end
   * @param  string  Event's summary
   * @param  string  Event's description
   * @param  string  Event's location
   * @param  string  Event's category
   * @param  string  Event's access
   * @param  integer Event allDay state
   * @access public
   */
  abstract public function editEvent( $data = array() );
		  //$id, $start, $end, $title, $description, $location, $categories, $access, $allDay );

  /**
   * Move a single event
   *
   * @param  integer Event identifier
   * @param  integer Event's new start
   * @param  integer Event's new end
   * @param  integer Event allDay state
   * @access public
   */
  abstract public function moveEvent($id, $start, $end, $allDay);

  /**
   * Resize a single event
   *
   * @param  integer Event identifier
   * @param  integer Event's new start
   * @param  integer Event's new end
   * @access public
   */
  abstract public function resizeEvent($id, $start, $end);
  
  /**
   * Remove a single event from the database
   * 
   * @param  integer Event identifier
   * @access public
   */
  abstract public function removeEvent($id);
}
?>