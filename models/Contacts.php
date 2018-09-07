<?php
class Contacts extends Model
{
	public static function	getContatcs()
	{
		$contact = R::load('contacts', 1);
		return $contact;
	}
	public static function getEmail()
	{
		$email = self::getContatcs()->email;
		return $email;
	}
	public static function createRow()
	{
		$contact = R::exec( 'insert into contacts values (1, null, null, null, null, null, null)' );
		return $contact;
	}
	public static function updateContact($email, $tel1, $tel2, $vk, $facebook, $youtube)
	{
		$contact = R::load( 'contacts', 1 );
		$contact->email = $email;
		$contact->tel1 = $tel1;
		$contact->tel2 = $tel2;
		$contact->vk = $vk;
		$contact->facebook = $facebook;
		$contact->youtube = $youtube;
		$id = R::store($contact);
		if (isset($id))
			return true;
		else
		return false;
	}
}
?>