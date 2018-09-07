<?php
class News extends Model
{
	const LIM = 10;
	
	public static function getAllNews()
	{
		$news = R::findAll('news', 'ORDER BY date desc, time desc' );
		return $news;
	}
	
	public static function getFirstNews()
	{
		$news = R::findAll('news', 'ORDER BY date desc, time desc LIMIT :lim', [ ':lim' => 3 ] );
		return $news;
	}
	
	public static function getNews($page)
	{
		$offset = ($page - 1) * self::LIM;				
        $news = R::findAll('news', 'ORDER BY date desc, time desc LIMIT :lim OFFSET :offset', [ ':lim' => self::LIM , ':offset' => $offset]);
        return $news;
	}
	public static function getNew($id)
	{
		$new = R::load('news', $id);
		return $new;		
	}
	public static function newsCount()
	{
		$count = R::count('news');
		return $count;
	}
	public static function createNew($title, $place, $pic, $date, $time, $newtext)
	{
		$new = R::dispense( 'news' );
		$new->title = $title;
		$new->place = $place;
		$new->pic = $pic;
		$new->date = $date;
		$new->time = $time;
		$new->newtext = $newtext;
		$id = R::store($new);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updateNew($id, $title, $place, $pic, $date, $time, $newtext)
	{
		$new = R::load( 'news', $id );
		$new->title = $title;
		$new->place = $place;
		$new->pic = $pic;
		$new->date = $date;
		$new->time = $time;
		$new->newtext = $newtext;
		$id = R::store($new);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deleteNew($id)
	{
		$new = R::load( 'news', $id );
		$res = R::trash( $new );
		$res = R::findOne('news', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;
		
	}
}