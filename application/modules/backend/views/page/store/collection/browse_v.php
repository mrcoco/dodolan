<div class="coll_list">
	<?foreach($data as $c):?>
	<div class="collection_snap box2 grid_260 left mr20 mb20">
	<?
	$q= modules::run('store/collection/exe_getById', $c->id);
	$items = $q['ref'];
	$coll = $q['main'];
	?>
	<h3 class="light_shadow"><?=$coll->name?></h3>
	<small>Publish : <?=$this->theme->show_date($coll->p_date)?></small>
		<a href="<?=site_url('backend/store/b_collection/detail/'.$c->id);?>"><img src="<?=site_url('thumb/show/260-100-crop/dir/assets/collection_img/'.$coll->img_path);?>" /></a>
	<span>Items : <?=$items->num_rows()?></span>
	</div>
	<?endforeach?>
	<div class="clear"></div>
</div>