<?php
class People extends Model
{
	public static function getPeople()
	{
		$people = R::findAll('people');
		return $people;
	}
	public static function getCurrentPeople()
	{
		$people = R::findAll('people', 'display is true and is_current is true' );
		return $people;
	}
	
	public static function getExPeople()
	{
		$people = R::findAll('people', 'display is true and is_current is false' );
		return $people;
	}
	
	public static function peopleCount()
	{
		$count = R::count('people');
		return $count;
	}
	
	public static function getPerson($id)
	{
		$person = R::load('people', $id);
		return $person;		
	}
	public static function createPerson($name, $position, $pic, $text, $isCurrent, $display)
	{
		$person = R::dispense( 'people' );
		$person->name = $name;
		$person->position = $position;
		$person->pic = $pic;
		$person->text = $text;
		$person->isCurrent = $isCurrent;
		$person->display = $display;
		$id = R::store($person);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updatePerson($id, $name, $position, $pic, $text, $isCurrent, $display)
	{
		$person = R::load( 'people', $id );
		$person->name = $name;
		$person->position = $position;
		$person->pic = $pic;
		$person->text = $text;
		$person->isCurrent = $isCurrent;
		$person->display = $display;
		$id = R::store($person);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deletePerson($id)
	{
		$person = R::load( 'people', $id );
		$res = R::trash( $person );
		$res = R::findOne('people', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;
		
	}
}
?>