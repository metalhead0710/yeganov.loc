<?php
class Messages
{
	public static function getMessages()
	{
		$messages = R::findAll('messages');
		return $messages;
	}
	public static function messagesCount()
	{
		$count = R::count('messages', 'where unread = 1');
		return $count;
	}
	
	public static function getOnemessage($id)
	{
		$message = R::load('messages', $id);
		return $message;		
	}
	public static function addMessage($name, $email, $phone, $content)
	{
		$message = R::dispense( 'messages' );
		$message->name = $name;
		$message->email = $email;
		$message->phone = $phone;
		$message->content = $content;
		$message->unread = true;
		$id = R::store($message);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function readMessage($id)
	{
		$message = R::load( 'messages', $id );
		$message->unread = false;
		$id = R::store($message);
		if (isset($id))
		{
			return true;
		}			
		else
		return false;
	}
	public static function deleteMessage($id)
	{
		$message = R::load( 'messages', $id );
		$res = R::trash( $message );
		$res = R::findOne('messages', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;		
	}
}
?>