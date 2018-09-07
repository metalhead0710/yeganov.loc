<?php
class Video extends Model
{
	public static function getVideo()
	{
		$videos = R::findAll('videos', 'ORDER BY sort_order');
		return $videos;
	}
	
	public static function videoCount()
	{
		$count = R::count('videos');
		return $count;
	}
	
	public static function getOneVideo($id)
	{
		$video = R::load('videos', $id);
		return $video;		
	}
	
	public static function createVideo($title, $sort_order, $url)
	{
		$video = R::dispense( 'videos' );
		$video->title = $title;
		$video->sort_order = $sort_order;
		$video->url = $url;
		$id = R::store($video);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updateVideo($id, $title, $sort_order, $url)
	{
		$video = R::load( 'videos', $id );
		$video->title = $title;
		$video->sort_order = $sort_order;
		$video->url = $url;
		$id = R::store($video);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deleteVideo($id)
	{
		$video = R::load( 'videos', $id );
		$res = R::trash( $video );
		$res = R::findOne('videos', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;
		
	}
}

?>