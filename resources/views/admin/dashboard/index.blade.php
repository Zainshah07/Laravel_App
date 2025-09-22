@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
Dashboard
@endsection
@section('content')
<div class="row">

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body">
			<div class="media">
				<div class="mr-3 align-self-center">
					<i class="icon-pointer icon-3x text-success-400"></i>
				</div>

				<div class="media-body text-right">
					<h3 class="font-weight-semibold mb-0">{{\App\Models\User::count()}}</h3>
					<span class="text-uppercase font-size-sm text-muted">total users</span>
				</div>
			</div>
		</div>
	</div>


	<div class="col-sm-6 col-xl-3">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0"> {{ \App\Models\User::where('is_active', 1)->count() }}</h3>
					<span class="text-uppercase font-size-sm text-muted">total active users</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-bubbles4 icon-3x text-blue-400"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body">
			<div class="media">
				<div class="mr-3 align-self-center">
					<i class="icon-enter6 icon-3x text-indigo-400"></i>
				</div>

				<div class="media-body text-right">
					<h3 class="font-weight-semibold mb-0">{{\App\Models\Category::count()}}</h3>
					<span class="text-uppercase font-size-sm text-muted">Product Categories</span>
				</div>
			</div>
		</div>
	</div>


	<div class="col-sm-6 col-xl-3">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">{{\App\Models\Product::count()}}</h3>
					<span class="text-uppercase font-size-sm text-muted">total Products</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-bag icon-3x text-danger-400"></i>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
@endsection
