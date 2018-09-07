<?php
class Music extends Model
{
	public static function getMusic()
	{
		$music = R::findAll('music', 'ORDER BY sort_order');
		return $music;
	}
	public static function getOneSong($id)
	{
		$song = R::load('music', $id);
		return $song;
	}
	public static function musicCount()
	{
		$count = R::count('music');
		return $count;
	}
	
	public static function addSong($title, $author, $songFilename, $songUrl, $picFileName, $picUrl, $sort_order)
	{
		$song = R::dispense( 'music' );
		$song->title = $title;
		$song->author = $author;
		$song->songFileName = $songFilename;
		$song->songUrl = $songUrl;
		$song->picFileName = $picFileName;
		$song->picUrl = $picUrl;
		$song->sort_order = $sort_order;
		$id = R::store($song);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updateSong($id, $title, $author, $songFilename, $songUrl, $picFileName, $picUrl, $sort_order)
	{
		$song = R::load( 'music', $id );
		$song->title = $title;
		$song->author = $author;
		$song->songFileName = $songFilename;
		$song->songUrl = $songUrl;
		$song->picFileName = $picFileName;
		$song->picUrl = $picUrl;
		$song->sort_order = $sort_order;
		$id = R::store($song);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deleteSong($id)
	{
		$song = R::load( 'music', $id );
		$res = R::trash( $song );
		$res = R::findOne('music', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;		
	}
}
?>
