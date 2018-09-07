<?php
class Banners extends Model
{
	public static function getBanners()
	{
		$banners = R::findAll('banners', 'ORDER BY sort_order');
		return $banners;
	}
	public static function bannersCount()
	{
		$count = R::count('banners');
		return $count;
	}
	public static function getBannersAssoc()
	{
		$banners = R::getAll('select * from banners');
		return $banners;
	}
	public static function getOneBanner($id)
	{
		$banner = R::load('banners', $id);
		return $banner;		
	}
	public static function createBanner($pic, $sort_order)
	{
		$banner = R::dispense( 'banners' );
		$banner->pic = $pic;
		$banner->sort_order = $sort_order;
		$id = R::store($banner);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updateBanner($id, $sort_order)
	{
		$banner = R::load( 'banners', $id );
		$banner->sort_order = $sort_order;
		$id = R::store($banner);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deleteBanner($id)
	{
		$banner = R::load( 'banners', $id );
		$res = R::trash( $banner );
		$res = R::findOne('banners', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;		
	}
}
?>