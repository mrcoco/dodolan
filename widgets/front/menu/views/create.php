<div class="inputSet">	
		<div class="label"><span>Navigation</span></div>
		<div class="input">
			<select name="wi_par_id_menu">
				<option value="">Choose One</option>
				<?if($menus = modules::run('nav/getall')):?>
					<?foreach($menus as $menu):?>
				<option value="<?=$menu->id;?>"><?=$menu->name?></option>
					<?endforeach;?>
				<?endif?>
			</select>
		</div>
		<div class="clear"></div>
</div>
<div class="inputSet">	
		<div class="label"><span>Type</span></div>
		<div class="input">
			<select name="wi_par_type">
				<option value="">Choose One</option>
					<?foreach(array('horizontal', 'vertical') as $menu):?>
						<option value="<?=$menu;?>"><?=$menu?></option>
					<?endforeach;?>
			</select>
		</div>
		<div class="clear"></div>
</div>