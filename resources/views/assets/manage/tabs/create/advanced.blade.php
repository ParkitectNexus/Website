<div class="alert alert-warning">
	Only alter these settings when you're certain with what you're doing.
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<label for="name">
				Mod dependencies
			</label>

			<p>
				Specify your mod dependencies, the client will download these mods first and add them as compiler references.
			</p>

			@if($resource->type == 'mod')
				<dependency-list identifier="" type="mod"></dependency-list>
			@else
				<p>
					Not available for {{ $resource->type }}
				</p>
			@endif
		</div>
	</div>
</div>