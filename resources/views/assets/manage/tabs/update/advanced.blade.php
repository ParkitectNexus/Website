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

			@if($asset->type == 'mod')
				<dependency-list identifier="{{$asset->identifier}}" type="mod"></dependency-list>
			@else
				<p>
					Not available for {{ $asset->type }}
				</p>
			@endif
		</div>
	</div>
</div>

@section('head')
<script type="text/x-template" id="dependency-list-template">
	<div>

	<h3>Active Dependencies</h3>
	<div class="dependency-list">
		<div v-if="dependencies.length === 0">
			None
		</div>
		<div v-for="(index,dependency) in dependencies" >
			@{{ dependency.name }}
			<input type="hidden" name="dependencies[]" value="@{{ dependency.identifier}}">
			<div class="pull-right">
				<button v-on:click="remove(dependency)" type="button" class="btn btn-default btn-sm btn-danger">Remove</button>
			</div>
		</div>
	</div>
	<h3>Inactive Dependencies</h3>
	<input type="text" class="form-control" placeholder="Search" v-model="assetSearch" debounce="500"  @keyup.enter="updateEntries()" >
	<div class="dependency-list pre-scrollable">
		<div v-for="(index,asset) in assets" >
			@{{ asset.name }}
			<div class="pull-right">
				<button v-on:click="add(asset)"  type="button" class="btn btn-default btn-sm">Add</button>
			</div>
		</div>
	</div>
	</div>
</script>
@append
